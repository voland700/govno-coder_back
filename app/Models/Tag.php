<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Tag extends Model
{
    use HasSlug;
    protected $table = 'tags';
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

    public function getQuantityAttribute()
    {
        return $this->posts->count();
    }

}
