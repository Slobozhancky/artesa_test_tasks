<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Перевірка, чи є користувач авторизованим
        if (!$request->session()->has('user')) {
            return redirect('/'); // Перенаправлення на домашню сторінку
        }

        return $next($request);
    }
}
