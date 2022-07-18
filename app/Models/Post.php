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

    public function getPostDate()
    {
        //return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->translatedFormat('j F Y');

        return  \Carbon\Carbon::parse($this->created_at)->translatedFormat('j F Y');
    }


    public function getTitleAttribute()
    {
        return (!$this->meta_title==NULL) ? $this->meta_title : $this->name.' - статя, обзор, рекомендация о програмирование';
    }
    public function getKeysAttribute()
    {
        return (!$this->meta_keywords==NULL) ? $this->meta_keywords : 'php, js, javascript, html, обзор, статья, програмирование, laravel';
    }
    public function getDescripAttribute()
    {
        return (!$this->meta_description==NULL) ? $this->meta_description : $this->name.'  - интересная и полезная информация. '.$this->name.' рекомендации и по шаговое руководство';
    }
    public function getNamedAttribute()
    {
        return (!$this->h1==NULL) ? $this->h1 : $this->name;
    }


    public function scopeLike($query, $s)
    {

        $s= iconv_substr($s, 0, 64);
        $s = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $s);
        $s = preg_replace('#\s+#u', ' ', $s);
        $s = trim($s);

        if (empty($s)) {
            return $query->whereNull('id'); // возвращаем пустой результат
        }
        $temp = explode(' ', $s);
        $words = [];
        $stemmer = new \App\Http\Helpers\LinguaStemRu;
        foreach ($temp as $item) {
            if (iconv_strlen($item) > 3) {
                $words[] = $stemmer->stem_word($item);
            } else {
                $words[] = $item;
            }
        }
        $relevance = "IF (`posts`.`name` LIKE '%" . $words[0] . "%', 2, 0)";
        for ($i = 1; $i < count($words); $i++) {
            $relevance .= " + IF (`posts`.`name` LIKE '%" . $words[$i] . "%', 2, 0)";
        }
        $query->select('posts.*', \DB::raw($relevance . ' as relevance'))
            ->where('posts.name', 'like', '%' . $words[0] . '%');
        for ($i = 1; $i < count($words); $i++) {
            $query = $query->orWhere('posts.name', 'like', '%' . $words[$i] . '%');
        }
        $query->orderBy('relevance', 'desc');
        return $query;
    }


}
