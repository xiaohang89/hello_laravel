<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
// 我们的分类话题列表页使用侧边栏，我们需要在分类控制器中将『活跃用户』数据传入模板中：
use App\Models\User;
// 引入推荐列表
use App\Models\Link;
class CategoriesController extends Controller
{
	
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        // $topics = Topic::where('category_id', $category->id)->paginate(20);
        
        // 读取分类 ID 关联的话题，并按每 20 条分页 
        // 排序
        $topics = $topic->withOrder($request->order)
        // 然后按照ID去找
                        ->where('category_id', $category->id)
                        ->with('user', 'category')   // 预加载防止 N+1 问题
                        ->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 资源链接
        $links = $link->getAllCached();

        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category','active_users', 'links'));
    }
}
