@extends('layout.admin')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
        <h2 class="text-center mb-4 text-primary">Admin Registration</h2>

        <form method="POST" action="{{ route('admin.register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Select Role</label>
                <select name="role_id" id="role_id" class="form-select" required>
                    <option value="">-- Choose Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</div>

@endsection

