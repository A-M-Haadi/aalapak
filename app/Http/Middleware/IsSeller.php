<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsSeller
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && 
            Auth::user()->role == 'seller' && 
            Auth::user()->store_status == 'approved') 
        {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->role == 'seller') {
            return redirect()->route('seller.pending'); 
        }

        abort(403, 'Unauthorized Access');
    }

}