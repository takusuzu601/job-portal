<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // 以下の修正でログイン後のダッシュボードの振り分けを行う
    public function store(LoginRequest $request): RedirectResponse
    {
        // 以下 LoginRequest authenticateでログイン処理をしている
        $request->authenticate('admin');

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
