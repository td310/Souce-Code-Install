@extends('layout.main')
@section('contents')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="tab-pane">
                                <form class="form-horizontal" method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="first_name"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="address"
                                                class="form-control @error('address') is-invalid @enderror" name="address"
                                                placeholder="Address" value="{{ old('address', $user->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-user-edit mr-2"></i>Chỉnh sửa hồ sơ
                                        </button>
                                        <a class="btn btn-secondary" href="{{ route('post.index') }}">Đóng</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif

        @if (session('error'))
            <script>
                alert('{{ session('error') }}');
            </script>
        @endif
    </section>
@endsection
