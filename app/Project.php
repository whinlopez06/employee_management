<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // allow mass assignment by inverse. the value inside guarded will not be allowed to mass assign
    protected $guarded = [];
    
}
