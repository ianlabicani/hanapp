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

			<div class="hidden md:flex md:items-center md:space-x-6">
				<a href="{{ route('public.foodspots.index') }}" class="text-sm text-gray-700 hover:text-gray-900"><i class="fa-solid fa-magnifying-glass mr-2"></i>Browse</a>
				<a href="{{ route('public.about') }}" class="text-sm text-gray-700 hover:text-gray-900"><i class="fa-solid fa-circle-info mr-2"></i>About</a>
				<form method="GET" action="{{ route('public.foodspots.index') }}" class="ml-4">
					<label for="nav-search" class="sr-only">Search</label>
					<input id="nav-search" name="q" type="search" placeholder="Search" value="{{ request('q') }}" class="border rounded px-2 py-1 text-sm" />
				</form>
			</div>

			<div class="flex items-center md:hidden">
				<button id="nav-toggle" aria-label="Open menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
					<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<div id="nav-mobile" class="md:hidden hidden border-t">
		<div class="px-4 pt-4 pb-4 space-y-2">
			<a href="{{ route('public.foodspots.index') }}" class="block text-gray-700 hover:text-gray-900"><i class="fa-solid fa-magnifying-glass mr-2"></i>Browse Foodspots</a>
			<a href="{{ route('public.about') }}" class="block text-gray-700 hover:text-gray-900"><i class="fa-solid fa-circle-info mr-2"></i>About</a>
			<form method="GET" action="{{ url('foodspots.index') }}" class="mt-2">
				<label for="nav-search-mobile" class="sr-only">Search</label>
				<input id="nav-search-mobile" name="q" type="search" placeholder="Search" value="{{ request('q') }}" class="w-full border rounded px-2 py-2 text-sm" />
			</form>
			<div class="pt-2 border-t">
				@auth
					<a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-gray-900">Dashboard</a>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<button type="submit" class="w-full text-left text-gray-700 hover:text-gray-900 mt-2">Log out</button>
					</form>
				@else
					<a href="{{ route('login') }}" class="block text-gray-700 hover:text-gray-900"><i class="fa-solid fa-right-to-bracket mr-2"></i>Log in</a>
					<a href="{{ route('register') }}" class="block text-gray-700 hover:text-gray-900"><i class="fa-solid fa-user-plus mr-2"></i>Register</a>
				@endauth
			</div>
		</div>
	</div>

	<script>
		(function(){
			var btn = document.getElementById('nav-toggle');
			var menu = document.getElementById('nav-mobile');
			if(!btn || !menu) return;
			btn.addEventListener('click', function(){
				menu.classList.toggle('hidden');
			});
		})();
	</script>
</nav>
