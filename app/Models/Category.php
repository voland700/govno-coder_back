<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'active',
        'title',
        'subtitle',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

}
