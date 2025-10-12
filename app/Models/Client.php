<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
