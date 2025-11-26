@extends('user.shell')
@section('user-content')
    <div class="max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit Review</h1>
            <a href="{{ route('user.reviews.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i>Back to Reviews
            </a>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Foodspot Info --}}
        <div class="bg-white rounded shadow p-4 mb-4">
            <div class="flex items-center">
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
                <div class="ml-4">
                    <h2 class="font-semibold text-gray-800">{{ $review->foodspot->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $review->foodspot->category ?? 'Foodspot' }}</p>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="bg-white rounded shadow p-6">
            <form action="{{ route('user.reviews.update', $review) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-1" id="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden star-input" {{ $review->rating == $i ? 'checked' : '' }} required>
                                <i class="fa-star text-3xl {{ $review->rating >= $i ? 'fa-solid text-yellow-500' : 'fa-regular text-gray-300' }} hover:text-yellow-500 star-icon" data-value="{{ $i }}"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded shadow-sm" placeholder="Share your experience...">{{ old('comment', $review->comment) }}</textarea>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fa-solid fa-floppy-disk mr-1"></i>Update Review
                    </button>
                    <a href="{{ route('user.reviews.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const starIcons = document.querySelectorAll('.star-icon');
    starIcons.forEach(function(star) {
        star.addEventListener('click', function() {
            const value = parseInt(star.getAttribute('data-value'));
            starIcons.forEach(function(s, idx) {
                if (idx < value) {
                    s.classList.remove('fa-regular', 'text-gray-300');
                    s.classList.add('fa-solid', 'text-yellow-500');
                } else {
                    s.classList.remove('fa-solid', 'text-yellow-500');
                    s.classList.add('fa-regular', 'text-gray-300');
                }
            });
        });
    });
});
</script>
@endpush
@endsection
