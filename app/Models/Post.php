<?php

namespace App\Models;

use App\Constant\PostStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Vinkla\Hashids\Facades\Hashids;

class Post extends Model implements Feedable
{
    const selectField = [
        'id',
        'slug',
        'user_id',
        'title',
        'status',
        'commentable',
        'comment_count',
        'pinned_at',
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'status',
        'type',
        'commentable',
        'comment_count',
        'pinned_at',
        'published_at'
    ];

    protected $casts = [
        'pinned_at' => 'datetime',
        'published_at' => 'datetime'
    ];

    public function slugId(): Attribute
    {
        return Attribute::make(
            get: fn() => slug_id($this->slug, $this->id)
        );
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function meta(): HasMany
    {
        return $this->hasMany(Postmeta::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::Publish);
    }

    public function scopeArticle($query)
    {
        return $query->where('type', 'article');
    }

    public function scopePage($query)
    {
        return $query->where('type', 'page');
    }

    public function scopeTweet($query)
    {
        return $query->where('type', 'tweet');
    }

    public static function getFeedItems()
    {
        return Post::with(['author'])->article()->published()->orderBy('published_at', 'desc')->get();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => Hashids::connection('alternative')->encode($this->id),
            'title' => $this->title,
            'summary' => $this->excerpt ?? '',
            'updated' => $this->updated_at,
            'link' => \route('articles.show', $this->slug_id),
            'authorName' => $this->author ? $this->author->name : url('/'),
        ]);
    }
}
