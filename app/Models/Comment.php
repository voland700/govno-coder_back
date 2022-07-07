<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\NodeTrait;

use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

use Carbon\Carbon;

class Comment extends Model implements ReactableInterface
{
    use NodeTrait, Reactable;

    protected $table = 'comments';
    protected $fillable = [
        'parent_id',
        '_lft ',
        '_rgt ',
        'active',
        'user_id',
        'post_id',
        'massage'
    ];
    protected  $appends = [
        'user_reaction'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentDate()
    {
        $time =  Carbon::parse($this->created_at);
        return  $time->translatedFormat('j F Y').' в '.$time->hour.'.'.$time->minute;
    }

    public function getLikeCount()
    {
        return  $this->viaLoveReactant()->getReactionCounterOfType('Like')->getCount();
    }

    public function getDislikeCount()
    {
        return  $this->viaLoveReactant()->getReactionCounterOfType('Dislike')->getCount();
    }

    public function getUserReactionAttribute() {
        if(Auth::check()){
            $reacterFacade = Auth::user()->viaLoveReacter();
            if($reacterFacade->hasReactedTo($this)){
                if($reacterFacade->hasReactedTo($this, 'Like')) return 'like';
                if($reacterFacade->hasReactedTo($this, 'Dislike')) return 'dislike';
            }
        } else {
            return null;
        }
    }


}
