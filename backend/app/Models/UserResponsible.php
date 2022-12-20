<?php

namespace App\Models;

use App\Models\Scopes\UserResponsibleScope;

class UserResponsible extends User
{
    protected static function booted()
    {
        static::addGlobalScope(new UserResponsibleScope);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'responsible_id', 'id');
    }
}
