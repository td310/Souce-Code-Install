@extends('layout.main')
@section('contents')
<section class="content">
    <div class="container-fluid mt-4">
        <h3 class="mb-3" style="border-left: 4px solid red; padding-left: 10px; font-weight: bold;">TIN MỚI</h3>
        <div id="post-container">
            @include('post.partial.new_list', ['posts' => $posts])
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        
        fetchPosts(page);
    });

    function fetchPosts(page) {
        $.ajax({
            url: "?page=" + page,
            type: "GET",
            success: function (data) {
                $('#post-container').html(data);
            },
            error: function () {
                alert("Lỗi tải data");
            }
        });
    }
</script>
@endpush
