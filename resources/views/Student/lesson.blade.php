@extends('layouts.app')

@section('title', $content->title . ' - ' . $course->title . ' - LearnGate')

@section('breadcrumb')
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('student.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ Str::limit($course->title, 20) }}</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <span class="text-gray-900 font-semibold">{{ Str::limit($content->title, 20) }}</span>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar - Course Content List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6 sticky top-24">
                    <div class="mb-6">
                        <h3 class="font-black text-lg text-gray-900 mb-2">{{ $course->title }}</h3>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 font-medium">Progress</span>
                            <span class="text-blue-600 font-bold">{{ $overallProgress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2 overflow-hidden">
                            <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $overallProgress }}%"></div>
                        </div>
                    </div>

                    <div class="border-t-2 border-gray-100 pt-4">
                        <h4 class="font-bold text-sm text-gray-900 mb-3">Daftar Materi</h4>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($allContents as $item)
                                @php
                                    $itemProgress = $enrollment->progresses()->where('content_id', $item->id)->first();
                                    $itemCompleted = $itemProgress ? $itemProgress->is_completed : false;
                                    
                                    // Check if can access (previous must be completed)
                                    $previousItem = $allContents->where('order', '<', $item->order)->sortByDesc('order')->first();
                                    $canAccessItem = !$previousItem || ($previousItem && $enrollment->progresses()->where('content_id', $previousItem->id)->where('is_completed', true)->exists());
                                @endphp
                                
                                @if($canAccessItem)
                                    <a href="{{ route('student.lesson.show', ['courseId' => $course->id, 'contentId' => $item->id]) }}" 
                                       class="flex items-center p-3 rounded-xl transition {{ $item->id == $content->id ? 'bg-blue-50 border-2 border-blue-500' : 'hover:bg-gray-50 border-2 border-transparent' }}">
                                @else
                                    <div class="flex items-center p-3 rounded-xl opacity-50 cursor-not-allowed border-2 border-transparent">
                                @endif
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center {{ $item->id == $content->id ? 'bg-blue-600 text-white' : ($canAccessItem ? 'bg-gray-100 text-gray-600' : 'bg-gray-50 text-gray-400') }} font-bold text-sm mr-3">
                                        {{ $item->order }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate {{ $item->id == $content->id ? 'text-blue-600' : '' }}">
                                            {{ $item->title }}
                                        </p>
                                    </div>
                                    @if($itemCompleted)
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif(!$canAccessItem)
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    @endif
                                @if($canAccessItem)
                                    </a>
                                @else
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-blue-600 text-white p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-blue-700 px-4 py-2 rounded-full text-sm font-bold">
                                Materi {{ $content->order }}
                            </span>
                            @if($isCompleted)
                                <span class="bg-green-500 px-4 py-2 rounded-full text-sm font-bold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span class="bg-yellow-500 px-4 py-2 rounded-full text-sm font-bold">
                                    Belum Selesai
                                </span>
                            @endif
                        </div>
                        <h1 class="text-4xl font-black mb-2">{{ $content->title }}</h1>
                        <div class="flex items-center text-blue-100">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Estimasi waktu: 2 jam</span>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-8">
                        <div class="prose max-w-none">
                            <div class="text-gray-800 leading-relaxed text-lg whitespace-pre-wrap bg-gray-50 p-6 rounded-xl border-2 border-gray-100">
                                {{ $content->content }}
                            </div>
                        </div>
                        
                        @if(!$isCompleted)
                            <div class="mt-8 bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-bold text-yellow-900 mb-2">Selesaikan Materi Ini</h3>
                                        <p class="text-yellow-800 text-sm">Anda harus menandai materi ini sebagai selesai sebelum dapat melanjutkan ke materi berikutnya.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    <div class="bg-gray-50 p-6 border-t-2 border-gray-100">
                        <div class="flex items-center justify-between">
                            <!-- Previous Button -->
                            @if($previousContent)
                                <a href="{{ route('student.lesson.show', ['courseId' => $course->id, 'contentId' => $previousContent->id]) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </a>
                            @else
                                <a href="{{ route('courses.show', $course->id) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali
                                </a>
                            @endif

                            <div class="flex items-center space-x-3">
                                <!-- Mark as Complete Button - ONLY if not completed yet -->
                                @if(!$isCompleted)
                                    <form action="{{ route('student.lesson.complete', ['courseId' => $course->id, 'contentId' => $content->id]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Tandai Selesai & Lanjutkan
                                        </button>
                                    </form>
                                @else
                                    @if($nextContent)
                                        <a href="{{ route('student.lesson.show', ['courseId' => $course->id, 'contentId' => $nextContent->id]) }}" 
                                           class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                                            Materi Berikutnya
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('courses.show', $course->id) }}" 
                                           class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg">
                                            Selesai - Kembali ke Course
                                            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection