<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Game Trading Marketplace') }} - @yield('title', 'Dashboard')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .content-wrapper {
            background-color: #ecf0f5;
        }
        .card {
            border-radius: 0.5rem;
        }
        .item-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">
                    <strong>{{ config('app.name') }}</strong>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-shield-alt mr-2"></i> Admin Panel
                        </a>
                        <div class="dropdown-divider"></div>
                    @endif
                    <a href="{{ route('user.profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-circle mr-2"></i> My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ url('/') }}" class="brand-link">
            <i class="fas fa-gamepad brand-image img-circle elevation-3" style="width: 33px; height: 33px; display: flex; align-items: center; justify-content: center;"></i>
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    @if(Auth::user()->isAdmin())
                        <!-- Admin Menu -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Admin Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.items.index') }}" class="nav-link @if(request()->routeIs('admin.items.*')) active @endif">
                                <i class="nav-icon fas fa-box"></i>
                                <p>All Items</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.transactions.index') }}" class="nav-link @if(request()->routeIs('admin.transactions.*')) active @endif">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>All Transactions</p>
                            </a>
                        </li>

                        <li class="nav-divider"></li>
                    @endif

                    <!-- User Menu -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.items.index') }}" class="nav-link @if(request()->routeIs('user.items.*')) active @endif">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>My Items</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.marketplace.index') }}" class="nav-link @if(request()->routeIs('user.marketplace.*')) active @endif">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Marketplace</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.transactions.index') }}" class="nav-link @if(request()->routeIs('user.transactions.*')) active @endif">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Transaction History</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.profile.edit') }}" class="nav-link @if(request()->routeIs('user.profile.*')) active @endif">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title')</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="container-fluid">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Errors!</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Game Trading Marketplace &copy; {{ date('Y') }} </strong>
    </footer>

</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/adminlte.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<script>
    $(function() {
        $('.select2').select2();
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    });
</script>

@stack('scripts')

</body>
</html>
