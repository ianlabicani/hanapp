<nav class="bg-white border-b">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex items-center">
				<a href="{{ route('welcome') }}" class="flex items-center gap-3 no-underline">
					<div class="flex items-center justify-center w-10 h-10 rounded bg-gradient-to-br from-orange-400 to-red-500 text-white">
						<i class="fa-solid fa-utensils"></i>
					</div>
					<div class="hidden sm:block">
						<div class="text-lg font-semibold text-gray-800">HanApp</div>
						<div class="text-xs text-gray-500">Discover local foodspots</div>
					</div>
				</a>
			</div>

			<div class="flex items-center space-x-6">
				<a href="{{ route('public.foodspots.index') }}" class="text-sm text-gray-700 hover:text-gray-900"><i class="fa-solid fa-magnifying-glass mr-2"></i>Browse</a>
				<a href="{{ route('public.about') }}" class="text-sm text-gray-700 hover:text-gray-900"><i class="fa-solid fa-circle-info mr-2"></i>About</a>
				<form method="GET" action="{{ route('public.foodspots.index') }}" class="ml-4">
					<label for="nav-search" class="sr-only">Search</label>
					<input id="nav-search" name="q" type="search" placeholder="Search" value="{{ request('q') }}" class="border rounded px-2 py-1 text-sm" />
				</form>

				<div class="ml-6 flex items-center space-x-4">
					@auth
						<a href="{{ route('dashboard') }}" class="text-sm text-gray-700 hover:text-gray-900">Dashboard</a>
						<form method="POST" action="{{ route('logout') }}" class="inline">
							@csrf
							<button type="submit" class="text-sm text-gray-700 hover:text-gray-900">Log out</button>
						</form>
					@else
						<a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Log in</a>
						<a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
					@endauth
				</div>
			</div>
			</div>
		</div>
</nav>
