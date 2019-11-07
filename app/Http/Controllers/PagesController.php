<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class PagesController extends Controller
{
    public function root(User $user)
    {
    	// 这里有问题获取不到图片
        return view('pages.root',compact('user'));
    }
}
