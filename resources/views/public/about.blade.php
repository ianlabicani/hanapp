@extends('shell')

@section('content')
	<div class="min-h-screen bg-white">
		<div class="max-w-7xl mx-auto px-4 py-16">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
				<div>
					<div class="inline-flex items-center gap-3 mb-4">
						<div class="flex items-center justify-center w-12 h-12 rounded bg-gradient-to-br from-orange-400 to-red-500 text-white">
							<i class="fa-solid fa-utensils"></i>
						</div>
						<div>
							<div class="text-lg font-semibold text-gray-800">HanApp</div>
							<div class="text-sm text-gray-500">Discover local foodspots</div>
						</div>
					</div>

					<h1 class="text-4xl font-extrabold mb-4 text-gray-900">About HanApp</h1>
					<p class="text-gray-600 mb-6">HanApp helps food lovers discover neighbourhood foodspots and gives owners a simple way to list and manage their locations and images. We focus on local discovery, beautiful photos, and easy management.</p>

					<a href="{{ route('foodspots.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded shadow">Browse Foodspots</a>
					<a href="{{ route('register') }}" class="inline-block border border-gray-200 text-gray-700 px-5 py-3 rounded ml-3">List Your Spot</a>
				</div>

				<div class="hidden lg:block">
					<div class="w-full h-96 rounded-lg overflow-hidden shadow-lg bg-gray-100 flex items-center justify-center">
						<img src="https://images.unsplash.com/photo-1541542684-2f9b1d3d3c6b?q=80&w=1400&auto=format&fit=crop&ixlib=rb-4.0.3&s=7a2e6f3b6f9a1e3b" alt="About HanApp" class="w-full h-full object-cover">
					</div>
				</div>
			</div>

			<section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="p-6 bg-gray-50 rounded-lg shadow-sm">
					<h3 class="font-semibold text-lg mb-2">Our Mission</h3>
					<p class="text-sm text-gray-600">Connect people to memorable local food experiences and empower small food businesses with simple tools to showcase their spots.</p>
				</div>

				<div class="p-6 bg-gray-50 rounded-lg shadow-sm">
					<h3 class="font-semibold text-lg mb-2">How It Works</h3>
					<ol class="text-sm text-gray-600 list-decimal list-inside space-y-2">
						<li>Browse nearby foodspots and view galleries.</li>
						<li>Owners can claim their spot and manage images and details.</li>
						<li>Discover, save, and visit — all in one place.</li>
					</ol>
				</div>

				<div class="p-6 bg-gray-50 rounded-lg shadow-sm">
					<h3 class="font-semibold text-lg mb-2">Privacy & Safety</h3>
					<p class="text-sm text-gray-600">We keep owner data private and secure. Images are moderated by owners and can be removed at any time. For full details see our privacy policy.</p>
				</div>
			</section>

			<section class="mt-12">
				<h2 class="text-2xl font-semibold mb-4">Meet The Team</h2>
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
					<div class="bg-white p-4 rounded shadow-sm flex items-center gap-4">
						<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">JS</div>
						<div>
							<div class="font-semibold">Jamie Smith</div>
							<div class="text-sm text-gray-500">Founder & Developer</div>
						</div>
					</div>

					<div class="bg-white p-4 rounded shadow-sm flex items-center gap-4">
						<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">AM</div>
						<div>
							<div class="font-semibold">Ava Martinez</div>
							<div class="text-sm text-gray-500">Design & UX</div>
						</div>
					</div>

					<div class="bg-white p-4 rounded shadow-sm flex items-center gap-4">
						<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">RK</div>
						<div>
							<div class="font-semibold">Ravi Kapoor</div>
							<div class="text-sm text-gray-500">Community</div>
						</div>
					</div>
				</div>
			</section>

			<section class="mt-12 bg-indigo-50 p-8 rounded-lg flex flex-col md:flex-row items-center justify-between">
				<div>
					<h3 class="text-xl font-semibold">Ready to discover new foodspots?</h3>
					<p class="text-gray-600">Start exploring local favourites and share your own spot with the community.</p>
				</div>
				<div class="mt-4 md:mt-0">
					<a href="{{ route('foodspots.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded">Browse Foodspots</a>
				</div>
			</section>
		</div>
	</div>
@endsection

