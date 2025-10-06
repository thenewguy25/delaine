<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    /**
     * Get the users that have this permission.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')
            ->where('model_type', User::class);
    }

    /**
     * Scope a query to only include active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('name', '!=', 'deleted');
    }

    /**
     * Check if the permission is a user management permission.
     */
    public function isUserManagement(): bool
    {
        return str_contains($this->name, 'manage users');
    }

    /**
     * Get the display name for the permission.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->name));
    }
}
