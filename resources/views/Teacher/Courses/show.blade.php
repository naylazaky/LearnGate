@extends('layouts.app')

@section('title', $course->title . ' - Teacher')

@section('breadcrumb')
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('teacher.courses.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">My Courses</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <span class="text-gray-900 font-semibold">{{ Str::limit($course->title, 30) }}</span>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <span class="bg-blue-100 text-blue-600 text-sm font-bold px-4 py-2 rounded-full">
                            {{ $course->category->name }}
                        </span>
                        @if($course->is_active)
                            <span class="bg-green-100 text-green-600 text-sm font-bold px-4 py-2 rounded-full">Active</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 text-sm font-bold px-4 py-2 rounded-full">Inactive</span>
                        @endif
                    </div>
                    <h1 class="text-4xl font-black text-gray-900 mb-2">{{ $course->title }}</h1>
                    <p class="text-lg text-gray-600">{{ $course->description }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('teacher.courses.edit', $course) }}" 
                       class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        Edit Course
                    </a>
                    <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus course ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $course->student_count }}</p>
                <p class="text-sm font-semibold text-gray-600">Enrolled Students</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $course->contents->count() }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Contents</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-black text-gray-900">{{ $course->start_date->format('d M Y') }}</p>
                <p class="text-sm font-semibold text-gray-600">Start Date</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-black text-gray-900">{{ $course->end_date->format('d M Y') }}</p>
                <p class="text-sm font-semibold text-gray-600">End Date</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Contents -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-black text-gray-900">Course Contents</h2>
                        <a href="{{ route('teacher.contents.index', $course) }}" 
                           class="px-4 py-2 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition text-sm">
                            Manage Contents
                        </a>
                    </div>

                    @if($course->contents->count() > 0)
                        <div class="space-y-3">
                            @foreach($course->contents as $index => $content)
                                <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 font-bold mr-4">
                                        {{ $content->order }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">{{ $content->title }}</p>
                                        <p class="text-xs text-gray-500">Content {{ $content->order }}</p>
                                    </div>
                                    <a href="{{ route('teacher.contents.edit', [$course, $content]) }}" 
                                       class="text-blue-600 hover:text-blue-700 font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium mb-4">Belum ada content</p>
                            <a href="{{ route('teacher.contents.create', $course) }}" 
                               class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('teacher.contents.create', $course) }}" 
                           class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition border-2 border-purple-200">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="font-bold text-gray-900">Add Content</span>
                        </a>

                        <a href="{{ route('teacher.courses.students', $course) }}" 
                           class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition border-2 border-blue-200">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-bold text-gray-900">View Students</span>
                        </a>

                        <a href="{{ route('courses.show', $course) }}" 
                           class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-xl transition border-2 border-green-200"
                           target="_blank">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="font-bold text-gray-900">Preview Course</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Students -->
                @if($enrollments->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                        <h3 class="text-lg font-black text-gray-900 mb-4">Recent Students</h3>
                        <div class="space-y-3">
                            @foreach($enrollments as $enrollment)
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                        {{ strtoupper(substr($enrollment->student->username, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900 text-sm">{{ $enrollment->student->username }}</p>
                                        <p class="text-xs text-gray-500">{{ $enrollment->enrolled_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection