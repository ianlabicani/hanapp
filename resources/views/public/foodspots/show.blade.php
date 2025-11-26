@extends('public.shell')
@section('public-content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded shadow p-4">
                @php $main = $foodspot->thumbnail ?? ($foodspot->images[0] ?? null); @endphp
                <div class="w-full h-96 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                    @if($main)
                        <img src="{{ asset('storage/' . $main) }}" alt="{{ $foodspot->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-400 text-center">
                            <i class="fa-solid fa-image fa-3x"></i>
                            <div class="mt-2">No images</div>
                        </div>
                    @endif
                </div>

                @if(!empty($foodspot->images))
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($foodspot->images as $img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-24 object-cover rounded">
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold">{{ $foodspot->name }}</h1>
                        @php
                            $avgRating = $foodspot->averageRating();
                            $reviewCount = $foodspot->reviews()->count();
                        @endphp
                        @if($avgRating)
                            <div class="flex items-center text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating))
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 text-sm">{{ $avgRating }} ({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                            </div>
                        @endif
                    </div>
                    @if($foodspot->tagline)
                        <p class="text-gray-600 mt-1">{{ $foodspot->tagline }}</p>
                    @endif
                    <p class="mt-4 text-gray-700">{{ $foodspot->description }}</p>
                </div>
            </div>

            <aside class="bg-white rounded shadow p-4">
                <dl class="text-sm text-gray-700">
                    <div class="mb-3">
                        <dt class="font-medium">Category</dt>
                        <dd>{{ $foodspot->category ?? '—' }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Address</dt>
                        <dd>{{ $foodspot->address ?? '—' }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Contact</dt>
                        <dd>{{ $foodspot->contact_number ?? '—' }} @if($foodspot->email) · <a href="mailto:{{ $foodspot->email }}" class="text-blue-600">{{ $foodspot->email }}</a>@endif</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Opening Hours</dt>
                        <dd>{{ $foodspot->open_time ?? '—' }} @if($foodspot->close_time) - {{ $foodspot->close_time }}@endif</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="font-medium">Coordinates</dt>
                        <dd>
                            @if($foodspot->latitude && $foodspot->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $foodspot->latitude }},{{ $foodspot->longitude }}" target="_blank" class="text-blue-600">View on Google Maps</a>
                            @else
                                —
                            @endif
                        </dd>
                    </div>

                    @if($foodspot->latitude && $foodspot->longitude)
                        <div class="mb-3">
                            <dt class="font-medium mb-2">Location</dt>
                            <dd>
                                <div id="foodspot-map" class="w-full h-48 rounded border"></div>
                            </dd>
                        </div>

                        <div>
                            <dt class="font-medium mb-2">Get Directions</dt>
                            <dd>
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $foodspot->latitude }},{{ $foodspot->longitude }}" target="_blank" class="flex items-center text-sm text-white bg-blue-600 px-3 py-2 rounded hover:bg-blue-700">
                                    <i class="fa-solid fa-diamond-turn-right mr-2"></i>
                                    Directions via Google Maps
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </aside>
        </div>

        {{-- Reviews Section --}}
        <div class="mt-8 bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4"><i class="fa-solid fa-comments mr-2"></i>Reviews</h2>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            {{-- Review Form (authenticated users only) --}}
            @auth
                @php
                    $userReview = $foodspot->reviews()->where('user_id', auth()->id())->first();
                @endphp
                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h3 class="font-medium mb-3">{{ $userReview ? 'Update Your Review' : 'Write a Review' }}</h3>
                    <form action="{{ route('public.foodspots.reviews.store', $foodspot) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <div class="flex items-center space-x-1" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden star-input" {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }} required>
                                        <i class="fa-star text-2xl {{ ($userReview && $userReview->rating >= $i) ? 'fa-solid text-yellow-500' : 'fa-regular text-gray-300' }} hover:text-yellow-500 star-icon" data-value="{{ $i }}"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                            <textarea name="comment" id="comment" rows="3" class="w-full border-gray-300 rounded shadow-sm" placeholder="Share your experience...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                <i class="fa-solid fa-paper-plane mr-1"></i>{{ $userReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                            @if($userReview)
                                <form action="{{ route('public.foodspots.reviews.destroy', [$foodspot, $userReview]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Delete your review?')">
                                        <i class="fa-solid fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-6 p-4 bg-gray-50 rounded text-center">
                    <p class="text-gray-600"><a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a> to write a review.</p>
                </div>
            @endauth

            {{-- Reviews List --}}
            @php
                $reviews = $foodspot->reviews()->with('user')->latest()->get();
            @endphp
            @if($reviews->count())
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-800">{{ $review->masked_name }}</p>
                                        <div class="flex items-center text-yellow-500 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if($review->comment)
                                <p class="mt-2 text-gray-700 text-sm">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No reviews yet. Be the first to review!</p>
            @endif
        </div>
    </div>

@if($foodspot->latitude && $foodspot->longitude)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('foodspot-map');
    if (mapEl && typeof L !== 'undefined') {
        const lat = {{ $foodspot->latitude }};
        const lng = {{ $foodspot->longitude }};

        const map = L.map(mapEl).setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('<strong>{{ addslashes($foodspot->name) }}</strong>')
            .openPopup();
    }

    // Star rating interaction
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

        star.addEventListener('mouseenter', function() {
            const value = parseInt(star.getAttribute('data-value'));
            starIcons.forEach(function(s, idx) {
                if (idx < value) {
                    s.classList.add('text-yellow-400');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            starIcons.forEach(function(s) {
                s.classList.remove('text-yellow-400');
            });
        });
    });
});
</script>
@endpush
@else
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Star rating interaction
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

        star.addEventListener('mouseenter', function() {
            const value = parseInt(star.getAttribute('data-value'));
            starIcons.forEach(function(s, idx) {
                if (idx < value) {
                    s.classList.add('text-yellow-400');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            starIcons.forEach(function(s) {
                s.classList.remove('text-yellow-400');
            });
        });
    });
});
</script>
@endpush
@endif
@endsection
