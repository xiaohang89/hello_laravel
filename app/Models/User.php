<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
// 添加邮箱验证
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
// auth
use Auth;
// 权限和角色方法
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmailContract
{

    // 权限和角色方法
    use HasRoles;
    //计算活跃用户
    use Traits\ActiveUserHelper;
    // 记录最后用户登录时间
    use Traits\LastActivedAtHelper;
    
    // 权限调用此函数
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 通知类
    use  MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    // 返回通知类的实例
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 用户与话题中间的关系是 一对多 的关系
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 关联关系 一对多 的关系 一个作者可以拥有多个回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 首页标记已读清理未读
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    // 从写password字段  修改器
     public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    // 头像处理   修改器
     public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}
