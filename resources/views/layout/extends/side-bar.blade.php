<a href="{{ route('news') }}" class="brand-link">
    <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('news') }}"
                    class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-rss"></i>
                    <p>Tin tức</p>
                </a>
            </li>            
            @auth
                @can('adminAccess', Auth::user())
                    <li class="nav-item">
                        <a href="{{ route('admin.post.index') }}"
                            class="nav-link {{ request()->routeIs('admin.post.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Quản lý bài viết</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Quản lý người dùng</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('post.index') }}"
                            class="nav-link {{ request()->routeIs('post.*') && !request()->routeIs('post.news*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Bài viết</p>
                        </a>
                    </li>
                @endcan
            @endauth
        </ul>
    </nav>
</div>