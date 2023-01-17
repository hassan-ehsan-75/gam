<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorWorkshop extends Model
{
    public function visitor(){
        return $this->belongsTo(Visitor::class,'visitor_id');
    }

    public function workshop(){
        return $this->belongsTo(WorkShop::class,'workshop_id');
    }
}
