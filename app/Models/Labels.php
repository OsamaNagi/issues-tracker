<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Labels extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'issue_labels', 'label_id', 'issue_id');
    }
}
