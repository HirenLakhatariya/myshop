<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sweetshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.products') }}">Products</a>
        <a href="{{ route('admin.orders') }}">Orders</a>
        <a href="{{ route('admin.customers') }}">Customers</a>
        <a href="{{ route('admin.settings') }}">Settings</a>
    </nav>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
