<?php

namespace App\Http\Controllers\PublicSite;

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
        return view('public.foodspots.show', compact('foodspot'));
    }
}
