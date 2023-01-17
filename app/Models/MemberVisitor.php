<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MemberVisitor extends Model
{
    protected $fillable = [
        'is_approved'
    ];
    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }
    public function member(){
        return $this->belongsTo(User::class,'member_id');
    }

}
