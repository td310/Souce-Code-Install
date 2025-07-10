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
                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Họ <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                                    value="{{ old('first_name') }}">
                                                @error('first_name')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Tên <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                                    value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                                    value="{{ old('password') }}">
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Địa chỉ</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address" value="{{ old('address') }}">
                                                @error('address')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row align-items-center mb-2">
                                            <label class="col-sm-3 col-form-label">Trạng thái</label>
                                            <div class="col-sm-9">
                                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                                    <option value="" disabled selected>Chọn trạng thái</option>
                                                    @foreach(App\Enums\AuthStatus::cases() as $status)
                                                        <option value="{{ $status->value }}">
                                                            {{ $status->label() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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
