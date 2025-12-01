@extends('layouts.app')

@section('title', 'My Profile - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100 mb-8">
            <div class="flex items-start justify-between">
                <div class="flex items-center">
                    @if($user->profile_photo)
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg mr-6">
                    @else
                        <div class="w-24 h-24 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl font-bold mr-6 shadow-lg">
                            {{ $user->initials }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 mb-2">{{ $user->username }}</h1>
                        <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                        <div class="flex items-center space-x-3">
                            <span class="px-4 py-1.5 {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'teacher' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700') }} text-sm font-bold rounded-full">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if($user->isTeacher())
                                <span class="px-4 py-1.5 {{ $user->approval_status === 'approved' ? 'bg-green-100 text-green-700' : ($user->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }} text-sm font-bold rounded-full">
                                    {{ ucfirst($user->approval_status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                    Edit Profil
                </a>
            </div>
        </div>

        @if($user->isStudent())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Total Course</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['totalEnrolled'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Dalam Progress</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['inProgress'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Selesai</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['completed'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Rata-Rata Progress</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['averageProgress'] }}%</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100 mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-6">My Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($enrolledCourses as $item)
                        <div class="border-2 border-gray-100 rounded-xl p-4 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                    {{ $item['course']->category->name ?? 'No Category' }}
                                </span>
                                @if($item['isCompleted'])
                                    <span class="bg-green-50 text-green-600 text-xs font-bold px-3 py-1.5 rounded-full">Selesai</span>
                                @else
                                    <span class="bg-yellow-50 text-yellow-600 text-xs font-bold px-3 py-1.5 rounded-full">Dalam Progress</span>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 mb-3 line-clamp-2">{{ $item['course']->title }}</h3>
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-bold text-gray-700">Progress</span>
                                    <span class="text-xs font-bold text-blue-600">{{ $item['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $item['progress'] }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('courses.show', $item['course']->id) }}" class="block text-center px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm">
                                Lihat Course
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500">Belum ada course yang diikuti</p>
                        </div>
                    @endforelse
                </div>
            </div>

        @elseif($user->isTeacher())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Total Course</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['totalCourses'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Course Aktif</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['activeCourses'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Total Students</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['totalStudents'] }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Total Materi</p>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['totalContents'] }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100 mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-6">My Courses</h2>
                <div class="space-y-4">
                    @forelse($courses as $item)
                        <div class="border-2 border-gray-100 rounded-xl p-6 hover:shadow-lg transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                            {{ $item['course']->category->name ?? 'No Category' }}
                                        </span>
                                        @if($item['course']->is_active)
                                            <span class="bg-green-50 text-green-600 text-xs font-bold px-3 py-1.5 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-full">Nonaktif</span>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $item['course']->title }}</h3>
                                    <div class="grid grid-cols-4 gap-4 mt-4">
                                        <div>
                                            <p class="text-2xl font-black text-blue-600">{{ $item['totalStudents'] }}</p>
                                            <p class="text-xs text-gray-600 font-semibold">Total Students</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-black text-green-600">{{ $item['completedStudents'] }}</p>
                                            <p class="text-xs text-gray-600 font-semibold">Selesai</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-black text-yellow-600">{{ $item['inProgressStudents'] }}</p>
                                            <p class="text-xs text-gray-600 font-semibold">Dalam Progress</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-black text-purple-600">{{ $item['totalContents'] }}</p>
                                            <p class="text-xs text-gray-600 font-semibold">Materi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-6 flex flex-col space-y-2">
                                    <a href="{{ route('teacher.courses.show', $item['course']) }}" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-sm text-center">
                                        Lihat Course
                                    </a>
                                    <a href="{{ route('teacher.courses.students', $item['course']) }}" class="px-4 py-2 bg-purple-100 text-purple-700 font-bold rounded-lg hover:bg-purple-200 transition text-sm text-center">
                                        Lihat Students
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500">Belum ada course yang dibuat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        @if(!$user->isAdmin())
            <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-red-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-6 flex-1">
                        <h3 class="text-2xl font-black text-red-900 mb-2">Danger Zone</h3>
                        <p class="text-red-700 mb-4">Tindakan ini tidak dapat dibatalkan. Akun Anda akan dihapus permanen beserta semua data yang terkait.</p>
                        
                        @if($user->isTeacher() && $user->coursesAsTeacher()->where('is_active', true)->count() > 0)
                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mb-4">
                                <p class="text-yellow-800 text-sm font-bold">
                                    Anda masih memiliki {{ $user->coursesAsTeacher()->where('is_active', true)->count() }} course aktif. 
                                    Nonaktifkan semua course terlebih dahulu sebelum menghapus akun.
                                </p>
                            </div>
                        @endif

                        @if($user->isStudent())
                            @php
                                $inProgressCount = $enrolledCourses->filter(function($item) {
                                    return $item['progress'] > 0 && $item['progress'] < 100;
                                })->count();
                            @endphp
                            
                            @if($inProgressCount > 0)
                                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mb-4">
                                    <p class="text-yellow-800 text-sm font-bold">
                                        Anda masih memiliki {{ $inProgressCount }} course yang sedang berjalan. 
                                        Selesaikan atau keluar dari course tersebut terlebih dahulu.
                                    </p>
                                </div>
                            @endif
                        @endif

                        <button onclick="openDeleteAccountModal()" 
                                class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Akun Saya
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Konfirmasi Hapus Akun</h3>
            <p class="text-gray-600">Tindakan ini <strong>TIDAK DAPAT DIBATALKAN</strong>. Semua data Anda akan hilang permanen.</p>
        </div>

        <form action="{{ route('profile.delete-account') }}" method="POST" id="deleteAccountForm">
            @csrf
            @method('DELETE')

            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-6">
                <p class="text-red-800 text-sm font-bold mb-3">Yang akan terhapus:</p>
                <ul class="text-red-700 text-sm space-y-2">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Informasi profil & foto</span>
                    </li>
                    @if($user->isStudent())
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Semua enrollment & progress belajar</span>
                        </li>
                    @endif
                    @if($user->isTeacher())
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Course kehilangan tentor</span>
                        </li>
                    @endif
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Akses ke semua fitur LearnGate</span>
                    </li>
                </ul>
            </div>

            <div class="mb-6">
                <label for="password_confirm" class="block text-sm font-bold text-gray-700 mb-2">
                    Masukkan Password untuk Konfirmasi <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="password_confirm" 
                       id="password_confirm" 
                       required
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500"
                        placeholder="Masukkan password Anda">
                        @error('password_confirm')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
            </div>

                <div class="flex space-x-3">
                <button type="button" 
                        onclick="closeDeleteAccountModal()" 
                        class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg">
                    Ya, Hapus Akun Saya
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.remove('hidden');
    document.getElementById('password_confirm').focus();
}

function closeDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.add('hidden');
    document.getElementById('deleteAccountForm').reset();
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeleteAccountModal();
    }
});

document.getElementById('deleteAccountModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeDeleteAccountModal();
    }
});
</script>
@endpush
@endsection