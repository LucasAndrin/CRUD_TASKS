<?php

namespace App\Models;

use App\Enums\UserType;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuid, Notifiable, Filterable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',
        'name',
        'email',
        'password',
        'type',
        'inactivated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'type' => UserType::class
    ];

    public function creator()
    {
        return $this->hasOne(UserAdmin::class, 'created_by', 'id');
    }
}
