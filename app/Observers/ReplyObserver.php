<?php

namespace App\Observers;

use App\Models\Reply;
// 数据库通知类
use App\Notifications\TopicReplied;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
   
   // 过滤掉XSS  调用clean方法  user_topic_body这个是过滤方法
    public function creating(Reply $reply)
    {   
        // 创建数据是清洗数据
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    // 创建之前 需要为回复数据+1
    public function created(Reply $reply)
    {
         //$reply->topic->increment('reply_count', 1);
        // 留言总数加1

    	// 第二种方法
        // $reply->topic->reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
        // 第三种写抽象写法 已经抽离在 reply Models中
        $reply->topic->updateReplyCount();
        // 通知话题作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    // 删除之前 需要为回复数据-1
    public function deleted(Reply $reply)
    {
        // $reply->topic->updateReplyCount();
        if ($reply->topic->reply_count > 0) {
            $reply->topic->decrement('reply_count', 1);
        }
    }
}