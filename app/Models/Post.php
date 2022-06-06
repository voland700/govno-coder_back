<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Post extends Model implements HasMedia
{
    use HasSlug, HasMediaTrait;
    protected $table = 'posts';
    protected $fillable = [
        'name',
        'slug',
        'active',
        'summary',
        'description',
        'title',
        'subtitle',
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
