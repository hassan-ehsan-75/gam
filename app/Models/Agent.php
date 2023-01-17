<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stock(){
        return $this->belongsTo(Stock::class,'id','agency2');
    }
    public function stocks(){
        return $this->hasMany(Stock::class,'agency2','id');
    }
    public function stocksSum(){
        return $this->hasMany(Stock::class,'agency2','id')->sum('stock_number');
    }
}
