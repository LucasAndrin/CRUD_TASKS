<?php

namespace App\Models;

use App\Models\Scopes\UserAdminScope;

class UserAdmin extends User
{
    protected static function booted()
    {
        static::addGlobalScope(new UserAdminScope);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'created_by', 'id');
    }
}
