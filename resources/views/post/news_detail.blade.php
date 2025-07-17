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
                            <div class="mb-3 d-flex align-items-center">
                                <button
                                    class="btn btn-sm {{ $post->isLikedByUser(auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }} like-btn"
                                    data-post-id="{{ $post->id }}"
                                    data-action="{{ $post->isLikedByUser(auth()->id()) ? route('like.destroy', $post) : route('like.store', $post) }}"
                                    data-method="{{ $post->isLikedByUser(auth()->id()) ? 'DELETE' : 'POST' }}">
                                    <i
                                        class="{{ $post->isLikedByUser(auth()->id()) ? 'fas fa-heart-broken' : 'far fa-heart' }} mr-1"></i>
                                    {{ $post->isLikedByUser(auth()->id()) ? 'Bỏ thích' : 'Thích' }}
                                </button>
                                <span class="text-muted ml-3"><i class="fas fa-heart text-danger mr-1"></i><span
                                        class="like-count">{{ $post->likes->count() }}</span> lượt thích</span>
                            </div>

                            <form id="comment-form" action="{{ route('comment.store', $post) }}" method="POST"
                                class="mb-4">
                                @csrf
                                <div class="form-group">
                                    <label for="commentContent">Bình luận</label>
                                    <textarea id="commentContent" rows="3" class="form-control" name="content"
                                        placeholder="Nhập bình luận của bạn"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-comment-dots mr-1"></i> Gửi bình luận
                                </button>
                            </form>

                            <h5 class="mb-3 text-muted"><i class="far fa-comments mr-1"></i> Bình luận</h5>
                            <div id="comment-container">
                                @forelse ($post->comments as $comment)
                                    <div class="media border rounded p-3 mb-3" data-comment-id="{{ $comment->id }}">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">
                                                <i class="fas fa-user-circle mr-1"></i> {{ $comment->user->name }}
                                                <small class="text-muted">•
                                                    {{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                            </h6>
                                            <p class="mb-1">{{ $comment->content }}</p>
                                            @if (auth()->id() === $comment->user_id)
                                                <button type="button"
                                                    class="btn btn-link text-danger p-0 comment-delete-btn"
                                                    data-action="{{ route('comment.destroy', $comment) }}"
                                                    data-method="DELETE" data-comment-id="{{ $comment->id }}">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Chưa có bình luận nào.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('post.news') }}" class="btn btn-secondary">
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
    <script src="{{ asset('vendor/posts/post_like_comment.js') }}"></script>
@endpush
