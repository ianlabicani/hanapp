@extends('admin.shell')
@section('admin-content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-list mr-2"></i>Manage Foodspots</h1>
        <a href="{{ route('admin.foodspots.create') }}" class="inline-block bg-blue-600 text-white px-3 py-2 rounded"><i class="fa-solid fa-plus mr-2"></i>New Foodspot</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    @if($foodspots->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($foodspots as $spot)
                <div class="bg-white rounded shadow overflow-hidden">
                    <div class="h-44 bg-gray-100">
                        @php
                            $thumb = $spot->thumbnail ?? ($spot->images[0] ?? null);
                        @endphp
                        @if($thumb)
                            <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $spot->name }}" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-semibold text-lg">{{ $spot->name }}</h3>
                        @if($spot->tagline)
                            <p class="text-sm text-gray-600">{{ $spot->tagline }}</p>
                        @endif
                        <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                            <div>{{ $spot->category }}</div>
                            <div><i class="fa-solid fa-eye mr-1"></i>{{ $spot->visits ?? 0 }}</div>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <a href="{{ route('admin.foodspots.show', $spot) }}" class="text-blue-600 text-sm"><i class="fa-solid fa-eye mr-1"></i>View</a>
                            <a href="{{ route('admin.foodspots.edit', $spot) }}" class="text-yellow-600 text-sm"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                            <button type="button" class="text-red-600 text-sm delete-btn" data-action="{{ route('admin.foodspots.destroy', $spot) }}"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $foodspots->links() }}
        </div>
        @include('admin.foodspots._delete-modal')
    @else
        <p class="text-gray-600">You have no foodspots yet.</p>
    @endif
@endsection
