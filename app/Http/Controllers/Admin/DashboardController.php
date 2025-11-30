<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::where(function($query) {
                $query->where('role', 'admin')
                      ->orWhere('role', 'student')
                      ->orWhere(function($q) {
                          $q->where('role', 'teacher')
                            ->where('approval_status', 'approved');
                      });
            })->count(),

            'totalTeachers' => User::where('role', 'teacher')
                ->where('approval_status', 'approved')
                ->count(),
            
            'totalStudents' => User::where('role', 'student')->count(),
            
            'pendingTeachers' => User::where('role', 'teacher')
                ->where('approval_status', 'pending')
                ->count(),
            
            'totalCourses' => Course::count(),
            'activeCourses' => Course::where('is_active', true)->count(),
            'totalCategories' => Category::count(),
            'totalEnrollments' => Enrollment::count(),
        ];

        $recentUsers = User::where(function($query) {
                $query->where('role', 'admin')
                      ->orWhere('role', 'student')
                      ->orWhere(function($q) {
                          $q->where('role', 'teacher')
                            ->where('approval_status', 'approved');
                      });
            })
            ->latest()
            ->take(5)
            ->get();
        
        $recentCourses = Course::with(['teacher', 'category'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCourses'));
    }
}