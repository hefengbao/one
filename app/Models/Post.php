<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Auth;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['published_at'];

    protected $fillable = [
        'user_id',
        'post_title',
        'post_slug',
        'post_content',
        'post_content_filter',
        'category_id',
        'post_excerpt',
        'post_status',
        'comment_status',
        'post_type',
        'published_at'
    ];

    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'posts.post_title' => 5,
            'posts.post_content_filter' => 2,
        ],
    ];

    const postInfo = [
        'id',
        'user_id',
        'post_title',
        'category_id',
        'post_slug',
        'post_excerpt',
        'published_at',
        'created_at'
    ];


    /**
     * 文章与标签之间的多对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * 文章与类别的一对一关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 文章与用户的一对多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now())
            ->where('post_type', '=', 'post')
            ->where('post_status', '=', '1');
    }

    public function scopePage($query)
    {
        $query->where('post_type', '=', 'page');
    }

    public function scopePost($query)
    {
        $query->where('post_type', '=', 'post');
    }

    public function scopeCurrentUser($query)
    {
        $query->where('user_id', '=', Auth::id());
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = date_format(date_create($value . ' ' . Carbon::now()->toTimeString()), 'Y-m-d H:i:s');
    }

	/*public function setPostSlugAttribute($value)
	{
		$str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
		str_shuffle($str);
		$suffix=substr(str_shuffle($str),26,10);
		$this->attributes['post_slug'] = $value.'-'.$suffix;
	}*/
}
