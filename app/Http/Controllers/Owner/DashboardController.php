<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Summary stats for owner's foodspots
        $foodspots = $user->foodspots()->withCount('reviews')->withAvg('reviews', 'rating')->get();
        $totalFoodspots = $foodspots->count();
        $totalVisits = $foodspots->sum('visits');
        $totalReviews = $foodspots->sum('reviews_count');
        $averageRating = $foodspots->avg('reviews_avg_rating');

        // Top foodspots by visits
        $topFoodspotsByVisits = $user->foodspots()->orderByDesc('visits')->take(5)->get();

        // Top foodspots by rating
        $topFoodspotsByRating = $user->foodspots()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // Visits per foodspot (for bar chart)
        $visitsPerFoodspot = $user->foodspots()
            ->orderByDesc('visits')
            ->take(6)
            ->pluck('visits', 'name')
            ->toArray();

        // Rating distribution across all owned foodspots
        $foodspotIds = $user->foodspots()->pluck('id');
        $ratingDistribution = Review::whereIn('foodspot_id', $foodspotIds)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Ensure all ratings 1-5 are present
        $ratingData = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingData[$i] = $ratingDistribution[$i] ?? 0;
        }

        // Recent reviews for owner's foodspots
        $recentReviews = Review::whereIn('foodspot_id', $foodspotIds)
            ->with(['user', 'foodspot'])
            ->latest()
            ->take(5)
            ->get();

        // Foodspots by category
        $categoryData = $user->foodspots()
            ->selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return view('owner.dashboard', compact(
            'totalFoodspots',
            'totalVisits',
            'totalReviews',
            'averageRating',
            'topFoodspotsByVisits',
            'topFoodspotsByRating',
            'visitsPerFoodspot',
            'ratingData',
            'recentReviews',
            'categoryData'
        ));
    }
}
