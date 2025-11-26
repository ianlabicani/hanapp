@extends('user.shell')
@section('user-content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-gauge-high mr-2"></i>Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ $totalReviews }}</p>
                    <p class="text-blue-100">Total Reviews</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-comments fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ $averageRatingGiven ? number_format($averageRatingGiven, 1) : '—' }}</p>
                    <p class="text-yellow-100">Avg. Rating Given</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-star fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ count($reviewsByCategory) }}</p>
                    <p class="text-green-100">Categories Explored</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-tags fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Rating Distribution --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-star mr-2 text-yellow-500"></i>My Rating Distribution</h2>
            <div class="h-64">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>

        {{-- Reviews by Category --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-tags mr-2 text-green-500"></i>Reviews by Category</h2>
            <div class="h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Reviews --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold"><i class="fa-solid fa-clock-rotate-left mr-2 text-purple-500"></i>My Recent Reviews</h2>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rating Distribution
            new Chart(document.getElementById('ratingChart'), {
                type: 'bar',
                data: {
                    labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
                    datasets: [{
                        label: 'My Reviews',
                        data: @json(array_values($ratingData)),
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(132, 204, 22, 0.8)',
                            'rgba(34, 197, 94, 0.8)'
                        ],
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // Reviews by Category
            const categoryData = @json($reviewsByCategory);
            const hasCategories = Object.keys(categoryData).length > 0;

            if (hasCategories) {
                new Chart(document.getElementById('categoryChart'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(categoryData),
                        datasets: [{
                            data: Object.values(categoryData),
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(139, 92, 246, 0.8)',
                                'rgba(236, 72, 153, 0.8)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            } else {
                document.getElementById('categoryChart').parentElement.innerHTML = '<div class="h-64 flex items-center justify-center text-gray-400"><p>No category data yet</p></div>';
            }
        });
    </script>
@endpush
@endsection
