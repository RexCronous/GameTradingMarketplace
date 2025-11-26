<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Game Trading Marketplace') }} - @yield('title', 'Dashboard')</title>

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
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 12px 15px;
            font-size: 12px;
            color: #ddd;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            white-space: nowrap;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light gap-3" style="margin-left: 0!important; z-index: 1040;">
            <div class="d-flex align-items-center justify-content-between px-2 py-2 ms-2">
                <a class="" data-widget="pushmenu" href="#" role="button" style="font-size:20px;">
                    <i class="fas fa-bars"></i>
                </a>

                <a href="{{ url('/marketplace') }}" class="d-flex align-items-center mb-0" style="width: auto">
                    <i class="fas fa-gamepad mr-2"
                        style="width:33px;height:33px;display:flex;align-items:center;justify-content:center;"></i>
                    <span class="font-weight-light">{{ config('app.name') }}</span>
                </a>
            </div>
            <ul class="navbar-nav ml-auto">
                @auth
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
                @endauth

                {{-- If user is not logged in --}}
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light ml-2">Register</a>
                    </li>
                @endguest
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                        @auth
                            @if(Auth::user()->isAdmin())
                                <!-- Admin Menu -->
                                <li class="nav-item">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p>Admin Dashboard</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Manage Users</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.items.index') }}"
                                        class="nav-link @if(request()->routeIs('admin.items.*')) active @endif">
                                        <i class="nav-icon fas fa-box"></i>
                                        <p>All Items</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.transactions.index') }}"
                                        class="nav-link @if(request()->routeIs('admin.transactions.*')) active @endif">
                                        <i class="nav-icon fas fa-exchange-alt"></i>
                                        <p>All Transactions</p>
                                    </a>
                                </li>

                                <li class="nav-divider"></li>
                            @endif
                        @endauth

                        <!-- User Menu -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.items.index') }}"
                                class="nav-link @if(request()->routeIs('user.items.*')) active @endif">
                                <i class="nav-icon fas fa-cube"></i>
                                <p>My Items</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('marketplace.index') }}"
                                class="nav-link @if(request()->routeIs('user.marketplace.*')) active @endif">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Marketplace</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.transactions.index') }}"
                                class="nav-link @if(request()->routeIs('user.transactions.*')) active @endif">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Transaction History</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- Footer -->
                <div class="sidebar-footer">
                    © {{ date('Y') }} Game Trading Marketplace
                </div>
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



    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2();
            setTimeout(function () {
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>

    @stack('scripts')

</body>

</html>