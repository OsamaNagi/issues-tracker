<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes; // Optional, if using soft deletes

    protected $fillable = ['issue_id', 'user_id', 'content'];

    // Relation to Issue
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    // Relation to Author (User)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

