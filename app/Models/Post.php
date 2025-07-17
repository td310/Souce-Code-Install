<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\PostStatus;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([PostObserver::class])]
#[UsePolicy(PostPolicy::class)]
class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content', 
        'publish_date',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
    
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class
        ];
    }

    public function getThumbnailAttribute()
    {
        $media = $this->getFirstMedia('thumbnail');
        return $media ? $media->getUrl() : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')->singleFile();
    }
}
