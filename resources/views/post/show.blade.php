@extends('layout.main')
@section('contents')
<section class="content">
    <h3>{{$post->user->name}}</h3>
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-file-alt mr-1"></i> {{ $post->title }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="text-muted">Mô tả</h5>
                            <p>{{ $post->description }}</p>
                        </div>

                        <div>
                            <h5 class="text-muted">Nội dung</h5>
                            <div class="border p-3" style="white-space: pre-line;">
                                {!! strip_tags($post->content, '<p><br><strong><em><ul><ol><li><a>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('post.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
                        </a>
                        <a href="{{ route('post.edit', $post) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Chỉnh sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
