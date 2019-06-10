<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function validatePermission(Post $post, $accion){
    	if(auth()->user()->can($accion, $post)){
    		return 'true';
    	}else{
    		return 'false';
    	}
    }
}
