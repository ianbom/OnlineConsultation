<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {


        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    return match ($user->role) {
        'client' => redirect()->intended(route('client.dashboard')),
        // client = inertia → inertia

        'counselor' => Inertia::location(route('counselor.dashboard')),
        // inertia → blade (HARUS full reload)

        'admin' => Inertia::location(route('admin.dashboard')),
        // inertia → blade (HARUS full reload)

        default => $this->logoutWithError($request),
    };
}

protected function logoutWithError(LoginRequest $request): RedirectResponse
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('error', 'Role tidak dikenali.');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
