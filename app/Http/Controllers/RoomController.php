<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::latest()->paginate(12);

        return view('rooms.index', [
            'rooms' => $rooms,
            'isAdmin' => request()->user()?->isAdmin() ?? false,
        ]);
    }

    public function create()
    {
        return redirect()->route('rooms.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:50', 'unique:rooms,number'],
            'type' => ['required', 'string', 'max:100'],
            'floor' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['clean', 'dirty', 'inspection'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }

    public function show(string $id)
    {
        return redirect()->route('rooms.index');
    }

    public function edit(Room $room): View
    {
        return view('rooms.edit', [
            'room' => $room,
        ]);
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:50', Rule::unique('rooms', 'number')->ignore($room->id)],
            'type' => ['required', 'string', 'max:100'],
            'floor' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(['clean', 'dirty', 'inspection'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function updateStatus(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['clean', 'dirty', 'inspection'])],
        ]);

        $room->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room status updated successfully.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room removed.');
    }
}
