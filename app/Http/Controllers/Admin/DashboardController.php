<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foodspot;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary stats
        $totalFoodspots = Foodspot::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $totalVisits = Foodspot::sum('visits');

        // Top foodspots by visits
        $topFoodspotsByVisits = Foodspot::orderByDesc('visits')->take(5)->get();

        // Top foodspots by rating
        $topFoodspotsByRating = Foodspot::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // Visits trend (last 7 days) - we'll simulate with created_at dates
        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('M d');
        });

        // Reviews by rating distribution
        $ratingDistribution = Review::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Ensure all ratings 1-5 are present
        $ratingData = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingData[$i] = $ratingDistribution[$i] ?? 0;
        }

        // Foodspots by category
        $categoryData = Foodspot::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->take(6)
            ->pluck('count', 'category')
            ->toArray();

        // Recent reviews
        $recentReviews = Review::with(['user', 'foodspot'])->latest()->take(5)->get();

        // Users by role
        $usersByRole = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->selectRaw('roles.name as role, COUNT(*) as count')
            ->groupBy('roles.name')
            ->pluck('count', 'role')
            ->toArray();

        // Recent foodspots
        $recentFoodspots = Foodspot::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalFoodspots',
            'totalUsers',
            'totalReviews',
            'totalVisits',
            'topFoodspotsByVisits',
            'topFoodspotsByRating',
            'last7Days',
            'ratingData',
            'categoryData',
            'recentReviews',
            'usersByRole',
            'recentFoodspots'
        ));
    }
}
