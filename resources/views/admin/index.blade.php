@extends('layout.main')
@section('contents')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách bài viết</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('post.create') }}" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i> Tạo mới
                    </a>
                    <form id="deleteAllForm" action="{{ route('post.delete_all') }}" method="POST" class="float-right mr-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('deleteAllForm')">
                            <i class="fas fa-trash-alt"></i> Xóa tất cả
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush