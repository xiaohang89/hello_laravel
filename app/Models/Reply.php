<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    // 关联关系 一条回复只属于一篇文章
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // 关联关系 一条回复只属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
