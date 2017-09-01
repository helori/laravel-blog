<?php

namespace Helori\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Helori\LaravelMedias\Models\Media;
use Helori\LaravelMedias\Traits\HasMedia;


class BlogArticle extends Model
{
    use HasMedia;

	protected $table = 'blog_articles';
    protected $dates = ['created_at', 'updated_at', 'published_at'];
    public $timestamps = true;
    protected $hidden = [];
    protected $guarded = [];

    public function categories(){
    	return $this->belongsToMany(BlogCategory::class, 'blog_article_category');
    }

    public function image(){
    	return $this->morphToMany(Media::class, 'mediable')->wherePivot('collection', 'image');
    }

    public function images(){
    	return $this->morphToMany(Media::class, 'mediable')->wherePivot('collection', 'images');
    }
}
