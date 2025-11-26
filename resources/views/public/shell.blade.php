@extends('public.shell')
@section('public-content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="bg-white p-6 rounded shadow text-center">
            <h1 class="text-3xl font-bold mb-4">Welcome to HanApp!</h1>
            <p class="text-gray-700 mb-6">Discover and manage your favorite foodspots with ease.</p>
            <a href="{{ route('owner.foodspots.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Manage Foodspots</a>
        </div>
    </div>
@endsection
