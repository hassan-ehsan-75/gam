<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
    public function user(){
        return $this->belongsTo(Employee::class,'user_id','id')->with('branch');
    }
    public function agent1(){
        return $this->hasOne(Stock::class,'id','agency1');
    }
    public function agent2(){
        return $this->hasOne(Agent::class,'id','agency2');
    }
    public function agents1(){
        return $this->hasMany(Stock::class,'agency1','id');
    }
    public function agents1Sum(){
        return $this->hasMany(Stock::class,'agency1','id')->sum('stock_number');
    }
    public function agents2(){
        return $this->hasMany(Agent::class,'id','agency2');
    }
}
