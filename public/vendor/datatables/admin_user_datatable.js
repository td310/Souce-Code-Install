$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var table = $('#adminUsersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/user/data',
            type: 'GET'
        },
        pageLength: 5,
        lengthMenu: [[5, 10, 25], [5, 10, 25]],
        columns: [
            { data: 'name', name: 'name', searchable: true },
            { data: 'email', name: 'email', searchable: true },
            { 
                data: 'address', 
                name: 'address', 
                searchable: false,
                render: function (data) {
                    return data ? data : 'Chưa có địa chỉ';
                }
            },
            { data: 'status_label', name: 'status', searchable: false },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (row) {
                    return `
                        <div class="btn-group">
                            <a href="/admin/user/${row.id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="/admin/user/${row.id}/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        order: [[0, 'desc']],
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

    window.confirmDelete = function (id) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn muốn xóa người dùng này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`/admin/user/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Đã xóa!', 'Xóa người dùng thành công', 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', 'Xóa người dùng thất bại', 'error');
                        }
                    }
                });
            }
        });
    };
});