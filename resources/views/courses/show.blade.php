@extends('layouts.app')

@section('title', $course->title . ' - LearnGate')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <x-back-button />
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="bg-blue-100 text-blue-600 text-sm font-bold px-4 py-2 rounded-full">
                                {{ $course->category->name }}
                            </span>
                        </div>
                        
                        <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $course->title }}</h1>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">{{ $course->description }}</p>
                        
                        <div class="flex flex-wrap items-center gap-6 text-sm">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Siswa Terdaftar</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ $course->student_count }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Total Materi</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ $course->contents->count() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">Durasi</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ $course->contents->count() * 2 }} Jam</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
                        <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                            <svg class="w-7 h-7 text-blue-600 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5"></path>
                            </svg>
                            Materi Kursus
                        </h2>
                        <div class="space-y-3">
                            @forelse($course->contents as $index => $content)
                                @php
                                    if ($isEnrolled) {
                                        $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();
                                        $isContentCompleted = $content->isCompletedBy($enrollment->id);
                                        
                                        // Check if previous content is completed (untuk sequential access)
                                        $previousContent = $course->contents()->where('order', '<', $content->order)->orderBy('order', 'desc')->first();
                                        $canAccess = !$previousContent || ($previousContent && $previousContent->isCompletedBy($enrollment->id));
                                    } else {
                                        $isContentCompleted = false;
                                        $canAccess = false;
                                    }
                                @endphp
                                
                                @if($isEnrolled && $canAccess)
                                    <a href="{{ route('student.lesson.show', ['courseId' => $course->id, 'contentId' => $content->id]) }}" 
                                       class="group flex items-center p-4 border-2 border-gray-100 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all cursor-pointer">
                                @else
                                    <div class="group flex items-center p-4 border-2 border-gray-100 rounded-xl {{ $isEnrolled && !$canAccess ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @endif
                                    <div class="flex items-center flex-1">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 {{ $isEnrolled && $canAccess ? 'group-hover:bg-blue-600' : '' }} transition">
                                            <span class="text-blue-600 font-bold {{ $isEnrolled && $canAccess ? 'group-hover:text-white' : '' }} transition">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 {{ $isEnrolled && $canAccess ? 'group-hover:text-blue-600' : '' }} transition">{{ $content->title }}</p>
                                            <p class="text-sm text-gray-500 font-medium">Materi {{ $content->order }} • 2 jam</p>
                                        </div>
                                    </div>
                                    @if($isEnrolled)
                                        @if($isContentCompleted)
                                            <div class="flex items-center bg-green-50 px-4 py-2 rounded-lg">
                                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="ml-2 text-sm font-bold text-green-700">Selesai</span>
                                            </div>
                                        @elseif($canAccess)
                                            <div class="flex items-center bg-yellow-50 px-4 py-2 rounded-lg">
                                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="ml-2 text-sm font-bold text-yellow-700">Belum Selesai</span>
                                            </div>
                                        @else
                                            <div class="flex items-center bg-gray-50 px-4 py-2 rounded-lg">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                                                </svg>
                                                <span class="ml-2 text-sm font-bold text-gray-500">Terkunci</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center bg-gray-50 px-4 py-2 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm font-bold text-gray-500">Terkunci</span>
                                        </div>
                                    @endif
                                @if($isEnrolled && $canAccess)
                                    </a>
                                @else
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada materi tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                        <h3 class="font-black text-lg text-gray-900 mb-4">Tentor Anda</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl font-bold mr-4 shadow-lg">
                                {{ strtoupper(substr($course->teacher->username, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-lg text-gray-900">{{ $course->teacher->username }}</p>
                                <p class="text-sm text-gray-500">Tentor Ahli</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ $course->teacher->email }}</p>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $course->teacher->email }}&su=Pertanyaan mengenai {{ $course->title }}&body=Halo {{ $course->teacher->username }},%0D%0A%0D%0ASaya ingin bertanya mengenai kursus {{ $course->title }}." 
                           target="_blank"
                           class="block w-full bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold hover:bg-gray-200 transition text-center">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Hubungi Tentor
                            </span>
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-100">
                        @guest
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-black text-xl text-gray-900 mb-2">Mulai Belajar Hari Ini</h3>
                                <p class="text-gray-600 mb-6">Login untuk mendaftar kursus ini dan mulai perjalanan belajar Anda</p>
                                <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white px-6 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                                    Login untuk Mendaftar
                                </a>
                            </div>
                        @endguest

                        @auth
                            @if(auth()->user()->role === 'student')
                                @if($isEnrolled)
                                    <div>
                                        <h3 class="font-black text-lg text-gray-900 mb-4">Progress Anda</h3>
                                        <div class="mb-6">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-bold text-gray-700">Penyelesaian Kursus</span>
                                                <span class="text-sm font-bold text-blue-600">{{ $progress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                        @if($progress == 100)
                                            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-4">
                                                <div class="flex items-center">
                                                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-green-700 font-bold">Kursus Selesai!</span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @php
                                            $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();
                                            $nextLesson = $enrollment->nextIncompleteContent();
                                            $firstLesson = $course->contents()->orderBy('order')->first();
                                        @endphp
                                        
                                        @if($firstLesson)
                                            <a href="{{ route('student.lesson.show', ['courseId' => $course->id, 'contentId' => $nextLesson ? $nextLesson->id : $firstLesson->id]) }}" 
                                               class="w-full bg-green-600 text-white px-6 py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-lg hover:shadow-xl text-center flex items-center justify-center mb-3">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $progress == 100 ? 'Review Materi' : ($nextLesson ? 'Lanjutkan Belajar' : 'Mulai Belajar') }}
                                            </a>
                                        @endif
                                        
                                        @if($progress < 100)
                                            <form action="{{ route('courses.unenroll', $course->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari course ini? Progress Anda akan dihapus.')">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-50 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-100 transition border-2 border-red-200 flex items-center justify-center">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Keluar dari Course
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <h3 class="font-black text-xl text-gray-900 mb-2">Siap untuk Mulai?</h3>
                                        <p class="text-gray-600 mb-6">Daftar sekarang dan dapatkan akses instan ke semua materi kursus</p>
                                        <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg hover:shadow-xl flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Daftar Sekarang - Gratis!
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 font-medium">Kursus ini hanya tersedia untuk siswa</p>
                                </div>
                            @endif
                        @endauth
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection