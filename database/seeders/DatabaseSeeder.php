<?php

namespace Database\Seeders;

use App\Models\CleaningTask;
use App\Models\Housekeeper;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cleantrack.com'],
            ['name' => 'Admin User', 'role' => 'admin', 'password' => Hash::make('password')]
        );

        User::updateOrCreate(
            ['email' => 'staff@cleantrack.com'],
            ['name' => 'Staff User', 'role' => 'staff', 'password' => Hash::make('password')]
        );

        $rooms = collect([
            ['number' => '101', 'type' => 'Standard', 'floor' => '1', 'status' => 'clean'],
            ['number' => '102', 'type' => 'Deluxe', 'floor' => '1', 'status' => 'dirty'],
            ['number' => '201', 'type' => 'Suite', 'floor' => '2', 'status' => 'inspection'],
            ['number' => '202', 'type' => 'Standard', 'floor' => '2', 'status' => 'clean'],
        ])->map(fn (array $room) => Room::updateOrCreate(['number' => $room['number']], $room));

        $staff = collect([
            ['name' => 'Maria Santos', 'phone' => '0917-555-1001', 'shift' => 'Morning', 'is_active' => true],
            ['name' => 'Joel Ramirez', 'phone' => '0917-555-1002', 'shift' => 'Afternoon', 'is_active' => true],
            ['name' => 'Anne Cruz', 'phone' => '0917-555-1003', 'shift' => 'Night', 'is_active' => true],
        ])->map(fn (array $member) => Housekeeper::updateOrCreate(['name' => $member['name']], $member));

        CleaningTask::updateOrCreate([
            'title' => 'Turnover clean',
            'scheduled_for' => now()->toDateString(),
        ], [
            'room_id' => $rooms[1]->id,
            'housekeeper_id' => $staff[0]->id,
            'title' => 'Turnover clean',
            'description' => 'Guest checked out. Change linens and sanitize bathroom.',
            'priority' => 'high',
            'status' => 'pending',
            'scheduled_for' => now()->toDateString(),
        ]);

        CleaningTask::updateOrCreate([
            'title' => 'Deep clean suite',
            'scheduled_for' => now()->toDateString(),
        ], [
            'room_id' => $rooms[2]->id,
            'housekeeper_id' => $staff[1]->id,
            'title' => 'Deep clean suite',
            'description' => 'Polish fixtures and clean balcony area.',
            'priority' => 'medium',
            'status' => 'in_progress',
            'scheduled_for' => now()->toDateString(),
        ]);

        CleaningTask::updateOrCreate([
            'title' => 'Final inspection',
            'scheduled_for' => now()->subDay()->toDateString(),
        ], [
            'room_id' => $rooms[0]->id,
            'housekeeper_id' => $staff[2]->id,
            'title' => 'Final inspection',
            'description' => 'Verify amenities and minibar count.',
            'priority' => 'low',
            'status' => 'done',
            'scheduled_for' => now()->subDay()->toDateString(),
            'completed_at' => now()->subHours(6),
        ]);
    }
}
