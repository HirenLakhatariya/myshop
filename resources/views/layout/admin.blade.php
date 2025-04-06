<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sweetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
@php
    $role = auth('admin')->user()->role;
@endphp

<!-- <nav class="navbar">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>

    @if(in_array($role->name, ['Admin', 'Editor', 'User']))
        <a href="{{ route('admin.products') }}">Products</a>
        <a href="{{ route('admin.orders') }}">Orders</a>
    @endif

    @if(in_array($role->name, ['Admin', 'User']))
        <a href="{{ route('admin.contactUs') }}">Contact-Us</a>
        <a href="{{ route('admin.customers') }}">Customers</a>
    @endif

    @if($role->name === 'Admin')
        <a href="{{ route('admin.settings') }}">Settings</a>
        <a href="{{ route('admin.register.form') }}">Register Admin</a>
    @endif

    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-link">Logout</button>
    </form>
</nav> -->

<div class="sidebar-wrapper">
    <div class="sidebar">
        <h2 class="sidebar-title">Admin Panel</h2>

        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>

            @if(in_array($role->name, ['Admin', 'Editor', 'User']))
                <a href="{{ route('admin.products') }}">Products</a>
                <a href="{{ route('admin.orders') }}">Orders</a>
            @endif

            @if(in_array($role->name, ['Admin', 'User']))
                <a href="{{ route('admin.contactUs') }}">Contact-Us</a>
                <!-- <a href="{{ route('admin.customers') }}">Customers</a> -->
            @endif

            {{-- Admin Only --}}
            @if($role->name === 'Admin')
                <!-- <a href="{{ route('admin.settings') }}">Settings</a> -->
                <a href="{{ route('admin.register.form') }}">Register Admin</a>
            @endif

            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </div>
    <div class="main-content" style="flex-grow: 1; padding: 20px;">
        @yield('content')
    </div>
</div>

</body>
</html>
