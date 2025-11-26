@extends('owner.shell')
@section('owner-content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold"><i class="fa-solid fa-utensils mr-2"></i>{{ $foodspot->name }}</h1>
            <div>
                <a href="{{ route('owner.foodspots.edit', $foodspot) }}" class="text-sm text-yellow-600 mr-2"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                <a href="{{ route('owner.foodspots.index') }}" class="text-sm text-gray-600"><i class="fa-solid fa-arrow-left mr-1"></i>Back</a>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-700"><i class="fa-solid fa-tag mr-2"></i><strong>Category:</strong> {{ $foodspot->category }}</p>
            <p class="text-gray-700"><i class="fa-solid fa-comment-alt mr-2"></i><strong>Tagline:</strong> {{ $foodspot->tagline }}</p>
            <p class="text-gray-700"><i class="fa-solid fa-location-dot mr-2"></i><strong>Address:</strong> {{ $foodspot->address }}</p>
            <p class="text-gray-700"><i class="fa-solid fa-phone mr-2"></i><strong>Contact:</strong> {{ $foodspot->contact_number }} - {{ $foodspot->email }}</p>
            <p class="text-gray-700 mt-4">{{ $foodspot->description }}</p>

            @if(!empty($foodspot->images))
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Images</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($foodspot->images as $img)
                            <img src="{{ asset('storage/' . $img) }}" alt="" class="w-full h-32 object-cover rounded">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
