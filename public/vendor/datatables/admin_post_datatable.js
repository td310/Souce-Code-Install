$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var table = $('#adminPostsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/post/data',
            type: 'GET'
        },
        pageLength: 5,
        lengthMenu: [[5, 10, 25], [5, 10, 25]],
        columns: [
            { data: 'email', name: 'email', searchable: true },
            {
                data: 'thumbnail',
                name: 'thumbnail',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return data ? `<img src="${data}" alt="thumbnail" style="max-width: 50px;">` : '<span>Không có ảnh</span>';
                }
            },
            { data: 'title', name: 'title', searchable: true },
            { data: 'description', name: 'description', searchable: false },
            {
                data: 'publish_date',
                name: 'publish_date',
                orderable: true,
                render: function (data) {
                    return data ? data : 'Chưa có ngày xuất bản';
                }
            },
            { data: 'status_label', name: 'status' },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (row) {
                    return `
                        <div class="btn-group">
                            <a href="/admin/post/${row.id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="/admin/post/${row.id}/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        order: [[4, 'desc']],
        language: {
            processing: 'Đang xử lý...',
            search: 'Tìm kiếm:',
            lengthMenu: 'Hiển thị _MENU_ bản ghi',
            info: 'Hiển thị từ _START_ đến _END_ trong _TOTAL_ bản ghi',
            infoEmpty: 'Hiển thị 0 đến 0 trong 0 bản ghi',
            loadingRecords: 'Đang tải...',
            emptyTable: 'Không có dữ liệu trong bảng',
            paginate: { previous: 'Trước', next: 'Sau' }
        }
    });

    window.confirmDelete = function (id, isAll = false) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: isAll ? 'Bạn muốn xóa tất cả bài viết?' : 'Bạn muốn xóa bài viết này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: isAll ? 'Xóa tất cả' : 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: isAll ? '/admin/post/delete-all' : `/admin/post/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Đã xóa!', isAll ? 'Xóa tất cả bài viết thành công' : 'Xóa bài viết thành công', 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', 'Xóa bài viết thất bại', 'error');
                        }
                    }
                });
            }
        });
    };

    window.confirmDeleteAll = function () {
        confirmDelete(null, true);
    };
});