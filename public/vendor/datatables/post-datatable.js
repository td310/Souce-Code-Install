$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#postsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/post/data',
            type: 'GET',
        },
        pageLength: 5,
        lengthMenu: [[5, 10, 25], [5, 10, 25]],
        columns: [
            {
                data: 'thumbnail',
                name: 'thumbnail',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return data ? '<img src="' + data + '" alt="thumbnail" style="max-width: 50px;">' : '<span>Không có ảnh</span>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            {
                data: 'publish_date', name: 'publish_date',
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
                            <a href="/post/${row.id}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/post/${row.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="deleteForm${row.id}" action="/post/${row.id}" method="POST"">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm${row.id}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>`;
                }
            }
        ],
        order: [[3, 'desc']],
        language: {
            processing: "Đang xử lý...",
            search: "Tìm kiếm:",
            lengthMenu: "Hiển thị _MENU_ bản ghi",
            info: "Hiển thị từ _START_ đến _END_ trong _TOTAL_ bản ghi",
            infoEmpty: "Hiển thị 0 đến 0 trong 0 bản ghi",
            loadingRecords: "Đang tải...",
            zeroRecords: "Không tìm thấy bản ghi nào",
            emptyTable: "Không có dữ liệu trong bảng",
            paginate: {
                previous: "Trước",
                next: "Sau",
            },
            aria: {
                sortAscending: ": kích hoạt để sắp xếp cột tăng dần",
                sortDescending: ": kích hoạt để sắp xếp cột giảm dần"
            }
        }
    });

    window.confirmDelete = function (formId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn muốn xóa bài viết này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $('#' + formId).attr('action'),
                    type: 'POST',
                    data: $('#' + formId).serialize(),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Đã xóa!', 'Xóa bài viết thành công', 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', 'Xóa bài viết thất bại', 'error');
                        }
                    }                    
                });
            }
        });
    };

    window.confirmDeleteAll = function (formId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn muốn xóa tất cả bài viết?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa tất cả',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $('#' + formId).attr('action'),
                    type: 'POST',
                    data: $('#' + formId).serialize(),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Đã xóa!', 'Xóa bài viết thành công', 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', 'Xóa bài viết thất bại', 'error');
                        }
                    }
                });
            }
        });
    };
});