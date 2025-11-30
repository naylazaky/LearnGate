<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        $query->where(function($q) {
            $q->where('role', '!=', 'teacher')
              ->orWhere(function($subQ) {
                  $subQ->where('role', 'teacher')
                       ->where('approval_status', 'approved');
              });
        });

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status) {
            $query->where('approval_status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
        ]);

        if ($request->role === 'student') {
            if (!str_ends_with($request->email, '@gmail.com')) {
                return back()->withErrors([
                    'email' => 'Email student harus menggunakan domain @gmail.com'
                ])->withInput();
            }
        } elseif ($request->role === 'teacher') {
            if (!str_ends_with($request->email, '@learngate.com')) {
                return back()->withErrors([
                    'email' => 'Email tentor harus menggunakan domain @learngate.com'
                ])->withInput();
            }
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat diedit.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat diedit.');
        }

        $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
            'is_active' => 'required|boolean',
        ]);

        if ($request->role === 'student') {
            if (!str_ends_with($request->email, '@gmail.com')) {
                return back()->withErrors([
                    'email' => 'Email student harus menggunakan domain @gmail.com'
                ])->withInput();
            }
        } elseif ($request->role === 'teacher') {
            if (!str_ends_with($request->email, '@learngate.com')) {
                return back()->withErrors([
                    'email' => 'Email tentor harus menggunakan domain @learngate.com'
                ])->withInput();
            }
        }

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat dihapus.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function approve(User $user)
    {
        if ($user->role !== 'teacher') {
            return back()->with('error', 'Hanya tentor yang dapat diapprove.');
        }

        $user->update([
            'approval_status' => 'approved',
            'is_active' => true,
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'tentor berhasil diapprove!');
    }

    public function reject(Request $request, User $user)
    {
        if ($user->role !== 'teacher') {
            return back()->with('error', 'Hanya tentor yang dapat direject.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $user->delete();

        return back()->with('success', 'tentor berhasil direject dan dihapus dari sistem!');
    }

    public function pendingTeachers()
    {
        $pendingTeachers = User::where('role', 'teacher')
            ->where('approval_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.users.pending', compact('pendingTeachers'));
    }
}