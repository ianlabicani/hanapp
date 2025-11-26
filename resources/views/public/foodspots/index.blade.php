@extends('shell')
@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Foodspots</h1>
            <form method="GET" action="{{ route('foodspots.index') }}" class="flex items-center space-x-2">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search" class="border rounded px-3 py-1">
                <button class="bg-blue-600 text-white px-3 py-1 rounded">Search</button>
            </form>
        </div>

        @if($foodspots->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($foodspots as $spot)
                    <article class="bg-white rounded shadow overflow-hidden">
                        <a href="{{ route('foodspots.show', $spot) }}" class="block">
                            @php $thumb = $spot->thumbnail ?? ($spot->images[0] ?? null); @endphp
                            @if($thumb)
                                <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $spot->name }}" class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image fa-2x"></i>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg"><a href="{{ route('foodspots.show', $spot) }}">{{ $spot->name }}</a></h3>
                            @if($spot->tagline)
                                <p class="text-sm text-gray-600 mt-1">{{ $spot->tagline }}</p>
                            @endif
                            <div class="mt-3 flex items-center justify-between text-sm text-gray-500">
                                <div>{{ $spot->category ?? '—' }}</div>
                                <div><i class="fa-solid fa-eye mr-1"></i>{{ $spot->visits ?? 0 }}</div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">{{ $foodspots->links() }}</div>
        @else
            <p class="text-gray-600">No foodspots found.</p>
        @endif
    </div>
@endsection
