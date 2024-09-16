<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    // Registration method
    public function register(Request $request)
    {
        Log::info('Registration attempt', ['username' => $request->username]);

        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:users',
                'role' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);  // Explizit gehasht

            Log::info('Password set for user during registration', ['username' => $user->username]);

            try {
                if ($user->save()) {
                    Log::info('User registered successfully', ['username' => $user->username]);
                    return redirect()->route('auth.login')->with('success', 'Account successfully created!');
                } else {
                    Log::error('Failed to save user to the database', ['username' => $user->username]);
                    return back()->withErrors(['register_error' => 'An error occurred while registering.']);
                }
            } catch (\Exception $e) {
                Log::error('Exception during user registration', ['error' => $e->getMessage()]);
                return back()->withErrors(['register_error' => 'An unexpected error occurred.']);
            }
        }

        return view('auth.register');
    }

    // Login method with detailed logging
    public function login(Request $request)
    {
        Log::info('Login attempt', ['username' => $request->username]);

        if ($request->isMethod('post')) {
            $credentials = $request->only('username', 'password');
            Log::info('Credentials received', ['username' => $credentials['username']]);

            $user = User::where('username', $credentials['username'])->first();

            if (!$user) {
                Log::warning('User not found', ['username' => $credentials['username']]);
                return back()->withErrors(['login_error' => 'Login failed. User not found.']);
            }

            Log::info('User found in database', ['username' => $user->username]);

            if (Hash::check($credentials['password'], $user->password)) {
                Log::info('Password match', ['username' => $user->username]);
                Auth::login($user, $request->has('remember_me'));
                $request->session()->regenerate();
                Log::info('Login successful', ['user' => Auth::user()->username]);

                // Weiterleitung basierend auf der Rolle des Benutzers
                return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
            } else {
                Log::warning('Password mismatch', ['username' => $user->username]);
                return back()->withErrors(['login_error' => 'Incorrect password. Please try again.']);
            }
        }

        return view('auth.login');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show Registration Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Password change method with logging
    public function changePassword(Request $request)
    {
        Log::info('Password change attempt', ['user' => Auth::user()->username]);

        if ($request->isMethod('post')) {
            // Validierung des neuen Passworts
            $request->validate([
                'new_password' => 'required|string|min:8|confirmed'
            ]);

            // Aktuellen Benutzer abrufen
            /** @var User $user */
            $user = Auth::user();

            // Neues Passwort setzen (gehashed)
            $user->password = Hash::make($request->new_password);
            $user->is_temp_password = false;

            // Speichern und Erfolg oder Fehler prüfen
            if ($user->save()) {
                Log::info('Password changed successfully', ['user' => $user->username]);
                return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')
                    ->with('success', 'Password changed successfully!');
            } else {
                Log::error('Password change failed', ['user' => $user->username]);
                return back()->withErrors(['password_error' => 'Failed to change password.']);
            }
        }

        return view('auth.change_password');
    }

    // Logout method with logging
    public function logout(Request $request)
    {
        Log::info('User logout', ['user' => Auth::user()->username]);

        // Benutzer ausloggen
        Auth::logout();

        // Sitzung ungültig machen
        $request->session()->invalidate();

        // Token regenerieren
        $request->session()->regenerateToken();

        // Weiterleitung zur Login-Seite mit Logout-Info
        return redirect()->route('auth.login')->with('info', 'You have been logged out.');
    }
}
