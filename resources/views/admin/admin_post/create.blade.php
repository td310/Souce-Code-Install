@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <x-form-input 
                                        label="Tiêu Đề" 
                                        name="title" 
                                        :is-required="true" 
                                    />

                                    <x-form-textarea 
                                        label="Nội dung" 
                                        name="content" 
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Mô tả" 
                                        name="description" 
                                        :is-required="false" 
                                    />

                                    <x-form-date-picker 
                                        label="Ngày xuất bản" 
                                        name="publish_date" 
                                        :is-required="true" 
                                    />

                                    <x-form-select 
                                        label="Trạng thái" 
                                        name="status" 
                                        :options="\App\Enums\PostStatus::cases()" 
                                        :is-select="true"
                                    />

                                    <x-form-attachment 
                                        label="Đính kèm" 
                                        name="file" 
                                        :preview="false"
                                    />

                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary  mr-2">Thêm</button>
                                <a class="btn btn-secondary" href="{{ route('admin.post.index') }}">Đóng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
