<?php

namespace App\Observers;

use App\Models\Topic;
// 百度翻译 SEO
use App\Handlers\SlugTranslateHandler;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored
 	// Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。每种方法接收 model 作为其唯一的参数。代码生成器已经为我们生成了一个观察器文件，并在 AppServiceProvider 中注册。接下来我们要定制此观察器，在 Topic 模型保存时触发的 saving 事件中，对 excerpt 字段进行赋值：
    public function saving(Topic $topic)
    {
        // xss过滤  过滤选项user_topic_body
        $topic->body = clean($topic->body, 'user_topic_body');
        // 自动填充简介、话题摘要
        $topic->excerpt = make_excerpt($topic->body);
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }

    }
}