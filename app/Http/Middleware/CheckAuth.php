<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('unauthorized', 'Bạn cần đăng nhập để truy cập trang này.');
        }
    
        $userRole = Auth::user()->role;

        // Kiểm tra xem vai trò của người dùng có nằm trong danh sách vai trò cho phép không
        if (!in_array($userRole, $roles)) {
            return redirect()->route('home')->with('unauthorized', 'Bạn không có quyền truy cập trang này.');
        }
    
        return $next($request);

    }
}
