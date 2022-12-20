<?php

namespace App\Models;

use App\Enums\TaskStatus;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class Task extends Model
{
    use HasFactory, HasUuid, Filterable, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'responsible_id',
        'created_by',
        'description',
        'status',
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'status' => TaskStatus::class
    ];

    public function responsible()
    {
        return $this->hasOne(UserResponsible::class, 'responsible_id', 'id');
    }

    public function creator()
    {
        return $this->hasOne(UserAdmin::class, 'created_by', 'id');
    }
}
