<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersRolesController extends Controller
{
    public function update(Request $request, User $user)
    {
        if (Auth::user()->hasRole('Admin')) {
        	$user->roles()->detach();
        	if (request()->wantsJson()) {
    	        if ($request->filled('roles')) {
    	            $user->assignRole($request->roles);
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
        	'roles' => Role::all(),
        	'user'	=> User::with('roles')->find($user->id)
        ];

        if (request()->wantsJson()) {
            return response()->json($datos, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
