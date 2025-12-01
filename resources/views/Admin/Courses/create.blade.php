@extends('layouts.app')

@section('title', 'Add Course - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <x-back-button />
        </div>
        
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Tambahkan Course Baru</h1>
            <p class="text-lg text-gray-600">Tambahkan course baru ke platform</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Course<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('title') border-red-300 @enderror"
                               placeholder="Masukkan judul course">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('description') border-red-300 @enderror"
                                  placeholder="Deskripsi course">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('category_id') border-red-300 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="teacher_id" class="block text-sm font-bold text-gray-700 mb-2">
                                Teacher <span class="text-red-500">*</span>
                            </label>
                            <select name="teacher_id" id="teacher_id" required
                                    class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('teacher_id') border-red-300 @enderror">
                                <option value="">Pilih Tentor</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->username }} ({{ $teacher->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" required
                                   value="{{ old('start_date') }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('start_date') border-red-300 @enderror">
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" required
                                   value="{{ old('end_date') }}"
                                   class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('end_date') border-red-300 @enderror">
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-bold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="is_active" id="is_active" required
                                class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-bold mb-1">Tips:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pastikan memilih teacher yang sudah approved</li>
                                    <li>End date harus setelah start date</li>
                                    <li>Course dapat diubah statusnya kapan saja</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-8">
                    <button type="submit" class="flex-1 px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        Buat
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="flex-1 px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection