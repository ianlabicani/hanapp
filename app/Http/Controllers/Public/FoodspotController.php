<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Foodspot;

class FoodspotController extends Controller
{
    /**
     * Display a listing of public foodspots.
     */
    public function index()
    {
        $foodspots = Foodspot::latest()->paginate(12);

        return view('public.foodspots.index', compact('foodspots'));
    }

    /**
     * Display a single foodspot.
     */
    public function show(Foodspot $foodspot)
    {
        // Don't count visits from admins, and don't count from owners who own this foodspot
        try {
            $user = request()->user();
            if ($user) {
                if ($user->hasRole('admin')) {
                    return view('public.foodspots.show', compact('foodspot'));
                }

                if ($user->hasRole('owner') && $user->id === $foodspot->user_id) {
                    return view('public.foodspots.show', compact('foodspot'));
                }
            }

            // Deduplicate visits per day using session keys.
            $key = 'foodspot_viewed_'.$foodspot->id;
            $today = date('Y-m-d');
            $last = session($key);

            if ($last !== $today) {
                $foodspot->increment('visits');
                session([$key => $today]);
                $foodspot->refresh();
            }
        } catch (\Throwable $e) {
            // ignore errors; render page regardless
        }

        return view('public.foodspots.show', compact('foodspot'));
    }
}
