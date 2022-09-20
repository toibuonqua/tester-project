<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Throwable;
use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;

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
            $user = Accounts::with('role')->find(Auth::id());
            if ($user->isAdmin()){
                return $next($request);
            }
            return redirect()->route('newam.homepage')->with('error', 'Cấp độ tài khoản không có quyền truy cập');
        }
        catch(Throwable $e)
        {
            $request->session()->flush();
            return redirect()->route('home');
        }
    }
}
