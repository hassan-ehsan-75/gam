<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function gathering(){
        return $this->belongsTo(Gathering::class,'gathering_id','id');
    }

    public function answer(){
        return $this->hasMany(RecordAnswer::class,'record_id','id');
    }
    public function NoAnswer(){
        return $this->hasMany(RecordAnswer::class,'record_id','id')->where('answer','=',0);
    }
    public function YesAnswer(){
        return $this->hasMany(RecordAnswer::class,'record_id','id')->where('answer','=',1);
    }
    public function YesAnswerStock($id){
        $val=0;
        $ans=RecordAnswer::where('answer','=',1)->where('record_id',$id)->pluck('stock_id');
        return Stock::whereIn('id',$ans)->sum('stock_number');
    }
    public function NoAnswerStock($id){
        $val=0;
        $ans=RecordAnswer::where('answer','=',0)->where('record_id',$id)->pluck('stock_id');
        return Stock::whereIn('id',$ans)->sum('stock_number');
    }
}
