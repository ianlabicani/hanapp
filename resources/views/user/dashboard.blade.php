@extends('user.shell')
@section('user-content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-gauge-high mr-2"></i>Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 rounded shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-comments fa-lg"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-blue-600">{{ $totalReviews }}</p>
                    <p class="text-sm text-gray-600">Total Reviews</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Reviews --}}
    <div class="bg-white rounded shadow">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold"><i class="fa-solid fa-clock-rotate-left mr-2"></i>Recent Reviews</h2>
            <a href="{{ route('user.reviews.index') }}" class="text-blue-600 text-sm hover:underline">View all</a>
        </div>

        @if($recentReviews->count())
            <div class="divide-y">
                @foreach($recentReviews as $review)
                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    @php
                                        $thumb = $review->foodspot->thumbnail ?? ($review->foodspot->images[0] ?? null);
                                    @endphp
                                    @if($thumb)
                                        <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $review->foodspot->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('public.foodspots.show', $review->foodspot) }}" class="font-medium text-gray-800 hover:text-blue-600">
                                        {{ $review->foodspot->name }}
                                    </a>
                                    <div class="flex items-center text-yellow-500 text-sm mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <i class="fa-solid fa-comments fa-3x mb-3 text-gray-300"></i>
                <p>You haven't written any reviews yet.</p>
                <a href="{{ route('public.foodspots.index') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Browse foodspots</a>
            </div>
        @endif
    </div>
@endsection
