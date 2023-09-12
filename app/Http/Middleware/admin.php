<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class admin
{
    public function handle(Request $request, Closure $next)
    {

        if (session('akun')['role'] == 'admin') {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
