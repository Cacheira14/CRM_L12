<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
    ];

    // Relationships
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
