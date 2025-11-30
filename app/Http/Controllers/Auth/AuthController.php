<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Email tidak terdaftar.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        if ($user->isTeacher()) {
            if ($user->isPending()) {
                return back()->with('status', 'pending')->with('message', 'Akun Anda masih menunggu persetujuan dari admin. Silakan coba login lagi nanti atau hubungi admin.');
            }

            if ($user->isRejected()) {
                return back()->with('status', 'rejected')
                    ->with('message', 'Akun Anda telah ditolak oleh admin.')
                    ->with('rejection_reason', $user->rejection_reason);
            }
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda tidak aktif. Silakan hubungi admin.'],
            ]);
        }

        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->intended(route('profile.show'));
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
        ]);

        if ($request->role === 'student') {
            if (!str_ends_with($request->email, '@gmail.com')) {
                throw ValidationException::withMessages([
                    'email' => ['Email student harus menggunakan domain @gmail.com'],
                ]);
            }
        } elseif ($request->role === 'teacher') {
            if (!str_ends_with($request->email, '@learngate.com')) {
                throw ValidationException::withMessages([
                    'email' => ['Email tentor harus menggunakan domain @learngate.com'],
                ]);
            }
        }

        $existingUser = User::where('email', $request->email)->first();
        
        if ($existingUser && $existingUser->isRejected()) {
            $existingUser->update([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'approval_status' => 'pending',
                'rejection_reason' => null,
                'is_active' => false,
            ]);

            return redirect()->route('register.success')->with('role', 'teacher');
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->role === 'student' ? true : false,
            'approval_status' => $request->role === 'student' ? 'approved' : 'pending',
        ]);

        if ($user->isStudent()) {
            Auth::login($user);
            return redirect()->route('profile.show')->with('success', 'Registrasi berhasil! Selamat datang di LearnGate.');
        }

        return redirect()->route('register.success')->with('role', 'teacher');
    }

    public function registerSuccess()
    {
        return view('auth.register-success');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}