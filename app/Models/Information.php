<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;


class Information extends Model
{
    use HasSlug;
    protected $table = 'information';
    protected $fillable = [
        'title',
        'slug',
        'active',
        'preview',
        'description',
        'image',
        'link'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getNewsDate()
    {
        return  \Carbon\Carbon::parse($this->created_at)->translatedFormat('j F Y');
    }

}
