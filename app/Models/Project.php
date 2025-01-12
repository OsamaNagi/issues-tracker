<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @method static Builder private()
 * @method static Builder public()
 */
class Project extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'visibility',
    ];

    protected function scopePublic(Builder $query): Builder
    {
        $user = auth()->user();

        return $query->where('visibility', 'public')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('users', fn($query) => $query->where('user_id', $user->id));
            });
    }

    protected function scopePrivate(Builder $query): Builder
    {
        $user = auth()->user();

        return $query->where('visibility', 'private')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('users', fn($query) => $query->where('user_id', $user->id));
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'project_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
