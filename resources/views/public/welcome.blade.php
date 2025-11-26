@extends('public.shell')

@section('public-content')
    <div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
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

                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-gray-900">Find delicious food near you</h1>
                    <p class="text-gray-600 mb-6">Explore neighbourhood foodspots, see photos, read descriptions, and discover new places to eat. Owners can claim and manage their listings.</p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('public.foodspots.index') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded shadow">Browse Foodspots</a>
                        <a href="{{ route('register') }}" class="inline-block border border-gray-200 text-gray-700 px-5 py-3 rounded hover:bg-gray-50">List your spot</a>
                    </div>

                    <form method="GET" action="{{ route('public.foodspots.index') }}" class="mt-8">
                        <label for="q" class="sr-only">Search foodspots</label>
                        <div class="flex items-center gap-2 max-w-md">
                            <input id="q" name="q" type="search" placeholder="Search by name, tagline or category" class="w-full border rounded px-4 py-3" value="{{ request('q') }}">
                            <button class="bg-indigo-600 text-white px-4 py-3 rounded">Search</button>
                        </div>
                    </form>
                </div>

                <div class="hidden lg:block">
                    <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg bg-gray-100 flex items-center justify-center">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1400&auto=format&fit=crop&ixlib=rb-4.0.3&s=0c3e6b1c8e8d6d5a9d7c2f9d6e4a1e2f" alt="Food" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <section class="mt-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Latest Foodspots</h2>
                    <a href="{{ route('public.foodspots.index') }}" class="text-sm text-indigo-600">See all</a>
                </div>

                @php $spots = \App\Models\Foodspot::latest()->take(8)->get(); @endphp

                @if($spots->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($spots as $spot)
                            <article class="bg-white rounded shadow overflow-hidden">
                                <a href="{{ route('public.foodspots.show', $spot) }}" class="block">
                                    @php $thumb = $spot->thumbnail ?? ($spot->images[0] ?? null); @endphp
                                    @if($thumb)
                                        <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $spot->name }}" class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-3">
                                    <h3 class="font-semibold text-lg"><a href="{{ route('public.foodspots.show', $spot) }}">{{ $spot->name }}</a></h3>
                                    @if($spot->tagline)
                                        <p class="text-sm text-gray-600 mt-1">{{ $spot->tagline }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No foodspots yet — be the first to <a href="{{ route('register') }}" class="text-indigo-600">list a spot</a>.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
