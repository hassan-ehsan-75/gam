<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkShop extends Model
{
    public function dayname(){
        return $this->belongsTo(EventDay::class,'days');
    }

    public static $types=[
        'work'=>'ورشة',
        'course'=>'دورة',
        'contest'=>'جلسة علمية',
        'contest-2'=>'جلسة ارشادية',
    ];

}
