<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Post extends Model
{
    use HasSlug;
    protected $table = 'posts';
    protected $fillable = [
        'name',
        'slug',
        'active',
        'img',
        'preview',
        'summary',
        'description',
        'title',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'author',
        'link',
        'translator'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }




}
