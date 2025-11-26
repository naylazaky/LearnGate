@extends('layouts.app')

@section('title', 'Registrasi Berhasil - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-12 px-4 shadow-xl sm:rounded-2xl sm:px-10 border-2 border-gray-100">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                @if(session('role') === 'teacher')
                    <h2 class="text-2xl font-black text-gray-900 mb-4">
                        Registrasi Berhasil!
                    </h2>
                    <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mb-6 text-left">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-yellow-800">Menunggu Persetujuan Admin</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Akun tentor Anda telah berhasil dibuat dan sedang menunggu persetujuan dari admin.</p>
                                    <p class="mt-2">Anda akan menerima notifikasi setelah akun Anda disetujui. Silahkan coba login nanti untuk mengecek status akun Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('login') }}"
                            class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition shadow-lg">
                            Ke Halaman Login
                        </a>
                        <a href="{{ route('home') }}"
                            class="w-full inline-flex justify-center items-center px-6 py-3 border-2 border-gray-300 text-base font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition">
                            Kembali ke Beranda
                        </a>
                    </div>
                @else
                    <h2 class="text-2xl font-black text-gray-900 mb-4">
                        Selamat Datang di LearnGate!
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Akun Anda telah berhasil dibuat. Silakan login untuk memulai belajar.
                    </p>
                    
                    <a href="{{ route('login') }}"
                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition shadow-lg">
                        Login Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection