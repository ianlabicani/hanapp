@extends('user.shell')
@section('user-content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-comments mr-2"></i>My Reviews</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if($reviews->count())
        <div class="bg-white rounded shadow divide-y">
            @foreach($reviews as $review)
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start flex-1">
                            <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                @php
                                    $thumb = $review->foodspot->thumbnail ?? ($review->foodspot->images[0] ?? null);
                                @endphp
                                @if($thumb)
                                    <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $review->foodspot->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image fa-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <a href="{{ route('public.foodspots.show', $review->foodspot) }}" class="font-semibold text-gray-800 hover:text-blue-600">
                                    {{ $review->foodspot->name }}
                                </a>
                                <div class="flex items-center text-yellow-500 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-gray-500 text-sm">{{ $review->rating }}/5</span>
                                </div>
                                @if($review->comment)
                                    <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                                @else
                                    <p class="text-gray-400 mt-2 italic">No comment</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">Reviewed {{ $review->created_at->format('M d, Y') }} · {{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <a href="{{ route('user.reviews.edit', $review) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
                            </a>
                            <form action="{{ route('user.reviews.destroy', $review) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Delete this review?')">
                                    <i class="fa-solid fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="bg-white rounded shadow p-8 text-center text-gray-500">
            <i class="fa-solid fa-comments fa-3x mb-3 text-gray-300"></i>
            <p>You haven't written any reviews yet.</p>
            <a href="{{ route('public.foodspots.index') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Browse foodspots to write your first review</a>
        </div>
    @endif
@endsection
