<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomStock extends Model
{
    use HasFactory;
    public $name,$orginal,$agent1,$agent2,$all;

    /**
     * CustomStock constructor.
     * @param $name
     * @param $agent1
     * @param $agent2
     * @param $all
     */


}
