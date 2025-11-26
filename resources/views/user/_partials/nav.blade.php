<nav class="border-b mb-5">
    <div class="container mx-auto">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">HanApp</a>

                <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'text-sm font-semibold text-blue-600' : 'text-sm text-gray-700 hover:text-gray-900' }}">
                    <i class="fa-solid fa-gauge-high mr-2"></i>
                    Dashboard
                </a>

                <a href="{{ route('user.reviews.index') }}" class="{{ request()->routeIs('user.reviews.*') ? 'text-sm font-semibold text-blue-600' : 'text-sm text-gray-700 hover:text-gray-900' }}">
                    <i class="fa-solid fa-comments mr-2"></i>
                    My Reviews
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-700 hover:text-gray-900 inline-flex items-center">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
