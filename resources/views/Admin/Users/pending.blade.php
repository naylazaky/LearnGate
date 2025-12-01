@extends('layouts.app')

@section('title', 'Pending Teachers - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <x-back-button />
        </div>
        
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Pending Teachers</h1>
            <p class="text-lg text-gray-600">Tentor yang menunggu approval</p>
        </div>

        @if($pendingTeachers->count() > 0)
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mb-8">
                <div class="flex">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-yellow-800 font-bold">{{ $pendingTeachers->total() }} Tentor menunggu approval Anda</p>
                        <p class="text-yellow-700 text-sm mt-1">Review dan approve/reject tentor yang mendaftar</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pendingTeachers as $teacher)
                <div class="bg-white rounded-2xl border-2 border-yellow-200 p-6 hover:shadow-2xl transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            @if($teacher->profile_photo)
                                <img src="{{ asset('storage/' . $teacher->profile_photo) }}" 
                                     alt="{{ $teacher->username }}"
                                     class="w-12 h-12 rounded-full object-cover mr-3 ring-2 ring-purple-200">
                            @else
                                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white text-lg font-bold mr-3">
                                    {{ $teacher->initials }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">{{ $teacher->username }}</h3>
                                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full mt-1">
                                    Pending
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="truncate">{{ $teacher->email }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Registered: {{ $teacher->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t-2 border-gray-100 space-y-2">
                        <form action="{{ route('admin.users.approve', $teacher) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Approve Teacher
                            </button>
                        </form>

                        <button onclick="openRejectModal({{ $teacher->id }}, '{{ $teacher->username }}')"
                                class="w-full px-4 py-3 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Tolak
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">All Clear!</h3>
                    <p class="text-gray-600 mb-6">Tidak ada tentor yang menunggu approval</p>
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            @endforelse
        </div>

        @if($pendingTeachers->hasPages())
            <div class="mt-12">
                {{ $pendingTeachers->links() }}
            </div>
        @endif
    </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <h3 class="text-2xl font-black text-gray-900 mb-4">Tolak</h3>
        <p class="text-gray-600 mb-6">Anda akan menolak dan menghapus tentor <span id="teacherName" class="font-bold"></span> dari sistem. Tentor ini tidak akan bisa login lagi.</p>
        
        <form id="rejectForm" method="POST">
            @csrf
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4 mb-4">
                <p class="text-red-700 text-sm font-bold">Perhatian: Tentor akan terhapus permanen</p>
            </div>
            
            <textarea name="rejection_reason" rows="4" required
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 mb-4"
                      placeholder="Tuliskan alasan penolakan (opsional untuk log)..."></textarea>
            
            <div class="flex space-x-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(userId, username) {
    document.getElementById('teacherName').textContent = username;
    document.getElementById('rejectForm').action = `/admin/users/${userId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endpush
@endsection