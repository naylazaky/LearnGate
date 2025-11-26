<nav class="bg-white shadow-sm sticky top-0 z-50 backdrop-blur-lg bg-opacity-90">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">
                        <span class="text-black">Learn</span><span class="text-blue-600">Gate</span>
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('courses.catalog') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                    Courses
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'teacher')
                        <a href="{{ route('teacher.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'student')
                        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            My Learning
                        </a>
                    @endif
                    <div class="ml-3 flex items-center space-x-3 pl-3 border-l border-gray-200">
                        <div class="flex items-center px-3 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-2 shadow-sm">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->username }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="ml-2 px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-md hover:shadow-lg">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@hasSection('breadcrumb')
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-2 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 flex items-center transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
                @yield('breadcrumb')
            </div>
        </div>
    </div>
@endif