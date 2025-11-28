@extends('layouts.app')

@section('title', 'Teacher Dashboard - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Teacher Dashboard</h1>
            <p class="text-lg text-gray-600">Selamat datang, <span class="font-bold text-blue-600">{{ auth()->user()->username }}</span>!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalCourses'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Courses</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['activeCourses'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Active Courses</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalStudents'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Students</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalContents'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Contents</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <h2 class="text-2xl font-black text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('teacher.courses.create') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition border-2 border-blue-200">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Create New Course</p>
                            <p class="text-xs text-gray-600">Buat course baru untuk siswa</p>
                        </div>
                    </a>

                    <a href="{{ route('teacher.courses.index') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition border-2 border-purple-200">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">My Courses</p>
                            <p class="text-xs text-gray-600">Lihat dan kelola semua course Anda</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-black text-gray-900">Recent Courses</h2>
                    <a href="{{ route('teacher.courses.index') }}" class="text-blue-600 hover:text-blue-700 font-bold text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentCourses as $course)
                        <a href="{{ route('teacher.courses.show', $course) }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 line-clamp-1">{{ $course->title }}</p>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="text-xs text-gray-500">{{ $course->category->name }}</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-blue-600 font-bold">{{ $course->students_count }} students</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $course->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </a>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada course</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Popular Courses -->
        @if($popularCourses->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-gray-900">Popular Courses</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($popularCourses as $course)
                        <a href="{{ route('teacher.courses.show', $course) }}" class="border-2 border-gray-100 rounded-xl p-4 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $course->category->name }}
                                </span>
                                <div class="flex items-center text-blue-600 font-bold text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    {{ $course->student_count }}
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection