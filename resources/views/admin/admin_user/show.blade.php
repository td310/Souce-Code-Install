@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="col-md-12">
                                <x-form-input 
                                    label="Email" 
                                    name="email" 
                                    :is-required="true"
                                    :value="$user->email" 
                                    :is-disabled="true"
                                />

                                <x-form-input 
                                    label="Họ" 
                                    name="first_name" 
                                    :is-required="true" 
                                    :value="$user->first_name"
                                    :is-disabled="true"
                                />

                                <x-form-input 
                                    label="Tên" 
                                    name="last_name" 
                                    :is-required="true" 
                                    :value="$user->last_name"
                                    :is-disabled="true"
                                />

                                <x-form-input 
                                    label="Địa chỉ" 
                                    name="address" 
                                    :is-required="false" 
                                    :value="$user->address"
                                    :is-disabled="true"
                                />

                                <x-form-select 
                                    label="Trạng thái" 
                                    name="status" 
                                    :options="\App\Enums\AuthStatus::cases()" 
                                    :value="$user->status->value"
                                    :is-disabled="true"
                                />
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a class="btn btn-secondary" href="{{ route('admin.user.index') }}">Đóng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
