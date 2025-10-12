<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
