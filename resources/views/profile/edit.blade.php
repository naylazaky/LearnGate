@extends('layouts.app')

@section('title', 'Edit Profile - LearnGate')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Edit Profile</h1>
            <p class="text-lg text-gray-600">Update informasi profil Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-100">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-8 pb-8 border-b-2 border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 mb-4">Profile Photo</h2>
                    <div class="flex items-center space-x-6">
                        <div id="photo-preview">
                            @if($user->profile_photo)
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                    {{ $user->initials }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label for="profile_photo" class="block text-sm font-bold text-gray-700 mb-2">
                                Upload New Photo
                            </label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer"
                                   onchange="previewPhoto(event)">
                            <p class="mt-2 text-xs text-gray-500">JPG, PNG atau JPEG. Max 2MB.</p>
                            @error('profile_photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            @if($user->profile_photo)
                                <button type="button" onclick="deletePhoto()" class="mt-3 text-sm font-bold text-red-600 hover:text-red-700">
                                    Remove Photo
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6 mb-8 pb-8 border-b-2 border-gray-100">
                    <h2 class="text-xl font-black text-gray-900">Basic Information</h2>
                    
                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" required
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('username') border-red-300 @enderror"
                               placeholder="Your username">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                            @if($user->role === 'admin')
                                <span class="text-xs text-gray-500 font-normal ml-2">(Cannot be changed)</span>
                            @endif
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               required
                               value="{{ old('email', $user->email) }}"
                               @if($user->role === 'admin') readonly @endif
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('email') border-red-300 @enderror {{ $user->role === 'admin' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                               placeholder="your@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($user->role === 'admin')
                            <p class="mt-2 text-xs text-gray-500">Admin email cannot be changed for security reasons.</p>
                        @endif
                    </div>

                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-gray-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm text-gray-700">
                                <p class="font-bold mb-1">Account Info:</p>
                                <ul class="space-y-1">
                                    <li>• Role: <strong class="text-gray-900">{{ ucfirst($user->role) }}</strong></li>
                                    <li>• Member since: <strong class="text-gray-900">{{ $user->created_at->format('d M Y') }}</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 mb-1">Change Password</h2>
                        <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    <div>
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" name="current_password" id="current_password"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('current_password') border-red-300 @enderror"
                               placeholder="Enter current password">
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            New Password
                        </label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 @error('password') border-red-300 @enderror"
                               placeholder="Enter new password (min 8 characters)">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                               placeholder="Confirm new password">
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-8">
                    <button type="submit" class="flex-1 px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        Save Changes
                    </button>
                    <a href="{{ route('profile.show') }}" class="flex-1 px-8 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-photo-form" action="{{ route('profile.delete-photo') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').innerHTML = 
                `<img src="${e.target.result}" class="w-24 h-24 rounded-2xl object-cover shadow-lg">`;
        }
        reader.readAsDataURL(file);
    }
}

function deletePhoto() {
    if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
        document.getElementById('delete-photo-form').submit();
    }
}
</script>
@endpush
@endsection