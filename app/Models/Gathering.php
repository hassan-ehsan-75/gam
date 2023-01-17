<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gathering extends Model
{
    use HasFactory;
    protected $guarded=[];
    public static $g_type=[
        1=>'عادية',
        2=>'غير عادية',
        3=>'تأسيسية',
    ];

    public function records(){
        return $this->hasMany(Record::class,'gathering_id','id');
    }
}
