<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $data = $request->all();

        $response = Http::post('https://candidate-testing.api.royal-apps.io/api/v2/token', [
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($response->successful()) {
            $apiData = $response->json();
            $user = User::where('email',$apiData['user']['email']);
            $user->update([
                'token_key' => $apiData['token_key'],
                'refresh_token_key' => $apiData['refresh_token_key'],
            ]);
            $request->authenticate();
    
            $request->session()->regenerate();
    
            return redirect()->intended(route('dashboard', absolute: false));
        }
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
