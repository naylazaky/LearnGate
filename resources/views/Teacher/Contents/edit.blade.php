@extends('layouts.app')

@section('title', 'Edit Content - ' . $content->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <x-back-button />
        </div>
        
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Edit Materi</h1>
            <p class="text-lg text-gray-600">Ubah materi pembelajaran untuk kursus: <strong>{{ $course->title }}</strong></p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
            <form action="{{ route('teacher.contents.update', [$course, $content]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title', $content->title) }}"
                           class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('title') border-red-300 @enderror"
                           placeholder="Contoh: Pengenalan HTML & CSS">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                        Deskripsi Singkat
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('description') border-red-300 @enderror"
                              placeholder="Jelaskan secara singkat apa yang akan dipelajari di materi ini...">{{ old('description', $content->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Deskripsi ini akan muncul sebagai preview materi</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Tipe Materi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:bg-blue-50 transition @error('content_type') @else border-gray-200 @enderror">
                            <input type="radio" name="content_type" value="text" 
                                   {{ old('content_type', $content->content_type) == 'text' ? 'checked' : '' }}
                                   onchange="toggleContentType()" class="mr-3">
                            <div>
                                <p class="font-bold text-gray-900">Teks</p>
                                <p class="text-xs text-gray-600">Materi dalam bentuk teks/artikel</p>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:bg-blue-50 transition @error('content_type') @else border-gray-200 @enderror">
                            <input type="radio" name="content_type" value="file" 
                                   {{ old('content_type', $content->content_type) == 'file' ? 'checked' : '' }}
                                   onchange="toggleContentType()" class="mr-3">
                            <div>
                                <p class="font-bold text-gray-900">File/Media</p>
                                <p class="text-xs text-gray-600">Video, PDF, dokumen, dll</p>
                            </div>
                        </label>
                    </div>
                    @error('content_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="content-text-section" class="mb-6" style="display: {{ old('content_type', $content->content_type) == 'text' ? 'block' : 'none' }};">
                    <label for="content_text" class="block text-sm font-bold text-gray-700 mb-2">
                        Isi Materi (Teks) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content_text" id="content_text" rows="12"
                              class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 font-mono text-sm @error('content_text') border-red-300 @enderror"
                              placeholder="Tulis materi pembelajaran di sini...">{{ old('content_text', $content->content_text) }}</textarea>
                    @error('content_text')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Anda bisa menggunakan format teks biasa atau Markdown</p>
                </div>

                <div id="content-file-section" class="mb-6" style="display: {{ old('content_type', $content->content_type) == 'file' ? 'block' : 'none' }};">
                    <label for="content_file" class="block text-sm font-bold text-gray-700 mb-2">
                        Upload File/Media
                    </label>
                    
                    @if($content->content_file)
                        <div class="mb-4 p-4 bg-green-50 border-2 border-green-200 rounded-xl">
                            <p class="text-sm font-bold text-green-900 mb-2">File saat ini:</p>
                            <div class="flex items-center justify-between">
                                <a href="{{ $content->content_file_url }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ basename($content->content_file) }}
                                </a>
                            </div>
                            <p class="text-xs text-green-700 mt-2">Upload file baru untuk mengganti file lama</p>
                        </div>
                    @endif
                    
                    <input type="file" name="content_file" id="content_file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer @error('content_file') border-red-300 @enderror">
                    @error('content_file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="mt-3 p-4 bg-blue-50 border-2 border-blue-100 rounded-xl">
                        <p class="text-sm font-bold text-blue-900 mb-2">Format yang didukung:</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• <strong>Dokumen:</strong> PDF, DOC, DOCX, PPT, PPTX</li>
                            <li>• <strong>Video:</strong> MP4, AVI, MOV</li>
                            <li>• <strong>Maksimal ukuran:</strong> 50MB</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="order" class="block text-sm font-bold text-gray-700 mb-2">
                        Urutan Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="order" id="order" required min="1"
                           value="{{ old('order', $content->order) }}"
                           class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('order') border-red-300 @enderror"
                           placeholder="1">
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Urutan saat ini: {{ $content->order }}</p>
                </div>

                <div class="flex items-center space-x-4 pt-6 border-t-2 border-gray-100">
                    <button type="submit" class="flex-1 px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Materi
                    </button>
                    <a href="{{ route('teacher.contents.index', $course) }}" class="flex-1 px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleContentType() {
    const contentType = document.querySelector('input[name="content_type"]:checked').value;
    const textSection = document.getElementById('content-text-section');
    const fileSection = document.getElementById('content-file-section');
    
    if (contentType === 'text') {
        textSection.style.display = 'block';
        fileSection.style.display = 'none';
        document.getElementById('content_text').required = true;
        document.getElementById('content_file').required = false;
    } else {
        textSection.style.display = 'none';
        fileSection.style.display = 'block';
        document.getElementById('content_text').required = false;
        document.getElementById('content_file').required = false; 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleContentType();
});
</script>
@endpush
@endsection