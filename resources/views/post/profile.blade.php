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
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-user-edit mr-2"></i>Chỉnh sửa hồ sơ
                                        </button>
                                        @can('adminAccess', Auth::user())
                                            <a class="btn btn-secondary" href="{{ route('admin.user.index') }}">Đóng</a>
                                        @else
                                            <a class="btn btn-secondary" href="{{ route('post.index') }}">Đóng</a>
                                        @endcan
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
