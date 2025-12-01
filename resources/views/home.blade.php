@extends('layouts.app')

@section('title', 'LearnGate - Online Learning Platform')

@section('content')
    <div class="relative bg-gray-300 overflow-hidden">
        <div class="pattern-dots absolute inset-0 opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-full mb-6">
                    <span class="text-blue-700 text-sm font-semibold">Bergabunglah dengan para pelajar sukses!</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight">
                    <span class="text-gray-900">Learn</span><span class="text-blue-600">Gate</span><br/>
                    <span class="text-gray-900 text-4xl md:text-5xl">Platform Pembelajaran Online Terbaik</span>
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Tingkatkan karirmu dengan kursus dari para ahli. Mulai belajar hari ini dan jelajahi potensi terbaikmu.
                </p>
                
                <form action="{{ route('courses.catalog') }}" method="GET" class="max-w-2xl mx-auto mb-8">
                    <div class="relative shadow-xl">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Apa yang ingin kamu pelajari hari ini?" 
                               class="w-full pl-14 pr-36 py-5 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-gray-900 font-medium"
                               value="{{ request('search') }}">
                        <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-600 text-white px-8 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Jelajahi Kategori Populer</h2>
                <p class="text-lg text-gray-600">Pilih dari berbagai kategori kursus terpopuler kami</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('courses.catalog', ['category' => $category->id]) }}" 
                       class="group bg-white p-8 rounded-2xl border-2 border-gray-100 hover:border-blue-500 hover:shadow-2xl transition-all card-hover">
                        <div class="flex items-center mb-5">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:scale-110 transition-all shadow-lg">
                                <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-2xl text-gray-900 mb-3 group-hover:text-blue-600 transition">{{ $category->name }}</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">{{ $category->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-semibold">{{ $category->courses_count }} Kursus</span>
                            <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition">
                                Jelajahi
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 mb-3">Kursus Trending</h2>
                    <p class="text-lg text-gray-600">Kursus paling populer di kalangan siswa kami</p>
                </div>
                <a href="{{ route('courses.catalog') }}" class="hidden md:flex items-center text-blue-600 hover:text-blue-700 font-bold text-lg group">
                    Lihat Semua Kursus
                    <svg class="w-6 h-6 ml-2 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            @if($popularCourses->count() > 0)
                <div class="relative">
                    {{-- Tombol Previous --}}
                    <button id="prevBtn" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 bg-white rounded-full p-3 shadow-xl hover:bg-gray-100 hover:scale-110 transition-all border-2 border-gray-200">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <div id="courseSlider" class="overflow-x-auto scroll-smooth hide-scrollbar">
                        <div class="flex gap-8 pb-4">
                            @foreach($popularCourses as $course)
                                <div class="flex-none w-80">
                                    <a href="{{ route('courses.show', $course->id) }}" class="block group bg-white rounded-2xl border-2 border-gray-100 overflow-hidden hover:shadow-2xl transition-all card-hover">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-4 py-2 rounded-full">
                                                    {{ $course->category->name ?? 'Uncategorized' }}
                                                </span>
                                                <div class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-full flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                                    </svg>
                                                    <span class="text-xs font-bold">{{ $course->contents_count }} Materi</span>
                                                </div>
                                            </div>
                                            
                                            <h3 class="font-bold text-xl text-gray-900 mb-3 group-hover:text-blue-600 transition line-clamp-2 min-h-[3.5rem]">
                                                {{ $course->title }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-5 line-clamp-3 leading-relaxed min-h-[4.5rem]">{{ $course->description }}</p>
                                            
                                            <div class="flex items-center justify-between pt-5 border-t-2 border-gray-100">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3 shadow-md">
                                                        {{ strtoupper(substr($course->teacher?->username ?? 'N', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-gray-500 font-medium">Tentor</p>
                                                        <p class="text-sm text-gray-900 font-bold">{{ $course->teacher?->username ?? 'No Teacher' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center bg-blue-50 px-3 py-2 rounded-lg">
                                                    <svg class="w-5 h-5 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                    <span class="text-sm font-bold text-blue-600">{{ $course->student_count }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button id="nextBtn" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 bg-white rounded-full p-3 shadow-xl hover:bg-gray-100 hover:scale-110 transition-all border-2 border-gray-200">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada kursus tersedia.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-gray-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-600 rounded-3xl p-12 md:p-16 text-center relative overflow-hidden shadow-2xl">
                <div class="pattern-dots absolute inset-0 opacity-10"></div>
                <div class="relative z-10">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-500 rounded-full mb-6">
                        <span class="text-white text-sm font-bold">Penawaran Terbatas</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Siap Mengubah Karirmu?</h2>
                    <p class="text-blue-100 text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                        Bergabunglah dengan para siswa sukses. Dapatkan akses tanpa batas ke kursus premium dan mulai belajar hari ini!
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        @guest
                            <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white text-blue-600 px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl hover:shadow-2xl hover:scale-105 transform">
                                Mulai →
                            </a>
                            <a href="{{ route('courses.catalog') }}" class="w-full sm:w-auto bg-blue-700 text-white px-10 py-4 rounded-xl font-bold hover:bg-blue-800 transition border-2 border-blue-500">
                                Jelajahi Kursus
                            </a>
                        @else
                            <a href="{{ route('courses.catalog') }}" class="w-full sm:w-auto bg-white text-blue-600 px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl hover:shadow-2xl hover:scale-105 transform">
                                Jelajahi Kursus →
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    </style>

    {{-- JavaScript untuk Slider --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('courseSlider');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (slider && prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -350, behavior: 'smooth' });
            });
            
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: 350, behavior: 'smooth' });
            });

            function updateButtons() {
                const scrollLeft = slider.scrollLeft;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                
                prevBtn.style.opacity = scrollLeft === 0 ? '0.3' : '1';
                prevBtn.style.pointerEvents = scrollLeft === 0 ? 'none' : 'auto';
                
                nextBtn.style.opacity = scrollLeft >= maxScroll - 5 ? '0.3' : '1';
                nextBtn.style.pointerEvents = scrollLeft >= maxScroll - 5 ? 'none' : 'auto';
            }
            
            slider.addEventListener('scroll', updateButtons);
            updateButtons();
        }
    });
    </script>
@endsection