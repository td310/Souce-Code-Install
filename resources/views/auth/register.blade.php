<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>
                <form method="POST" action="{{ route('auth.register.post') }}">
                    @csrf
                    <x-form-input 
                        label="Họ" 
                        name="first_name" 
                        type="text" 
                        :value="old('first_name')" 
                        :is-required="true" 
                        :is-login="true" 
                        placeholder="Nhập Họ" 
                        icon="fas fa-user"
                    />

                    <x-form-input 
                        label="Tên" 
                        name="last_name" 
                        type="text" 
                        :value="old('last_name')" 
                        :is-required="true" 
                        :is-login="true" 
                        placeholder="Nhập Tên" 
                        icon="fas fa-user"
                    />

                    <x-form-input 
                        label="Email" 
                        name="email" 
                        type="text" 
                        :value="old('email')" 
                        :is-required="true" 
                        :is-login="true" 
                        placeholder="Nhập email" 
                        icon="fa-envelope"
                    />

                    <x-form-input 
                        label="Mật khẩu" 
                        name="password" 
                        type="password" 
                        :is-required="true" 
                        :is-login="true" 
                        placeholder="Nhập mật khẩu" 
                        icon="fa-lock"
                    />

                    <x-form-input 
                        label="Xác nhận mật khẩu" 
                        name="password_confirmation" 
                        type="password" 
                        :is-required="true" 
                        :is-login="true" 
                        placeholder="Nhập xác thực mật khẩu" 
                        icon="fa-lock"
                    />
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <a href="{{ route('auth.login') }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        I already have a membership
                    </a>
                </div>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
