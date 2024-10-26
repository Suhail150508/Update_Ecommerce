<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'properties'];

    // If you want to log additional data as JSON, cast the 'properties' field to an array
    protected $casts = [
        'properties' => 'array',
    ];

    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a polymorphic relationship for the subject (Task, Product, etc.)
    public function subject()
    {
        return $this->morphTo();
    }
}

