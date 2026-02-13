<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{


    protected $fillable = [
        'name',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    protected $attributes = [
        'permissions' => '[]'
    ];

    /**
     * Relations
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Methods
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions);
    }

}
