<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
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
