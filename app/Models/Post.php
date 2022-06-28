<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;


class Post extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'posts';
    protected $fillable = [
        'name',
        'slug',
        'active',
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('main')
            ->withResponsiveImages();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //Accessors
    public function getShortAttribute()
    {
        if(!$this->summary==NULL){
            return Str::of(strip_tags($this->summary))->limit(160);
        }else{
            return Str::of(strip_tags($this->description))->limit(160);
        }
    }




}
