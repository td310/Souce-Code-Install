@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="col-md-12">
                                    <x-form-input 
                                        label="Tiêu Đề" name="title" 
                                        :value="$post->title"
                                        :is-required="true" 
                                    />

                                    <x-form-textarea 
                                        label="Nội dung" 
                                        name="content" 
                                        :value="strip_tags($post->content, '<p><br><strong><ul><ol><li>')"
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Mô tả" 
                                        name="description" 
                                        :value="$post->description" 
                                        :is-required="false"
                                    />
                                    <x-form-date-picker 
                                        label="Ngày xuất bản" 
                                        name="publish_date" 
                                        :value="$post->publish_date" 
                                        :is-required="true"
                                    />

                                    <x-form-attachment 
                                        label="Đính kèm" 
                                        name="file" 
                                        :preview=true 
                                        :preview-url="$post->thumbnail" 
                                        :is-required="true"
                                    />
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                                <a class="btn btn-secondary" href="{{ route('post.index') }}">Đóng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
