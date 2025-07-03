@extends('layout.main')
@section('contents')
<section class="content">
    <div class="container-fluid mt-4">
        <h3 class="mb-3" style="border-left: 4px solid red; padding-left: 10px; font-weight: bold;">TIN MỚI</h3>

        @foreach ($post as $posts)
            <div class="row mb-3 pb-3 border-bottom">
                <div class="col-md-4">
                    <a href="">
                        @if ($posts->thumbnail)
                            <img src="{{ $posts->thumbnail }}" alt="Thumbnail" class="img-fluid" style="width: 100%; height: auto;">
                        @else
                            No Image Available
                        @endif
                    </a>
                </div>
                <div class="col-md-8">
                    <h5 style="font-weight: bold;">
                        <a href="{{ route('post.news_detail', $posts->slug) }}" class="text-dark">
                            {{ $posts->title }}
                        </a>
                    </h5>
                    <small class="text-muted d-block mb-2">
                        {{ $posts->published_at }}
                    </small>
                    <p style="margin-bottom: 0;">
                        {{ $posts->description }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection