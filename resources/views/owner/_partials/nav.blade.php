<nav class="border-b mb-5">
	<div class="container mx-auto">
		<div class="flex items-center justify-between h-16">
			<div class="flex items-center space-x-6">
				<a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">HanApp</a>

				<a href="{{ route('owner.foodspots.index') }}" class="{{ request()->routeIs('owner.foodspots.*') ? 'text-sm font-semibold text-blue-600' : 'text-sm text-gray-700 hover:text-gray-900' }}">
					<i class="fa-solid fa-utensils mr-2"></i>
					Manage Foodspots
				</a>
			</div>
		</div>
	</div>
</nav>
