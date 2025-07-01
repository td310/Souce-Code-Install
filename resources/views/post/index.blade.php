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
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Publish Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                @if ($post->thumbnail)
                                                    <img src="{{ $post->thumbnail }}" alt="thumbnail"
                                                        style="max-width: 50px;">
                                                @else
                                                    <span>No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->description }}</td>
                                            <td>
                                                @if ($post->publish_date)
                                                    {{ $post->publish_date }}
                                                @else
                                                    <span>No Publish Date</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $post->status_label }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('post.show', $post) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('post.edit', $post) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="deleteForm{{ $post->id }}" action="{{ route('post.destroy', $post) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $post->id }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $posts->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif
@endsection
