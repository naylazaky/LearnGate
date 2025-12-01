@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <x-back-button />
        </div>
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-black text-gray-900 mb-2">Kelola User</h1>
                <p class="text-lg text-gray-600">Kelola semua pengguna platform</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah User
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-2 border-gray-100">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Cari</label>
                        <input type="text" name="search" placeholder="Cari username atau email..." 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                               value="{{ request('search') }}">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                        <select name="role" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Tentor</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Actions</label>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                Filter
                            </button>
                            @if(request('search') || request('role'))
                                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                 alt="{{ $user->username }}"
                                                 class="w-10 h-10 rounded-full object-cover mr-3 ring-2 ring-blue-100">
                                        @else
                                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                                {{ $user->initials }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $user->username }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $user->email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $user->role === 'teacher' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $user->role === 'student' ? 'bg-green-100 text-green-700' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Aktif</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if($user->role !== 'admin')
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700 font-bold" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 font-bold" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada user ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection