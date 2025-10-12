<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Define role names as constants for easy reference
    // Don't yet know if I'll use this :v
    public const ADMIN = 'admin';
    public const COMMERCIAL = 'commercial';

    protected $fillable = [
        'name',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scopes
    /**
     * Convenience scope to find a role by name.
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }
}
