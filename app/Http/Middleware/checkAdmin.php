<?php
namespace App\Http\Middleware;

use Closure;

class checkAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
