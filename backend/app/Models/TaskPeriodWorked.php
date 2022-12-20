<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class TaskPeriodWorked extends Model
{
    use HasFactory, HasUuid, Filterable, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'task_id',
        'terminated_at',
    ];

    protected $hidden = [
        'id'
    ];

}
