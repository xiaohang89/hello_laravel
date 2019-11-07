<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 用户验证规则
use App\Http\Requests\UserRequest;
// 引用模型 
use App\Models\User;
//图片上传逻辑
use App\Handlers\ImageUploadHandler;
class UsersController extends Controller
{
    // 利用中间件方法，想要看编辑页面必须登录才可以 except 代表除了这个路由 以外的必须登录， only只有这个路由登录
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    // 用户展示页面
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    // 用户修改页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    // 用户逻辑页面
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
