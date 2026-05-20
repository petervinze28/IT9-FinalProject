<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Housekeeper extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'shift',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cleaningTasks(): HasMany
    {
        return $this->hasMany(CleaningTask::class);
    }
}
