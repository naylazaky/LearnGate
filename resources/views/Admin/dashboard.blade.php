@extends('layouts.app')

@section('title', 'Admin Dashboard - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Admin Dashboard</h1>
            <p class="text-lg text-gray-600">Selamat datang, <span class="font-bold text-blue-600">{{ auth()->user()->username }}</span>!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalUsers'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Users</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalTeachers'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Teachers</p>
                @if($stats['pendingTeachers'] > 0)
                    <a href="{{ route('admin.teachers.pending') }}" class="inline-flex items-center mt-2 text-xs font-bold text-yellow-600 hover:text-yellow-700">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $stats['pendingTeachers'] }} Pending
                    </a>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalStudents'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Students</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalCourses'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Courses</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stats['activeCourses'] }} Active</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <h2 class="text-2xl font-black text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition border-2 border-blue-200">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <div>
                            <p class="font-bold text-gray-900">Add User</p>
                            <p class="text-xs text-gray-600">Create new user</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition border-2 border-purple-200">
                        <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <div>
                            <p class="font-bold text-gray-900">Add Category</p>
                            <p class="text-xs text-gray-600">Create category</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition border-2 border-green-200">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <div>
                            <p class="font-bold text-gray-900">Manage Users</p>
                            <p class="text-xs text-gray-600">View all users</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.courses.index') }}" class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition border-2 border-yellow-200">
                        <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <div>
                            <p class="font-bold text-gray-900">Manage Courses</p>
                            <p class="text-xs text-gray-600">View all courses</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-black text-gray-900">Recent Users</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 font-bold text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $user->username }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-bold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $user->role === 'teacher' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user->role === 'student' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent users</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Popular Courses -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-gray-900">Popular Courses</h2>
                <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-700 font-bold text-sm">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($popularCourses as $course)
                    <div class="border-2 border-gray-100 rounded-xl p-4 hover:shadow-lg transition">
                        <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1 rounded-full mb-3">
                            {{ $course->category->name }}
                        </span>
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ $course->teacher->username }}</span>
                            <span class="text-blue-600 font-bold">{{ $course->student_count }} students</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4 col-span-3">No courses yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection