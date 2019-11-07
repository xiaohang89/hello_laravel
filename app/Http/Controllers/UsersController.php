<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 引用模型 
use App\Models\User;
class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
