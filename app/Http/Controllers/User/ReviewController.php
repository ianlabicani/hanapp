<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the user's reviews.
     */
    public function index(Request $request)
    {
        $reviews = $request->user()
            ->reviews()
            ->with('foodspot')
            ->latest()
            ->paginate(10);

        return view('user.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for editing a review.
     */
    public function edit(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            abort(403);
        }

        $review->load('foodspot');

        return view('user.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('user.reviews.index')->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('user.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
