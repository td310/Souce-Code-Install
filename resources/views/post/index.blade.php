@extends('layout.main')
@section('contents')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách bài viết</h1>
            </div>
            <div class="col-sm-6">
                <a href="#" class="btn btn-success float-right">
                    <i class="fas fa-plus"></i> Tạo mới
                </a>
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
