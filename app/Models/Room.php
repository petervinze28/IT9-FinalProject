<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'number',
        'type',
        'floor',
        'status',
        'notes',
    ];

    public function cleaningTasks(): HasMany
    {
        return $this->hasMany(CleaningTask::class);
    }
}
