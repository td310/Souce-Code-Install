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
            { 
                data: 'status_label', 
                name: 'status', 
                searchable: false,
                render: function (data, type, row) {
                    return row.status_user === 'LOCKED' 
                        ? `<i class="fas fa-lock text-danger"></i> ${data}`
                        : `<i class="fas fa-unlock text-success"></i> ${data}`;
                }
            },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (row) {
                    let actions = `
                        <div class="btn-group">
                            <a href="/admin/user/${row.id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                    `;
                    if (!row.is_admin) {
                        actions += `
                            <a href="/admin/user/${row.id}/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-sm ${row.status_user === 'LOCKED' ? 'btn-danger' : 'btn-success'}" 
                                onclick="toggleLock(${row.id}, '${row.status_user}')">
                                <i class="fas ${row.status_user === 'LOCKED' ? 'fa-lock' : 'fa-unlock'}"></i>
                            </button>
                        `;
                    }
                    actions += `</div>`;
                    return actions;
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

    window.toggleLock = function (id, status_user) {
        Swal.fire({
            title: status_user === 'LOCKED' ? 'Bạn có chắc chắn mở khóa tài khoản này?' : 'Bạn có chắc chắn khóa tài khoản này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: status_user === 'LOCKED' ? 'Mở khóa' : 'Khóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/user/${id}/toggle-lock`,
                    type: 'PUT',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Thành công!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', response.message, 'error');
                        }
                    }
                });
            }
        });
    };
});