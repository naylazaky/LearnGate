@extends('layouts.app')

@section('title', 'Dashboard Siswa - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Dashboard Siswa</h1>
            <p class="text-lg text-gray-600">Selamat datang kembali, <span class="font-bold text-blue-600">{{ auth()->user()->username }}</span>!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['totalEnrolled'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Total Kursus</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['inProgress'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Sedang Berjalan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['completed'] }}</p>
                <p class="text-sm font-semibold text-gray-600">Selesai</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $stats['averageProgress'] }}%</p>
                <p class="text-sm font-semibold text-gray-600">Rata-rata Progress</p>
            </div>
        </div>

        @if($inProgressCourses->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-black text-gray-900">Kursus Sedang Berjalan</h2>
                    <a href="{{ route('student.my-courses') }}" class="text-blue-600 hover:text-blue-700 font-bold flex items-center">
                        Lihat Semua
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($inProgressCourses as $item)
                        <div class="bg-white rounded-2xl border-2 border-gray-100 overflow-hidden hover:shadow-2xl transition-all card-hover">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                        {{ $item['course']->category->name }}
                                    </span>
                                    <span class="bg-yellow-50 text-yellow-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                        Sedang Berjalan
                                    </span>
                                </div>
                                
                                <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2">
                                    {{ $item['course']->title }}
                                </h3>
                                
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-bold text-gray-700">Progress</span>
                                        <span class="text-sm font-bold text-blue-600">{{ $item['progress'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ $item['progress'] }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $item['completedContents'] }} dari {{ $item['totalContents'] }} materi selesai
                                    </p>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t-2 border-gray-100">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                            {{ strtoupper(substr($item['course']->teacher->username, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900">{{ $item['course']->teacher->username }}</span>
                                    </div>
                                    
                                        <a href="{{ route('courses.show', $item['course']->id) }}" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-bold">
                                            Lihat Kursus
                                        </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($completedCourses->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-black text-gray-900">Kursus Selesai</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($completedCourses as $item)
                        <div class="bg-white rounded-2xl border-2 border-gray-100 overflow-hidden hover:shadow-2xl transition-all card-hover">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                        {{ $item['course']->category->name }}
                                    </span>
                                    <span class="bg-green-50 text-green-600 text-xs font-bold px-3 py-1.5 rounded-full flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Selesai
                                    </span>
                                </div>
                                
                                <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2">
                                    {{ $item['course']->title }}
                                </h3>
                                
                                <div class="mb-4">
                                    <div class="flex items-center justify-center py-4 bg-green-50 rounded-xl">
                                        <svg class="w-8 h-8 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-green-700 font-bold">100% Complete!</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t-2 border-gray-100">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                            {{ strtoupper(substr($item['course']->teacher->username, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900">{{ $item['course']->teacher->username }}</span>
                                    </div>
                                    <a href="{{ route('courses.show', $item['course']->id) }}" 
                                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-bold">
                                        Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($inProgressCourses->count() === 0 && $completedCourses->count() === 0)
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Kursus</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Anda belum mendaftar di kursus apapun. Mulai perjalanan belajar Anda sekarang!
                </p>
                <a href="{{ route('courses.catalog') }}" 
                   class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Jelajahi Kursus
                </a>
            </div>
        @endif
    </div>
</div>
@endsection