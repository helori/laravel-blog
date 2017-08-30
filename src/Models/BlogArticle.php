<?php

namespace Helori\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;


class BlogArticle extends Model
{
	protected $table = 'blog_articles';
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
    protected $hidden = [];
    protected $guarded = [];

    public function categories(){
    	return $this->belongsToMany(BlogCategories::class);
    }
}
