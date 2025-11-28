@extends('layouts.app')

@section('title', 'Add Content - ' . $course->title)

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
    <a href="{{ route('teacher.courses.show', $course) }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ Str::limit($course->title, 20) }}</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('teacher.contents.index', $course) }}" class="text-blue-600 hover:text-blue-700 font-medium">Contents</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <span class="text-gray-900 font-semibold">Add Content</span>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Add New Content</h1>
            <p class="text-lg text-gray-600">Course: <span class="font-bold text-blue-600">{{ $course->title }}</span></p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
            <form action="{{ route('teacher.contents.store', $course) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            Content Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 @error('title') border-red-300 @enderror"
                               placeholder="e.g., Introduction to Laravel">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 mb-2">
                            Order <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="order" id="order" required min="1"
                               value="{{ old('order', $lastOrder + 1) }}"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 @error('order') border-red-300 @enderror"
                               placeholder="Content order">
                        <p class="mt-2 text-sm text-gray-600">
                            Urutan content (saat ini ada {{ $lastOrder }} content). Content baru akan ditampilkan sesuai urutan ini.
                        </p>
                        @error('order')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-bold text-gray-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" id="content" rows="12" required
                                  class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 @error('content') border-red-300 @enderror font-mono text-sm"
                                  placeholder="Tulis materi pembelajaran Anda di sini...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm text-purple-800">
                                <p class="font-bold mb-1">Tips Membuat Content:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Gunakan bahasa yang jelas dan mudah dipahami</li>
                                    <li>Bagi materi menjadi bagian-bagian kecil</li>
                                    <li>Berikan contoh untuk memperjelas konsep</li>
                                    <li>Pastikan urutan content sudah tepat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-8">
                    <button type="submit" class="flex-1 px-8 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition shadow-lg">
                        Create Content
                    </button>
                    <a href="{{ route('teacher.contents.index', $course) }}" class="flex-1 px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection