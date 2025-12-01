@extends('layouts.app')

@section('title', 'Manage Contents - ' . $course->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <x-back-button />
        </div>
        
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 mb-2">Kelola Materi</h1>
                    <p class="text-lg text-gray-600">Course: <span class="font-bold text-blue-600">{{ $course->title }}</span></p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('teacher.courses.show', $course) }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                        Kembali ke Course
                    </a>
                    <a href="{{ route('teacher.contents.create', $course) }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Materi
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-bold mb-2">Informasi:</p>
                    <ul class="space-y-1">
                        <li>• Content akan ditampilkan sesuai urutan (order)</li>
                        <li>• Student harus menyelesaikan content secara berurutan</li>
                        <li>• Setiap perubahan akan langsung terlihat oleh student</li>
                        <li>• Total content saat ini: <strong>{{ $contents->count() }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        @if($contents->count() > 0)
            <div class="space-y-4">
                @foreach($contents as $content)
                    <div class="bg-white rounded-2xl border-2 border-gray-100 overflow-hidden hover:shadow-xl transition-all">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start flex-1">
                                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 font-black text-xl mr-4 flex-shrink-0">
                                        {{ $content->order }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $content->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($content->content, 150) }}</p>
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $content->created_at->format('d M Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Updated {{ $content->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('teacher.contents.edit', [$course, $content]) }}" 
                                       class="p-3 bg-blue-100 text-blue-700 font-bold rounded-xl hover:bg-blue-200 transition"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('teacher.contents.destroy', [$course, $content]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus content ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-3 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition"
                                                title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center border-2 border-gray-100">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-3">Belum Ada Materi</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Mulai dengan menambahkan Materi pertama untuk course ini. Materi akan membantu student belajar secara terstruktur.
                </p>
                <a href="{{ route('teacher.contents.create', $course) }}" 
                   class="inline-flex items-center px-8 py-4 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition shadow-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Materi
                </a>
            </div>
        @endif
    </div>
</div>
@endsection