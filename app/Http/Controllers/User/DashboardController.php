<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $recentReviews = $user->reviews()->with('foodspot')->latest()->take(5)->get();
        $totalReviews = $user->reviews()->count();

        return view('user.dashboard', compact('recentReviews', 'totalReviews'));
    }
}
