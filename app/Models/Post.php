<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;



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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')
            ->singleFile()
            ->registerMediaConversions(
                function () {
                    $this
                        ->addMediaConversion('full')
                        ->fit(Manipulations::FIT_CONTAIN, 1080, 600);
                    $this
                        ->addMediaConversion('middle')
                        ->fit(Manipulations::FIT_CONTAIN, 630, 350);
                    $this
                        ->addMediaConversion('small')
                        ->fit(Manipulations::FIT_CONTAIN, 435, 242);
                    $this
                        ->addMediaConversion('tiny')
                        ->fit(Manipulations::FIT_CONTAIN, 356, 198);
                }
            );
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

    public function getPreviewAttribute(){
        $media =  $this->getFirstMedia('main');
        $priew = [];
        if( $this->getMedia('main')->isNotEmpty()){
            $priew['full'] =  $media->hasGeneratedConversion('full') ?  $media->getUrl('full') : asset('images/src/no-photo/full.jpg');
            $priew['middle'] =  $media->hasGeneratedConversion('middle') ?  $media->getUrl('middle') : asset('images/src/no-photo/middle.jpg');
            $priew['small'] =  $media->hasGeneratedConversion('small') ?  $media->getUrl('small') : asset('images/src/no-photo/small.jpeg');
            $priew['tiny'] =  $media->hasGeneratedConversion('tiny') ?  $media->getUrl('tiny') : asset('images/src/no-photo/tiny.jpeg');
        } else {
            $priew['full'] = asset('images/src/no-photo/full.jpg');
            $priew['middle'] = asset('images/src/no-photo/middle.jpg');
            $priew['small'] = asset('images/src/no-photo/small.jpg');
            $priew['tiny'] = asset('images/src/no-photo/tiny.jpg');
        }
        return $priew;

    }




}
