<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UsersPermissionsController extends Controller
{
    public function update(Request $request, User $user)
    {
        if (Auth::user()->hasRole('Admin')) {
        	$user->permissions()->detach();
        	if (request()->wantsJson()) {
    	        if ($request->filled('permissions')) {
    	    		$user->givePermissionTo($request->permissions);
    	    	}
            }else{
               return response()->json(['error' => 'Unauthorized'], 401, []);
            }
        }else{
           return response()->json(['error' => 'Unauthorized'], 403, []);
        }
    }

    public function edit(User $user)
    {
        /*$this->authorize('update', $user);*/
        $datos = [
        	'permissions' => Permission::all(),
        	'user'	=> User::with('permissions')->find($user->id)
        ];

        if (request()->wantsJson()) {
            return response()->json($datos, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
