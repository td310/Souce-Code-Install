@extends('layout.main')
@section('contents')
    <section class="content">
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
                                    {!! strip_tags($post->content, '<p><br><strong><em><ul><ol><li>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top">
                            @auth
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <button
                                            class="btn btn-sm {{ $post->isLikedByUser(auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }} like-btn"
                                            data-post-id="{{ $post->id }}"
                                            data-action="{{ $post->isLikedByUser(auth()->id()) ? route('like.destroy', $post) : route('like.store', $post) }}"
                                            data-method="{{ $post->isLikedByUser(auth()->id()) ? 'DELETE' : 'POST' }}">
                                            <i
                                                class="{{ $post->isLikedByUser(auth()->id()) ? 'fas fa-heart-broken' : 'far fa-heart' }} mr-1"></i>
                                            {{ $post->isLikedByUser(auth()->id()) ? 'Bỏ thích' : 'Thích' }}
                                        </button>
                                    </div>
                                    <div class="text-muted">
                                        <i class="fas fa-heart text-danger mr-1"></i>
                                        <span class="like-count">{{ $post->likes->count() }}</span> lượt thích
                                    </div>
                                </div>

                                <form id="comment-form" action="{{ route('comment.store', $post) }}" method="POST"
                                    class="mb-4">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <textarea id="commentContent" rows="3" class="form-control" name="content" placeholder="Nhập bình luận"></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-comment-dots mr-1"></i> Gửi
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Vui lòng <a href="{{ route('auth.login') }}">đăng nhập</a> để thích hoặc bình luận bài
                                    viết.
                                </div>
                            @endauth

                            <h6 class="text-muted mb-3"><i class="far fa-comments mr-1"></i> Bình luận</h6>
                            <div id="comment-container"></div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('news') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách tin tức
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        const commentRoutes = {
            store: (postId) => @json(route('comment.store', ':post')).replace(':post', postId),
            data: (postId) => @json(route('comment.data_comment', ':post')).replace(':post', postId),
            destroy: (commentId) => @json(route('comment.destroy', ':comment')).replace(':comment', commentId)
        };
    </script>
    <script src="{{ asset('vendor/posts/post_like_comment.js') }}"></script>
@endpush
