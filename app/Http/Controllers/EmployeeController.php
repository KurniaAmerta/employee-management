<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Employee;
use App\Models\Unit;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $employees = Employee::with('unit', 'jabatans')->get()->map(function ($employee) {
            $employee->created_at_formatted = $employee->created_at->format('F j, Y');
            return $employee;
        });
        return Inertia::render('Employee/Index', [ 'employees' => $employees ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return Inertia::render('Employee/Create', [
            'units' => $units,
            'jabatans' => $jabatans,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jabatans = array_filter($request->jabatans, function($jabatan) {
            return !empty($jabatan);
        });

        $request->merge(['jabatans' => $jabatans]);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:employees,username|max:255',
            'dateJoined' => 'nullable|date',
            'password' => 'required|string|min:8|confirmed',
            'unit_id' => 'nullable|exists:units,id',
            'jabatans' => 'nullable|array|max:2',
            'jabatans.*' => 'exists:jabatans,id',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'dateJoined' => $request->dateJoined ?? now(),
            'unit_id' => $request->unit_id,
        ]);

        if (!empty($jabatans)) {
            $employee->jabatans()->attach($jabatans);
        }

        session()->flash('success', 'Employee created successfully!');
        return redirect()->route('employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with('unit', 'jabatans')->findOrFail($id);
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return Inertia::render('Employee/Edit', [
            'employee' => $employee,
            'units' => $units,
            'jabatans' => $jabatans,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jabatans = array_filter($request->jabatans, function($jabatan) {
            return !empty($jabatan);
        });

        $request->merge(['jabatans' => $jabatans]);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:employees,username,' . $id,
            'dateJoined' => 'nullable|date',
            'password' => 'nullable|string|min:8|confirmed',
            'unit_id' => 'nullable|exists:units,id',
            'jabatans' => 'nullable|array|max:2',
            'jabatans.*' => 'exists:jabatans,id',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update([
            'name' => $request->name,
            'username' => $request->username,
            'dateJoined' => $request->dateJoined ?? $employee->dateJoined,
            'unit_id' => $request->unit_id,
            'password' => $request->password ? bcrypt($request->password) : $employee->password,
        ]);

        if (!empty($jabatans)) {
            $employee->jabatans()->sync($jabatans);
        }

        session()->flash('success', 'Employee updated successfully!');
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        session()->flash('success', 'Employee deleted successfully!');
        return redirect()->route('employee.index');
    }
}
