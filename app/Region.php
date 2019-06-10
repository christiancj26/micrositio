<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function state(){

    	return $this->belongsTo(State::class);

    }

    public function municipalities(){

    	return $this->hasMany(Municipality::class);

    }

    public function posts(){

    	return $this->hasMany(Post::class);

    }
}
