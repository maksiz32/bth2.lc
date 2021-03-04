<?php
namespace App\Http\Middleware;

use Closure;

class checkUser
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'user') {
        return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
