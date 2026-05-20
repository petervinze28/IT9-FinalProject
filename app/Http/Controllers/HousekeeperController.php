<?php

namespace App\Http\Controllers;

use App\Models\Housekeeper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HousekeeperController extends Controller
{
    public function index(): View
    {
        $housekeepers = Housekeeper::latest()->paginate(12);

        return view('housekeepers.index', [
            'housekeepers' => $housekeepers,
        ]);
    }

    public function create()
    {
        return redirect()->route('housekeepers.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'shift' => ['required', Rule::in(['Morning', 'Afternoon', 'Night'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Housekeeper::create($validated);

        return redirect()->route('housekeepers.index')->with('success', 'Staff member added successfully.');
    }

    public function show(string $id)
    {
        return redirect()->route('housekeepers.index');
    }

    public function edit(Housekeeper $housekeeper): View
    {
        return view('housekeepers.edit', [
            'housekeeper' => $housekeeper,
        ]);
    }

    public function update(Request $request, Housekeeper $housekeeper): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'shift' => ['required', Rule::in(['Morning', 'Afternoon', 'Night'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $housekeeper->update($validated);

        return redirect()->route('housekeepers.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Housekeeper $housekeeper): RedirectResponse
    {
        $housekeeper->delete();

        return redirect()->route('housekeepers.index')->with('success', 'Staff member removed.');
    }
}
