<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Foodspot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodspotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodspots = Auth::user()->foodspots()->latest()->paginate(10);

        return view('owner.foodspots.index', compact('foodspots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.foodspots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'category_tag' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tagline' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ]);

        $data['user_id'] = Auth::id();

        Foodspot::create($data);

        return redirect()->route('owner.foodspots.index')->with('success', 'Foodspot created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Foodspot $foodspot)
    {
        if ($foodspot->user_id !== Auth::id()) {
            abort(403);
        }

        return view('owner.foodspots.show', compact('foodspot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foodspot $foodspot)
    {
        if ($foodspot->user_id !== Auth::id()) {
            abort(403);
        }

        return view('owner.foodspots.edit', compact('foodspot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foodspot $foodspot)
    {
        if ($foodspot->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'category_tag' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tagline' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ]);

        $foodspot->update($data);

        return redirect()->route('owner.foodspots.index')->with('success', 'Foodspot updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foodspot $foodspot)
    {
        if ($foodspot->user_id !== Auth::id()) {
            abort(403);
        }

        $foodspot->delete();

        return redirect()->route('owner.foodspots.index')->with('success', 'Foodspot deleted.');
    }
}
