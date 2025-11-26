@extends('owner.shell')

@section('owner-content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-gauge-high mr-2"></i>Owner Dashboard</h1>
        <p class="text-gray-600">Your foodspot analytics and performance</p>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalFoodspots) }}</p>
                    <p class="text-blue-100">My Foodspots</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-utensils fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalVisits) }}</p>
                    <p class="text-orange-100">Total Visits</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-eye fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ number_format($totalReviews) }}</p>
                    <p class="text-purple-100">Total Reviews</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-comments fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ $averageRating ? number_format($averageRating, 1) : '—' }}</p>
                    <p class="text-yellow-100">Avg. Rating</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-star fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Visits per Foodspot --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-chart-bar mr-2 text-blue-500"></i>Visits by Foodspot</h2>
            <div class="h-64">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        {{-- Rating Distribution --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-star mr-2 text-yellow-500"></i>Rating Distribution</h2>
            <div class="h-64">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Second Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Categories --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4"><i class="fa-solid fa-tags mr-2 text-green-500"></i>My Foodspots by Category</h2>
            <div class="h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        {{-- Top Rated --}}
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold"><i class="fa-solid fa-trophy mr-2 text-yellow-500"></i>My Top Rated Foodspots</h2>
            </div>
            <div class="divide-y">
                @forelse($topFoodspotsByRating as $spot)
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                @php $thumb = $spot->thumbnail ?? ($spot->images[0] ?? null); @endphp
                                @if($thumb)
                                    <img src="{{ asset('storage/' . $thumb) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <a href="{{ route('owner.foodspots.show', $spot) }}" class="font-medium text-gray-800 hover:text-blue-600">{{ $spot->name }}</a>
                                <p class="text-sm text-gray-500">{{ $spot->reviews_count }} reviews</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center text-yellow-500 mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($spot->reviews_avg_rating))
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @else
                                        <i class="fa-regular fa-star text-xs"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm font-medium">{{ number_format($spot->reviews_avg_rating, 1) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">No rated foodspots yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Reviews --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold"><i class="fa-solid fa-clock-rotate-left mr-2 text-purple-500"></i>Recent Reviews on My Foodspots</h2>
        </div>
        <div class="divide-y">
            @forelse($recentReviews as $review)
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                @php $thumb = $review->foodspot->thumbnail ?? ($review->foodspot->images[0] ?? null); @endphp
                                @if($thumb)
                                    <img src="{{ asset('storage/' . $thumb) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-800">{{ $review->user->name }}</span>
                                    <span class="text-gray-400">reviewed</span>
                                    <a href="{{ route('owner.foodspots.show', $review->foodspot) }}" class="text-blue-600 hover:underline">{{ $review->foodspot->name }}</a>
                                </div>
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
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($review->comment, 100) }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fa-solid fa-comments fa-3x mb-3 text-gray-300"></i>
                    <p>No reviews on your foodspots yet.</p>
                </div>
            @endforelse
        </div>
    </div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Visits per Foodspot
            new Chart(document.getElementById('visitsChart'), {
                type: 'bar',
                data: {
                    labels: @json(array_keys($visitsPerFoodspot)),
                    datasets: [{
                        label: 'Visits',
                        data: @json(array_values($visitsPerFoodspot)),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Rating Distribution
            new Chart(document.getElementById('ratingChart'), {
                type: 'bar',
                data: {
                    labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
                    datasets: [{
                        label: 'Reviews',
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

            // Category Distribution
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($categoryData)),
                    datasets: [{
                        data: @json(array_values($categoryData)),
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
        });
    </script>
@endpush
@endsection
