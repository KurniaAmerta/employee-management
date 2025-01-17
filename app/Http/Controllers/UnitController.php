<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $units = Unit::all()->map(function ($unit) {
            $unit->created_at_formatted = $unit->created_at->format('F j, Y');
            return $unit;
        });
        return Inertia::render('Unit/Index', [ 'units' => $units ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Unit/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the name input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new Unit instance
        $unit = Unit::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Password updated successfully!');
    
        return redirect()->route('unit.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);
        return Inertia::render('Unit/Edit', [ 'unit' => $unit ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Unit updated successfully!');
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        session()->flash('success', 'Unit deleted successfully!');
        return redirect()->route('unit.index');
    }
}
