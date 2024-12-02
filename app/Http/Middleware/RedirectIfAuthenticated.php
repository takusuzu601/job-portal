<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        // 以下のコードでログイン中にLOGINページやREGISTERページには行けなくなる
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if($guard==='admin'){
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                }
                elseif($request->user()->role==='company'){
                    return redirect(RouteServiceProvider::COMPANY_DASHBOARD);
                }elseif($request->user()->role==='candidate'){
                    return redirect(RouteServiceProvider::CANDIDATE_DASHBOARD);
                }
            }
        }

        return $next($request);
    }
}
