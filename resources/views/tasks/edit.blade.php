@extends('layouts.app', ['title' => 'Edit Task'])

@section('content')
<section class="section-head">
    <h2>Edit Task</h2>
    <a class="btn-ghost" href="{{ route('tasks.index') }}">Back</a>
</section>

<section class="form-card">
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="grid-form">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
        <textarea name="description" rows="3" placeholder="Description">{{ old('description', $task->description) }}</textarea>

        <select name="room_id" required>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" @selected((int) old('room_id', $task->room_id) === $room->id)>Room {{ $room->number }} ({{ $room->type }})</option>
            @endforeach
        </select>

        <select name="housekeeper_id">
            <option value="">Unassigned</option>
            @foreach($housekeepers as $housekeeper)
                <option value="{{ $housekeeper->id }}" @selected((int) old('housekeeper_id', $task->housekeeper_id) === $housekeeper->id)>{{ $housekeeper->name }}</option>
            @endforeach
        </select>

        <select name="priority" required>
            <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
            <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
            <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
        </select>

        <select name="status" required>
            <option value="pending" @selected(old('status', $task->status) === 'pending')>Pending</option>
            <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In Progress</option>
            <option value="done" @selected(old('status', $task->status) === 'done')>Done</option>
        </select>

        <input type="date" name="scheduled_for" value="{{ old('scheduled_for', $task->scheduled_for->toDateString()) }}" required>
        <button type="submit" class="btn-primary">Update Task</button>
    </form>
</section>
@endsection
