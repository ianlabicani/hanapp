@extends('owner.shell')
@section('owner-content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">{{ $foodspot->name }}</h1>
            <div>
                <a href="{{ route('owner.foodspots.edit', $foodspot) }}" class="text-sm text-yellow-600 mr-2">Edit</a>
                <a href="{{ route('owner.foodspots.index') }}" class="text-sm text-gray-600">Back</a>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-700"><strong>Category:</strong> {{ $foodspot->category }}</p>
            <p class="text-gray-700"><strong>Tagline:</strong> {{ $foodspot->tagline }}</p>
            <p class="text-gray-700"><strong>Address:</strong> {{ $foodspot->address }}</p>
            <p class="text-gray-700"><strong>Contact:</strong> {{ $foodspot->contact_number }} - {{ $foodspot->email }}</p>
            <p class="text-gray-700 mt-4">{{ $foodspot->description }}</p>
        </div>
    </div>
@endsection
