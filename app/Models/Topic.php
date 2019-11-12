<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];
    // 关联关系 一对一  个话题属于一个分类
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // 关联关系 一对一  一个话题属于一个作者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 不同的排序，使用不同的数据读取逻  利用本地作用域，前面加scope
     public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
    // link 在WEB路由文件中生效会调用此类
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    // 关联关系 一对多  一个话题对应多个回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
