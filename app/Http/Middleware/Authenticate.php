<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // ✅ Correctly handle admin redirect
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login.form'); 
            }

            // ✅ Redirect normal users to login
            return route('user.login.form'); 
        }
    }
}

