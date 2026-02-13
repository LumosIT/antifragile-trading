<?php

namespace App\Models;

use App\Utilits\Traits\HasTwoFactoryCode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasTwoFactoryCode, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'tfa_secret',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'tfa_secret'
    ];

    protected $attributes =[
    ];

    protected $casts = [
        'tfa_secret' => 'encrypted'
    ];

    protected $appends = [
        'tfa_enabled'
    ];

    /**
     * Relations
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Methods
     */
    public function hasPermission(string $permission) : bool
    {
        return $this->role->hasPermission($permission);
    }

    /**
     * Static methods
     */
    static public function findByLogin(string $login) : ?self
    {
        return self::where('login', $login)->first();
    }



}
