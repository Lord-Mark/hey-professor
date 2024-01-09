<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model, Prunable, SoftDeletes};

/**
 * @property string $question
 * @property bool $draft
 * @property integer $id
 * @property mixed $deleted_at
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    protected $casts = [
        'draft' => 'boolean',
    ];

    public function prunable(): Builder
    {
        return static::query()->where('deleted_at', '<=', now()->subMonth());
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function likes(): Attribute
    {
        /** @var Vote $votes */
        $votes      = $this->votes()->get();
        $totalLikes = $votes->sum('like');

        return new Attribute(get: fn () => $totalLikes);
    }

    public function dislikes(): Attribute
    {
        /** @var Vote $votes */
        $votes = $this->votes();

        return new Attribute(get: fn () => $votes->sum('dislike'));
    }
}
