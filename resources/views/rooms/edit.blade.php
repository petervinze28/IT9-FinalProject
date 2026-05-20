@extends('layouts.app', ['title' => 'Edit Room'])

@section('content')
<section class="section-head">
    <h2>Edit Room {{ $room->number }}</h2>
    <a class="btn-ghost" href="{{ route('rooms.index') }}">Back</a>
</section>

<section class="form-card">
    <form method="POST" action="{{ route('rooms.update', $room) }}" class="grid-form">
        @csrf
        @method('PUT')
        <input type="text" name="number" value="{{ old('number', $room->number) }}" required>
        <input type="text" name="type" value="{{ old('type', $room->type) }}" required>
        <input type="text" name="floor" value="{{ old('floor', $room->floor) }}" required>
        <select name="status" required>
            <option value="clean" @selected(old('status', $room->status) === 'clean')>Clean</option>
            <option value="dirty" @selected(old('status', $room->status) === 'dirty')>Dirty</option>
            <option value="inspection" @selected(old('status', $room->status) === 'inspection')>Inspection</option>
        </select>
        <textarea name="notes" rows="3" placeholder="Notes">{{ old('notes', $room->notes) }}</textarea>
        <button type="submit" class="btn-primary">Update Room</button>
    </form>
</section>
@endsection
