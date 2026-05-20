@extends('layouts.app', ['title' => 'Edit Housekeeper'])

@section('content')
<section class="section-head">
    <h2>Edit {{ $housekeeper->name }}</h2>
    <a class="btn-ghost" href="{{ route('housekeepers.index') }}">Back</a>
</section>

<section class="form-card">
    <form method="POST" action="{{ route('housekeepers.update', $housekeeper) }}" class="grid-form">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ old('name', $housekeeper->name) }}" required>
        <input type="text" name="phone" value="{{ old('phone', $housekeeper->phone) }}">
        <select name="shift" required>
            <option value="Morning" @selected(old('shift', $housekeeper->shift) === 'Morning')>Morning</option>
            <option value="Afternoon" @selected(old('shift', $housekeeper->shift) === 'Afternoon')>Afternoon</option>
            <option value="Night" @selected(old('shift', $housekeeper->shift) === 'Night')>Night</option>
        </select>
        <label class="switch-row">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $housekeeper->is_active))>
            <span>Active</span>
        </label>
        <button type="submit" class="btn-primary">Update Staff</button>
    </form>
</section>
@endsection
