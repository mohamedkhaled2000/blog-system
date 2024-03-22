<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use SoftDeletes;

    protected $translatable = ['title', 'content'];

    protected $with = ['user', 'media', 'comments'];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('post_image');
    }

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIsOwnerAttribute()
    {
        return auth()->check() && auth()->id() == $this->user_id;
    }

    public static function boot() {
        parent::boot();

        self::deleting(function ($post) {
            $post->comments()->delete();
        });
    }
}
