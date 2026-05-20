@extends('layouts.app', ['title' => 'Cleaning Tasks'])

@section('content')
<section class="section-head">
    <h2>Cleaning Tasks</h2>
</section>

<section class="form-card">
    <h3>Create Task</h3>
    <form method="POST" action="{{ route('tasks.store') }}" class="grid-form">
        @csrf
        <input type="text" name="title" placeholder="Task title" value="{{ old('title') }}" required>
        <textarea name="description" rows="2" placeholder="Description">{{ old('description') }}</textarea>

        <select name="room_id" required>
            <option value="">Select room</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" @selected((int) old('room_id') === $room->id)>Room {{ $room->number }} ({{ $room->type }})</option>
            @endforeach
        </select>

        <select name="housekeeper_id">
            <option value="">Unassigned</option>
            @foreach($housekeepers as $housekeeper)
                <option value="{{ $housekeeper->id }}" @selected((int) old('housekeeper_id') === $housekeeper->id)>{{ $housekeeper->name }}</option>
            @endforeach
        </select>

        <select name="priority" required>
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
        </select>

        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
        </select>

        <input type="date" name="scheduled_for" value="{{ old('scheduled_for', now()->toDateString()) }}" required>
        <button type="submit" class="btn-primary">Save Task</button>
    </form>
</section>

<section class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Task</th>
                <th>Room</th>
                <th>Assigned</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td data-label="Task">{{ $task->title }}</td>
                    <td data-label="Room">{{ $task->room?->number ?? '-' }}</td>
                    <td data-label="Assigned">{{ $task->housekeeper?->name ?? 'Unassigned' }}</td>
                    <td data-label="Priority"><span class="pill {{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                    <td data-label="Status"><span class="pill {{ $task->status }}">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span></td>
                    <td data-label="Due">{{ $task->scheduled_for->format('M d, Y') }}</td>
                    <td class="actions" data-label="Actions">
                        <a class="btn-ghost" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No tasks yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $tasks->links('pagination.custom') }}
</section>
@endsection
