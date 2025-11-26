<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Summary stats
        $recentReviews = $user->reviews()->with('foodspot')->latest()->take(5)->get();
        $totalReviews = $user->reviews()->count();

        // Rating distribution of user's reviews
        $ratingDistribution = $user->reviews()
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

        // Average rating user gives
        $averageRatingGiven = $user->reviews()->avg('rating');

        // Reviews by category (via foodspot)
        $reviewsByCategory = $user->reviews()
            ->join('foodspots', 'reviews.foodspot_id', '=', 'foodspots.id')
            ->selectRaw('foodspots.category, COUNT(*) as count')
            ->whereNotNull('foodspots.category')
            ->groupBy('foodspots.category')
            ->pluck('count', 'category')
            ->toArray();

        return view('user.dashboard', compact(
            'recentReviews',
            'totalReviews',
            'ratingData',
            'averageRatingGiven',
            'reviewsByCategory'
        ));
    }
}
