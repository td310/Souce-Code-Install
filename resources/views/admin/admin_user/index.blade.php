@extends('layout.main')
@section('contents')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách người dùng</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Tạo mới
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <form id="searchForm" class="form-inline">
                                <x-form-input 
                                    label="Tìm kiếm" 
                                    name="search_text" 
                                    id="searchText"
                                    placeholder="Nhập tên hoặc email" 
                                    :is-search="true" 
                                />
                                <x-form-select
                                    label="Trạng thái"
                                    name="status"
                                    id="searchStatus"
                                    :options="\App\Enums\AuthStatus::cases()"
                                    :is-search="true"
                                    :placeholder="'Tất cả'"
                                />
                                <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
                                <button type="button" class="btn btn-secondary mb-2 ml-2" onclick="resetSearch()">Xóa bộ lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="adminUsersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên người dùng</th>
                                        <th>Email</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    const adminUserRoutes = {
        data: @json(route('admin.user.data')),
        toggleLock: (id) => @json(route('admin.user.toggle_lock', ':id')).replace(':id', id),
        show: (id) => @json(route('admin.user.show', ':id')).replace(':id', id),
        edit: (id) => @json(route('admin.user.edit', ':id')).replace(':id', id),
    };
</script>
    <script src="{{ asset('vendor/datatables/admin_user_datatable.js') }}"></script>
@endpush