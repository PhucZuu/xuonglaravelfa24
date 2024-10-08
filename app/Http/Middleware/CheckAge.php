<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            $age = Auth::user()->age;
    
            if($age >= 18){
                return $next($request);
            }
    
            return redirect()->route('home')->with('FPIwarning','Bạn vẫn chưa đủ 18 tuổi để vào xem phim');
        }

        return redirect()->route('login');
    }
}
