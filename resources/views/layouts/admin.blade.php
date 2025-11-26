<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GameTradingMarketplace') }} - Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-secondary">Logout</button></form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/admin" class="brand-link">
            <span class="brand-text font-weight-light">{{ config('app.name') }} Admin</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                    <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Users</p></a></li>
                    <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link"><i class="nav-icon fas fa-user-shield"></i><p>Roles</p></a></li>
                    <li class="nav-item"><a href="{{ route('transactions.index') }}" class="nav-link"><i class="nav-icon fas fa-exchange-alt"></i><p>Transactions</p></a></li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>@yield('title', 'Admin')</h1></div></div></div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer"><div class="float-right d-none d-sm-inline">v1</div><strong>&copy; {{ date('Y') }} {{ config('app.name') }}</strong></footer>
</div>
@vite(['resources/js/app.js'])
</body>
</html>
