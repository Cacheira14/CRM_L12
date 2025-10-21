<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'visit_id',
        'content',
    ];

    // Relationships
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
