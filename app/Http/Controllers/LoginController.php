<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource (login page).
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        return $this->index();
    }

    /**
     * Store a newly created resource in storage (authenticate user).
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = $credentials['login'];
        $passwordInput = $credentials['password'];
        $rememberUser = $request->boolean('remember');

        $isEmailLogin = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $authAttempt = $isEmailLogin
            ? Auth::attempt(['email' => $loginInput, 'password' => $passwordInput], $rememberUser)
            : Auth::attempt(['username' => $loginInput, 'password' => $passwordInput], $rememberUser);

        if ($authAttempt) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('successMessage', 'Welcome back to RV CCTV Bali Admin Dashboard!');
        }

        return back()
            ->withErrors(['login' => 'Invalid email/username or password provided.'])
            ->withInput($request->only('login', 'remember'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        return redirect()->route('login');
    }

    /**
     * Remove the specified resource from storage (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('successMessage', 'You have been successfully logged out.');
    }
}
