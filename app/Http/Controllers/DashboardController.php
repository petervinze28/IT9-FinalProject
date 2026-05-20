<?php

namespace App\Http\Controllers;

use App\Models\CleaningTask;
use App\Models\Housekeeper;
use App\Models\Room;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (! $this->housekeepingTablesReady()) {
            return view('dashboard', [
                'stats' => [
                    'rooms' => 0,
                    'housekeepers' => 0,
                    'tasksToday' => 0,
                    'pendingTasks' => 0,
                    'inProgressTasks' => 0,
                    'completedToday' => 0,
                    'overdueTasks' => 0,
                    'completionRate' => 0,
                ],
                'recentTasks' => collect(),
            ]);
        }

        $today = now()->toDateString();

        $tasksToday = CleaningTask::whereDate('scheduled_for', $today)->count();
        $pendingTasks = CleaningTask::where('status', 'pending')->count();
        $inProgressTasks = CleaningTask::where('status', 'in_progress')->count();
        $completedToday = CleaningTask::whereDate('completed_at', $today)->count();
        $overdueTasks = CleaningTask::where('status', '!=', 'done')
            ->whereDate('scheduled_for', '<', $today)
            ->count();

        $allTasks = CleaningTask::count();
        $doneTasks = CleaningTask::where('status', 'done')->count();
        $completionRate = $allTasks > 0 ? (int) round(($doneTasks / $allTasks) * 100) : 0;

        $recentTasks = CleaningTask::with(['room', 'housekeeper'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard', [
            'stats' => [
                'rooms' => Room::count(),
                'housekeepers' => Housekeeper::where('is_active', true)->count(),
                'tasksToday' => $tasksToday,
                'pendingTasks' => $pendingTasks,
                'inProgressTasks' => $inProgressTasks,
                'completedToday' => $completedToday,
                'overdueTasks' => $overdueTasks,
                'completionRate' => $completionRate,
            ],
            'recentTasks' => $recentTasks,
        ]);
    }

    private function housekeepingTablesReady(): bool
    {
        return Schema::hasTable('rooms')
            && Schema::hasTable('housekeepers')
            && Schema::hasTable('cleaning_tasks');
    }
}
