<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
   
   // 过滤掉XSS  调用clean方法  user_topic_body这个是过滤方法
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    // 创建之前 需要为回复数据+1
    public function created(Reply $reply)
    {
         $reply->topic->increment('reply_count', 1);
    	//$reply->topic->reply_count = $reply->topic->replies->count();
        //$reply->topic->save();
    }
}