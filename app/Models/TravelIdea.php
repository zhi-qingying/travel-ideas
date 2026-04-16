<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelIdea extends Model
{
    // 允许批量赋值的字段（防白屏报错）
    protected $fillable = ['title', 'destination', 'start_date', 'end_date', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function tags()
    {
        // 第二个参数严格指定我们在数据库中创建的中间表名称 'idea_tag'
        return $this->belongsToMany(Tag::class, 'idea_tag');
    }
}
