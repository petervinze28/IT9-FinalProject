@extends('layouts.app', ['title' => 'Dashboard | CleanTrack'])

@section('content')
<section class="hero">
    <div>
        <!-- <p class="hero-kicker">Daily Operations</p> -->
        <h2>CleanTrack Command Dashboard</h2>
        <!-- <p>Live overview of workload, completion, and team performance.</p> -->
    </div>
</section>

<section class="stats-grid">
    <article class="card">
        <h3>Total Rooms</h3>
        <p class="metric value-right">{{ $stats['rooms'] }}</p>
    </article>
    <article class="card">
        <h3>Active Staff</h3>
        <p class="metric value-right">{{ $stats['housekeepers'] }}</p>
    </article>
    <article class="card">
        <h3>Tasks Today</h3>
        <p class="metric value-right">{{ $stats['tasksToday'] }}</p>
    </article>
    <article class="card">
        <h3>Completion Rate</h3>
        <p class="metric value-right">{{ $stats['completionRate'] }}%</p>
    </article>
</section>

<section class="stats-grid compact">
    <article class="card soft">
        <h3>Pending</h3>
        <p class="metric value-right">{{ $stats['pendingTasks'] }}</p>
    </article>
    <article class="card soft">
        <h3>In Progress</h3>
        <p class="metric value-right">{{ $stats['inProgressTasks'] }}</p>
    </article>
    <article class="card soft">
        <h3>Completed Today</h3>
        <p class="metric value-right">{{ $stats['completedToday'] }}</p>
    </article>
    <article class="card warning">
        <h3>Overdue</h3>
        <p class="metric value-right">{{ $stats['overdueTasks'] }}</p>
    </article>
</section>

<section class="table-card">
    <div class="section-head">
        <h3>Recent Tasks</h3>
        <a href="{{ route('tasks.index') }}">View all</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Task</th>
                <th>Room</th>
                <th>Assigned To</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($recentTasks as $task)
                <tr>
                    <td data-label="Task">{{ $task->title }}</td>
                    <td data-label="Room">{{ $task->room?->number ?? '-' }}</td>
                    <td data-label="Assigned To">{{ $task->housekeeper?->name ?? 'Unassigned' }}</td>
                    <td data-label="Priority"><span class="pill {{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                    <td data-label="Status"><span class="pill {{ $task->status }}">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span></td>
                    <td data-label="Date">{{ $task->scheduled_for->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No tasks available yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
