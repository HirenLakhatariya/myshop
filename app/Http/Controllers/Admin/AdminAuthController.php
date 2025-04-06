<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\AdminUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\admin\Role;

class AdminAuthController extends Controller
{
    public function showRegister()
    {
        $roles = Role::all(); // Fetch all roles from the database
        return view('admin.auth.register', compact('roles'));
    }
    

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id', // Ensure role exists
        ]);
    
        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Assign selected role
        ]);
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Already logged in
        }
        return redirect()->route('admin.auth.login')->with('success', 'Registration successful.');
    }
    
    

    public function showLogin()
    {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Already logged in
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
