<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Set locale based on session or fallback locale
        if (session()->has('locale') && array_key_exists(session()->get('locale'), config('languages'))) {
            App::setLocale(session()->get('locale'));
        } else {
            App::setLocale(config('app.fallback_locale'));
        }
       
        // Redirect to respective login page depending on the dashboard URL
       if ($request->is('admin/*')) {
           return $request->expectsJson() ? null : url('admin-login');
        } elseif ($request->is('seller/*')) {
           return $request->expectsJson() ? null : url('seller-login');
        } elseif ($request->is('customer/*')) {
            return $request->expectsJson() ? null : url('user-login');
        }

        // Default redirect if no match
        return $request->expectsJson() ? null : url('index');
    }
}

