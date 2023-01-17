<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public function collage(){
        return $this->belongsTo(Collage::class,'collage_id');
    }
}
