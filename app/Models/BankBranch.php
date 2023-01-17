<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function user(){
        return $this->belongsTo(Employee::class,'id','branch_id');
    }
}
