@extends('layouts.app', ['title' => 'Rooms | CleanTrack'])

@section('content')
<section class="section-head">
    <h2>Rooms</h2>
</section>

@if($isAdmin)
    <section class="form-card">
        <h3>Add Room</h3>
        <form method="POST" action="{{ route('rooms.store') }}" class="grid-form">
            @csrf
            <input type="text" name="number" placeholder="Room Number" value="{{ old('number') }}" required>
            <input type="text" name="type" placeholder="Type (Standard, Deluxe...)" value="{{ old('type') }}" required>
            <input type="text" name="floor" placeholder="Floor" value="{{ old('floor') }}" required>
            <select name="status" required>
                <option value="clean">Clean</option>
                <option value="dirty">Dirty</option>
                <option value="inspection">Inspection</option>
            </select>
            <textarea name="notes" rows="2" placeholder="Notes">{{ old('notes') }}</textarea>
            <button type="submit" class="btn-primary">Save Room</button>
        </form>
    </section>
@endif

<section class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Number</th>
                <th>Type</th>
                <th>Floor</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td data-label="Number">{{ $room->number }}</td>
                    <td data-label="Type">{{ $room->type }}</td>
                    <td data-label="Floor">{{ $room->floor }}</td>
                    <td data-label="Status">
                        <form method="POST" action="{{ route('rooms.update-status', $room) }}" class="status-inline-form">
                            @csrf
                            <select name="status" onchange="this.form.submit()">
                                <option value="clean" @selected($room->status === 'clean')>Clean</option>
                                <option value="dirty" @selected($room->status === 'dirty')>Dirty</option>
                                <option value="inspection" @selected($room->status === 'inspection')>Inspection</option>
                            </select>
                        </form>
                    </td>
                    <td class="actions" data-label="Actions">
                        @if($isAdmin)
                            <a class="btn-ghost" href="{{ route('rooms.edit', $room) }}">Edit</a>
                            <form method="POST" action="{{ route('rooms.destroy', $room) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger" type="submit">Delete</button>
                            </form>
                        @else
                            <span class="pill done">Status only</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No rooms yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $rooms->links('pagination.custom') }}
</section>
@endsection
