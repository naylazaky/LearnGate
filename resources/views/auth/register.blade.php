@extends('layouts.app')

@section('title', 'Register - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-3xl font-bold">
                    <span class="text-gray-900">Learn</span><span class="text-blue-600">Gate</span>
                </span>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-black text-gray-900">
            Buat Akun Baru
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border-2 border-gray-100">
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-3">
                    Daftar Sebagai
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" id="studentTab" onclick="switchRole('student')"
                        class="role-tab px-4 py-3 border-2 border-blue-600 bg-blue-600 text-white rounded-xl font-bold transition hover:bg-blue-700">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Siswa
                        </div>
                    </button>
                    <button type="button" id="teacherTab" onclick="switchRole('teacher')"
                        class="role-tab px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-xl font-bold transition hover:border-blue-300 hover:bg-blue-50">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Tentor
                        </div>
                    </button>
                </div>
            </div>

            <div id="studentInfo" class="mb-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            Gunakan email dengan domain <strong>@gmail.com</strong> untuk mendaftar sebagai siswa.
                        </p>
                    </div>
                </div>
            </div>

            <div id="teacherInfo" class="mb-6 bg-purple-50 border-2 border-purple-200 rounded-xl p-4 hidden">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-purple-800">
                            Gunakan email dengan domain <strong>@learngate.com</strong>. Akun tentor memerlukan persetujuan admin sebelum dapat digunakan.
                        </p>
                    </div>
                </div>
            </div>

            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf

                <input type="hidden" name="role" id="roleInput" value="student">

                <div>
                    <label for="username" class="block text-sm font-bold text-gray-700">
                        Username
                    </label>
                    <div class="mt-1">
                        <input id="username" name="username" type="text" autocomplete="username" required
                            value="{{ old('username') }}"
                            placeholder="Masukkan username Anda"
                            class="appearance-none block w-full px-4 py-3 border-2 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('username') border-red-300 @enderror">
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700">
                        Email
                    </label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            placeholder="contoh@gmail.com"
                            class="appearance-none block w-full px-4 py-3 border-2 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('email') border-red-300 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            placeholder="Buat password Anda"
                            class="appearance-none block w-full px-4 py-3 border-2 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('password') border-red-300 @enderror">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700">
                        Konfirmasi Password
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            placeholder="Konfirmasi password Anda"
                            class="appearance-none block w-full px-4 py-3 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 transition">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Masuk di sini
            </a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    function switchRole(role) {
        const roleInput = document.getElementById('roleInput');
        const studentTab = document.getElementById('studentTab');
        const teacherTab = document.getElementById('teacherTab');
        const studentInfo = document.getElementById('studentInfo');
        const teacherInfo = document.getElementById('teacherInfo');
        const emailInput = document.getElementById('email');
        const emailHint = document.getElementById('emailHint');

        roleInput.value = role;

        if (role === 'student') {
            studentTab.className = 'role-tab px-4 py-3 border-2 border-blue-600 bg-blue-600 text-white rounded-xl font-bold transition';
            teacherTab.className = 'role-tab px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-xl font-bold transition hover:border-blue-300 hover:bg-blue-50';
            
            studentInfo.classList.remove('hidden');
            teacherInfo.classList.add('hidden');
            
            emailInput.placeholder = 'contoh@gmail.com';
            emailHint.textContent = '@gmail.com';
        } else {
            teacherTab.className = 'role-tab px-4 py-3 border-2 border-purple-600 bg-purple-600 text-white rounded-xl font-bold transition';
            studentTab.className = 'role-tab px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-xl font-bold transition hover:border-blue-300 hover:bg-blue-50';
            
            studentInfo.classList.add('hidden');
            teacherInfo.classList.remove('hidden');
            
            emailInput.placeholder = 'contoh@learngate.com';
            emailHint.textContent = '@learngate.com';
        }
    }
</script>
@endpush
@endsection