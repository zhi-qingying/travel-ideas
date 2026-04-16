<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];


    public function travelIdeas()
    {
        // 同样需要显式指定中间表名称
        return $this->belongsToMany(TravelIdea::class, 'idea_tag');
    }
}
