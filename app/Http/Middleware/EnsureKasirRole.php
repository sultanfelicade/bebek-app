<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureKasirRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::get('role') !== 'kasir') {
            return redirect('/login')->with('error', 'Akses hanya untuk kasir. Silakan login dengan akun kasir.');
        }

        return $next($request);
    }
}