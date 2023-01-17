<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function gathering(){
        return $this->belongsTo(Gathering::class,'gathering_id','id');
    }

    public function votes(){
        return $this->hasOne(CandidateVote::class,'candidate_id','id');
    }
}
