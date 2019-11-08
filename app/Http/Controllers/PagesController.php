<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class PagesController extends Controller
{
    public function root(User $user)
    {
    	
        return view('pages.root',compact('user'));
    }
}
