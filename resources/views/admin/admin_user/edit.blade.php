@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <form action="{{ route('admin.user.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="col-md-12">
                                    <x-form-input 
                                    label="Email" 
                                    name="email" 
                                    :is-required="true"
                                    :value="$user->email" 
                                    />

                                    <x-form-input 
                                        label="Họ" 
                                        name="first_name" 
                                        :is-required="true" 
                                        :value="$user->first_name"
                                    />

                                    <x-form-input 
                                        label="Tên" 
                                        name="last_name" 
                                        :is-required="true" 
                                        :value="$user->last_name"
                                    />

                                    <x-form-input 
                                        label="Địa chỉ" 
                                        name="address" 
                                        :is-required="false" 
                                        :value="$user->address"
                                    />

                                    <x-form-select 
                                        label="Trạng thái" 
                                        name="status" 
                                        :options="\App\Enums\AuthStatus::cases()" 
                                        :value="$user->status->value"
                                    />
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary  mr-2">Cập nhật</button>
                                <a class="btn btn-secondary" href="{{ route('admin.user.index') }}">Đóng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
