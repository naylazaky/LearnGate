@extends('layouts.app')

@section('title', 'My Courses - Teacher')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-black text-gray-900 mb-2">My Courses</h1>
                <p class="text-lg text-gray-600">Kelola semua course Anda</p>
            </div>
            <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Course
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-2 border-gray-100">
            <form action="{{ route('teacher.courses.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Cari</label>
                        <input type="text" name="search" placeholder="Cari nama course..." 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                               value="{{ request('search') }}">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                        <div class="flex gap-2">
                            <select name="status" class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>

                @if(request('search') || request('status') !== null)
                    <div class="mt-4">
                        <a href="{{ route('teacher.courses.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-bold">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
                <div class="bg-white rounded-2xl border-2 border-gray-100 overflow-hidden hover:shadow-2xl transition-all">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-full">
                                {{ $course->category->name }}
                            </span>
                            @if($course->is_active)
                                <span class="bg-green-50 text-green-600 text-xs font-bold px-3 py-1.5 rounded-full">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2">
                            {{ $course->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
                        
                        <div class="flex items-center justify-between mb-4 text-sm">
                            <div class="flex items-center text-blue-600 font-bold">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                {{ $course->students_count }} students
                            </div>
                            <div class="flex items-center text-purple-600 font-bold">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ $course->contents_count }} contents
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 pt-4 border-t-2 border-gray-100">
                            <a href="{{ route('teacher.courses.show', $course) }}" 
                               class="px-4 py-2 bg-blue-600 text-white text-center font-bold rounded-lg hover:bg-blue-700 transition text-sm">
                                Lihat
                            </a>
                            <a href="{{ route('teacher.contents.index', $course) }}" 
                               class="px-4 py-2 bg-purple-100 text-purple-700 text-center font-bold rounded-lg hover:bg-purple-200 transition text-sm">
                                Materi
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Course</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan membuat course pertama Anda!</p>
                    <a href="{{ route('teacher.courses.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Course
                    </a>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection