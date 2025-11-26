<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Foodspot;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review for a foodspot.
     */
    public function store(Request $request, Foodspot $foodspot)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        // Check if user already reviewed this foodspot
        $existing = Review::where('user_id', $user->id)
            ->where('foodspot_id', $foodspot->id)
            ->first();

        if ($existing) {
            // Update existing review
            $existing->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Your review has been updated.');
        }

        // Create new review
        Review::create([
            'user_id' => $user->id,
            'foodspot_id' => $foodspot->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Delete a review (only the owner of the review can delete).
     */
    public function destroy(Request $request, Foodspot $foodspot, Review $review)
    {
        $user = $request->user();

        if ($review->user_id !== $user->id) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
}
