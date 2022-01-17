<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    /**
     * The roles that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }
}
