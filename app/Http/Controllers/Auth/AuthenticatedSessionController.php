<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar o formulário de login.
     */
    public function create(): View
    {
        return view('auth.login'); // certifique-se de ter resources/views/auth/login.blade.php
    }

    /**
     * Processar a autenticação (login).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $key = $this->throttleKey($request);
        $maxAttempts = 5;

        if (! Auth::guard('funcionario')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            $seconds   = RateLimiter::availableIn($key);
            $remaining = RateLimiter::remaining($key, $maxAttempts);
            $ip        = $request->ip();

            return back()
        ->withErrors([
            'email' => "Login inválido. Restam {$remaining} tentativas.",
        ])
        ->with('wait_seconds', $seconds); // <-- Envia o tempo para o Blade
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route('index'));
    }


    /**
     * Logout / destruir sessão.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Verifica limitações de tentativa (rate limit).
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', ['seconds' => $seconds]),
            ]);
        }
    }

    /**
     * Chave usada para throttle (email + IP).
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email', '')) . '|' . $request->ip();
    }
}
