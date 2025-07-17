$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function sendAjaxRequest(url, method, data, onSuccess) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function (response) {
            onSuccess(response);
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                if (errors.content) {
                    $('#commentContent')
                        .addClass('is-invalid');
                    $('#commentContent').next('.invalid-feedback').remove();
                    $('#commentContent')
                        .after('<span class="error invalid-feedback">' + errors.content[0] + '</span>');
                }
            }
        }
    });
}

$(document).ready(function () {
    $(document).on('click', '.like-btn', function (e) {
        e.preventDefault();
        var button = $(this);
        var url = button.data('action');
        var method = button.data('method');

        sendAjaxRequest(url, method, {}, function (response) {
            if (response.is_liked) {
                button
                    .removeClass('btn-outline-danger')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-heart-broken mr-1"></i> Bỏ thích')
                    .data('action', button.data('action').replace('like', 'unlike'))
                    .data('method', 'DELETE');
            } else {
                button
                    .removeClass('btn-danger')
                    .addClass('btn-outline-danger')
                    .html('<i class="far fa-heart mr-1"></i> Thích')
                    .data('action', button.data('action').replace('unlike', 'like'))
                    .data('method', 'POST');
            }
            $('.like-count').text(response.like_count);
        });
    });

    $('#comment-form').on('submit', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();

        sendAjaxRequest(url, 'POST', data, function (response) {
            if (response.comment) {
                var commentHtml = `
                    <div class="media border rounded p-3 mb-3" data-comment-id="${response.comment.id}">
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">
                                <i class="fas fa-user-circle mr-1"></i> ${response.comment.user_name}
                                <small class="text-muted">• ${response.comment.created_at}</small>
                            </h6>
                            <p class="mb-1">${response.comment.content}</p>
                            ${response.comment.can_delete ? `
                                <button class="btn btn-link text-danger p-0 comment-delete-btn" 
                                        data-action="/comment/${response.comment.id}" 
                                        data-method="DELETE" 
                                        data-comment-id="${response.comment.id}">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            ` : ''}
                        </div>
                    </div>`;
                $('#comment-container').append(commentHtml);
                $('#commentContent').val('');
            }
        });
    });
    
    $(document).on('click', '.btn-link', function (e) {
        e.preventDefault();
        var button = $(this);
        var commentId = button.data('comment-id');

        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn muốn xóa bình luận này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                sendAjaxRequest(`/comment/${commentId}`, 'DELETE', {}, function (response) {
                    if (response.success) {
                        Swal.fire('Đã xóa!', 'Xóa bình luận thành công', 'success');
                        $(`[data-comment-id="${commentId}"]`).remove();
                    } else {
                        Swal.fire('Thất bại!', 'Xóa bình luận thất bại', 'error');
                    }
                });
            }
        });
    });
});