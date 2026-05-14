<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\StreakService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('components.auth.login');
    }

    public function store(Request $request, StreakService $streakService)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Proses streak & poin
            $streakResult = $streakService->processLogin(Auth::user());

            // Simpan ke session supaya bisa ditampilkan popup di dashboard
            if (!$streakResult['already_claimed']) {
                session(['streak_popup' => $streakResult]);
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }
}