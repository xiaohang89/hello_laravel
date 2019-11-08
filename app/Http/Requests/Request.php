<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function authorize()
    {
    	// Using policy for Authorization
    	// 所有权限都能通过
        return true;
    }
}
