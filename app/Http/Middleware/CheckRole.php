<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $role = Auth::user()->role->name;
            if ($role == 'Admin/IT'){
                return $next($request);
            }
            else
            {
                return redirect()->route('newam.homepage')->with('error', 'Cấp độ tài khoản không có quyền truy cập');
            }
        }
        catch(Throwable $e)
        {
            $request->session()->flush();
            return redirect()->route('home');
        }
    }
}
