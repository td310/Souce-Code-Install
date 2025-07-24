@foreach ($posts as $post)
    <div class="row mb-3 pb-3 border-bottom">
        <div class="col-md-4">
            <a href="{{ route('news.detail', $post->slug) }}">
                @if ($post->thumbnail)
                    <img src="{{ $post->thumbnail }}" alt="Thumbnail" class="img-fluid" style="width: 100%; height: auto;">
                @else
                    <img alt="Thumbnail Post" class="img-fluid" style="width: 100%; height: auto;">
                @endif
            </a>
        </div>
        <div class="col-md-8">
            <h5 style="font-weight: bold;">
                <a href="{{ route('news.detail', $post->slug) }}" class="text-dark">
                    {{ $post->title }}
                </a>
            </h5>
            <small class="text-muted d-block mb-2">
                {{ $post->publish_date }}
            </small>
            <p style="margin-bottom: 0;">
                {{ $post->description }}
            </p>
            <span class="text-muted"><i class="fas fa-heart text-danger mr-1"></i>{{ $post->likes->count() }} lượt thích</span>
        </div>
    </div>
@endforeach

<div class="d-flex justify-content-center mt-4">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>