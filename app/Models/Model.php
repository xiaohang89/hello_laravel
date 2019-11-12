<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
	// 话题Id排序
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    // 话题排序 order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

}
