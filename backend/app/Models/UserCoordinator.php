<?php

namespace App\Models;

use App\Models\Scopes\UserCoordinatorScope;

class UserCoordinator extends User
{
    protected static function booted()
    {
        static::addGlobalScope(new UserCoordinatorScope);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'created_by', 'id');
    }
}
