@extends('layout.main')
@section('contents')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách bài viết</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.post.create') }}" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Tạo mới
                    </a>
                    <button type="button" class="btn btn-danger float-right mr-2" onclick="confirmDeleteAll()">
                        <i class="fas fa-trash-alt"></i> Xóa tất cả
                    </button>
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
                                    placeholder="Nhập tiêu đề hoặc email" 
                                    :is-search="true" 
                                />
                                <x-form-select
                                    label="Trạng thái"
                                    name="status"
                                    id="searchStatus"
                                    :options="\App\Enums\PostStatus::cases()"
                                    :is-search="true"
                                    :placeholder="'Tất cả'"
                                />
                                <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
                                <button type="button" class="btn btn-secondary mb-2 ml-2" onclick="resetSearch()">Xóa bộ
                                    lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="adminPostsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Hình ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Ngày xuất bản</th>
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
        const adminPostRoutes = {
            data: @json(route('admin.post.data')),
            deleteAll: @json(route('admin.post.delete_all')),
            show: (id) => @json(route('admin.post.show', ':id')).replace(':id', id),
            edit: (id) => @json(route('admin.post.edit', ':id')).replace(':id', id),
            delete: (id) => @json(route('admin.post.destroy', ':id')).replace(':id', id)
        };
    </script>
    <script src="{{ asset('vendor/datatables/admin_post_datatable.js') }}"></script>
@endpush
