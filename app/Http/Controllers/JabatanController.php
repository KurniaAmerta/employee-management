<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $jabatans = Jabatan::all()->map(function ($jabatan) {
            $jabatan->created_at_formatted = $jabatan->created_at->format('F j, Y'); // Example: "January 16, 2025"
            return $jabatan;
        });
        return Inertia::render('Jabatan/Index', [ 'jabatans' => $jabatans ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Jabatan/Create');
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

        // Create a new Jabatan instance
        $jabatan = Jabatan::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Password updated successfully!');
    
        return redirect()->route('jabatan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return Inertia::render('Jabatan/Edit', [ 'jabatan' => $jabatan ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Jabatan updated successfully!');
        return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        session()->flash('success', 'Jabatan deleted successfully!');
        return redirect()->route('jabatan.index');
    }
}
