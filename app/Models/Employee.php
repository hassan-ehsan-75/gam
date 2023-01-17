<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
    public function branch(){
        return $this->belongsTo(BankBranch::class);
    }
}
