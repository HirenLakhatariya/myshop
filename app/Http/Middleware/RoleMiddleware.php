<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::guard('admin')->user();

        // If user is not logged in or role doesn't match, deny access
        if (!$user || !in_array($user->role->name, $roles)) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);

    }
    // Register middleware directly in Laravel 11
    public static function aliases(): array
    {
        return [
            'role' => self::class,
        ];
    }
}
