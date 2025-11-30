<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        $data = [
            'user' => $user,
        ];
        
        if ($user->isStudent()) {
            $enrolledCourses = $user->enrollments()
                ->with(['course.teacher', 'course.category', 'course.contents'])
                ->latest('enrolled_at')
                ->get()
                ->filter(function ($enrollment) {
                    return $enrollment->course !== null;
                })
                ->map(function ($enrollment) {
                    return [
                        'enrollment' => $enrollment,
                        'course' => $enrollment->course,
                        'progress' => $enrollment->calculateProgress(),
                        'isCompleted' => $enrollment->isCompleted(),
                        'totalContents' => $enrollment->course->contents->count(),
                        'completedContents' => $enrollment->progresses()->where('is_completed', true)->count(),
                    ];
                });
            
            $data['enrolledCourses'] = $enrolledCourses;
            $data['stats'] = [
                'totalEnrolled' => $enrolledCourses->count(),
                'inProgress' => $enrolledCourses->where('isCompleted', false)->count(),
                'completed' => $enrolledCourses->where('isCompleted', true)->count(),
                'averageProgress' => $enrolledCourses->isEmpty() ? 0 : round($enrolledCourses->avg('progress'), 2),
            ];
        } elseif ($user->isTeacher()) {
            $courses = $user->coursesAsTeacher()
                ->with(['category', 'enrollments.student', 'contents'])
                ->withCount(['students', 'contents'])
                ->latest()
                ->get();
            
            $coursesData = $courses->map(function ($course) {
                $enrollments = $course->enrollments;
                $completedCount = 0;
                $inProgressCount = 0;
                
                foreach ($enrollments as $enrollment) {
                    if ($enrollment->calculateProgress() == 100) {
                        $completedCount++;
                    } else {
                        $inProgressCount++;
                    }
                }
                
                return [
                    'course' => $course,
                    'totalStudents' => $enrollments->count(),
                    'completedStudents' => $completedCount,
                    'inProgressStudents' => $inProgressCount,
                    'totalContents' => $course->contents->count(),
                ];
            });
            
            $data['courses'] = $coursesData;
            $data['stats'] = [
                'totalCourses' => $courses->count(),
                'activeCourses' => $courses->where('is_active', true)->count(),
                'totalStudents' => $courses->sum('students_count'),
                'totalContents' => $courses->sum('contents_count'),
            ];
        }
        
        return view('profile.show', $data);
    }
    
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->ignore($user->id),
                function ($attribute, $value, $fail) use ($user) {
                    $domain = substr(strrchr($value, "@"), 1);
                    
                    if ($user->role === 'teacher' && $domain !== 'learngate.com') {
                        $fail('Email teacher harus menggunakan domain @learngate.com');
                    }
                    
                    if ($user->role === 'student' && $domain !== 'gmail.com') {
                        $fail('Email student harus menggunakan domain @gmail.com');
                    }
                    
                },
            ],
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        $data = [
            'username' => $request->username,
            'email' => $request->email,
        ];
        
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }
        
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
            }
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('profile.show')->with('success', 'Profile berhasil diupdate!');
    }
    
    public function deletePhoto()
    {
        $user = auth()->user();
        
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }
        
        return back()->with('success', 'Foto profil berhasil dihapus!');
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            Log::warning('Admin attempted to delete own account via profile', [
                'user_id' => $user->id,
                'username' => $user->username,
            ]);
            
            return back()->with('error', 'Admin tidak dapat menghapus akun sendiri melalui fitur ini. Hubungi administrator lain.');
        }

        $request->validate([
            'password_confirm' => 'required|string',
        ]);

        if (!Hash::check($request->password_confirm, $user->password)) {
            return back()->withErrors([
                'password_confirm' => 'Password salah. Akun tidak dihapus.'
            ]);
        }

        if ($user->isTeacher()) {
            $activeCourses = $user->coursesAsTeacher()->where('is_active', true)->count();
            
            if ($activeCourses > 0) {
                return back()->with('error', 'Anda masih memiliki ' . $activeCourses . ' course aktif. Nonaktifkan semua course terlebih dahulu sebelum menghapus akun.');
            }
        }

        if ($user->isStudent()) {
            $inProgressEnrollments = $user->enrollments()
                ->get()
                ->filter(function($enrollment) {
                    if (!$enrollment->course) {
                        return false;
                    }
                    return $enrollment->calculateProgress() > 0 && $enrollment->calculateProgress() < 100;
                })
                ->count();
            
            if ($inProgressEnrollments > 0) {
                return back()->with('error', 'Anda masih memiliki ' . $inProgressEnrollments . ' course yang sedang berjalan. Selesaikan atau keluar dari course tersebut terlebih dahulu.');
            }
        }

        Log::info('User deleted own account', [
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'deleted_at' => now(),
        ]);

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $username = $user->username;
        $role = $user->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('home');
    }
}