<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $guarded = [];

	public function getRouteKeyName(){

        return 'name';

    }

    public function region(){

    	return $this->belongsTo(region::class);

    }

    public function posts(){

    	return $this->hasMany(Post::class);

    }
}
