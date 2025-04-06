<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::fallback(function (Request $request) {
            if ($request->is('admin/*')) {
                return Redirect::route('admin.login.form'); // Redirect admin users to login
            }
            abort(404);
        });

        Paginator::useBootstrapFive();
    }
}
