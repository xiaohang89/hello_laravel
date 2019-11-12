<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
// 添加邮箱验证
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;


class User extends Authenticatable implements MustVerifyEmailContract
{

    // 权限调用此函数
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    use Notifiable, MustVerifyEmailTrait;

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
}
