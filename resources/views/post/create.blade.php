@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Tiêu Đề <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                                                    value="{{ old('title') }}">
                                                @error('title')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Nội dung <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>
                                                @error('content')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Mô tả</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}">
                                                @error('description')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Ngày xuất bản</label>
                                            <div class="col-sm-9">
                                                <div class="input-group date" id="publish_date" data-target-input="nearest">
                                                    <input type="text"
                                                        class="form-control datetimepicker-input @error('publish_date') is-invalid @enderror"
                                                        data-target="#publish_date" name="publish_date"
                                                        value="{{ old('publish_date') }}" />
                                                    <div class="input-group-append" data-target="#publish_date"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    @error('publish_date')
                                                        <span class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Đính kèm</label>
                                            <div class="col-sm-9 input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileInput"
                                                        name="file">
                                                    <label class="custom-file-label" for="fileInput">Chọn tệp đính
                                                        kèm</label>
                                                </div>
                                            </div>
                                        </div>
                                        <img id="thumbnailPreview" style="max-width: 150px; display: none;"
                                            class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary  mr-2">Thêm</button>
                                <a class="btn btn-secondary" href="{{ route('post.index') }}">Đóng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
