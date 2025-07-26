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
                    $('#commentContent').addClass('is-invalid');
                    $('#commentContent').next('.invalid-feedback').remove();
                    $('#commentContent').after('<span class="error invalid-feedback">' + errors.content[0] + '</span>');
                }
            }
        }
    });
}

function renderComment(comment, level = 0) {
    let margin = level * 15;
    let commentHtml = `
        <div class="media border rounded p-3 mb-3" data-comment-id="${comment.id}" style="margin-left: ${margin}px;">
            <i class="fas fa-user-circle fa-2x mr-3 text-secondary"></i>
            <div class="media-body">
                <h6 class="mt-0 mb-1">
                    ${comment.user_name}
                    <small class="text-muted ml-2">• ${comment.created_at}</small>
                </h6>
                <p class="mb-2">${comment.content}</p>
                <div class="d-flex">
                    <button class="btn btn-link text-primary p-0 reply-btn mr-3" data-comment-id="${comment.id}">
                        <i class="fas fa-reply"></i> Trả lời
                    </button>
                    ${comment.can_delete ? `
                        <button class="btn btn-link text-danger p-0 comment-delete-btn"
                                data-action="${commentRoutes.destroy(comment.id)}"
                                data-method="DELETE"
                                data-comment-id="${comment.id}">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    ` : ''}
                </div>
                <div class="reply-form-container" style="display: none;"></div>
                <div class="children-container">
                    ${comment.children ? comment.children.map(child => renderComment(child, level + 1)).join('') : ''}
                </div>
            </div>
        </div>`;
    return commentHtml;
}

function loadComments(postId) {
    sendAjaxRequest(commentRoutes.data(postId), 'GET', {}, function (response) {
        $('#comment-container').empty();
        response.forEach(comment => {
            $('#comment-container').prepend(renderComment(comment));
        });
    });
}

$(document).ready(function () {
    let postId = $('.like-btn').data('post-id');
    if (postId) loadComments(postId);

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

    //Comment
    $('#comment-form').on('submit', function (e) {
        e.preventDefault();
        var url = $('#comment-form').attr('action');
        var data = $(this).serialize();

        sendAjaxRequest(url, 'POST', data, function (response) {
            if (response.comment) {
                $('#comment-container').prepend(renderComment(response.comment));
                $('#commentContent').val('');
            }
        });
    });

    //Reply comment
    $(document).on('click', '.reply-btn', function () {
        let commentId = $(this).data('comment-id');
        let container = $(this).closest('.media').find('.reply-form-container');
        let formHtml = `
            <form class="reply-form mt-2" data-parent-id="${commentId}">
                <div class="form-group mb-2">
                    <textarea class="form-control reply-content" rows="2" name="content" placeholder="Nhập trả lời"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-reply">Hủy</button>
                </div>
            </form>`;
        container.html(formHtml).show();
        $(this).hide();
    });

    $(document).on('click', '.cancel-reply', function () {
        let container = $(this).closest('.reply-form-container');
        container.hide().empty();
        container.closest('.media').find('.reply-btn').show();
    });

    $(document).on('submit', '.reply-form', function (e) {
        e.preventDefault();
        let parentId = $(this).data('parent-id');
        let content = $(this).find('.reply-content').val();
        let url = $('#comment-form').attr('action');

        sendAjaxRequest(url, 'POST', { content: content, parent_id: parentId }, function (response) {
            if (response.comment) {
                let commentHtml = renderComment(response.comment, $(`[data-comment-id="${parentId}"]`).parents('.media').length + 1);
                $(`[data-comment-id="${parentId}"] .children-container`).prepend(commentHtml);
                $(`[data-comment-id="${parentId}"] .reply-form-container`).hide().empty();
                $(`[data-comment-id="${parentId}"] .reply-btn`).show();
            }
        });
    });

    $(document).on('click', '.comment-delete-btn', function (e) {
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
                sendAjaxRequest(commentRoutes.destroy(commentId), 'DELETE', {}, function (response) {
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