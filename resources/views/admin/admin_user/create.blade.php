@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <x-form-input 
                                        label="Email" 
                                        name="email" 
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Họ" 
                                        name="first_name" 
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Tên" 
                                        name="last_name" 
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Mật khẩu" 
                                        name="password" 
                                        :is-required="true" 
                                    />

                                    <x-form-input 
                                        label="Địa chỉ" 
                                        name="address" 
                                        :is-required="false" 
                                    />

                                    <x-form-select 
                                        label="Trạng thái" 
                                        name="status" 
                                        :options="\App\Enums\AuthStatus::cases()" 
                                        :is-select="true"
                                    />
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary  mr-2">Thêm</button>
                                <a class="btn btn-secondary" href="{{ route('admin.user.index') }}">Đóng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
