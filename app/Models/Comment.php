<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'travel_idea_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 属于哪个旅游想法
    public function travelIdea()
    {
        return $this->belongsTo(TravelIdea::class);
    }
}
