<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveRolesRequest;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    public function index()
    {
        $this->authorize('view', new Role);
        return  Role::all();
    }


    public function create()
    {
        $this->authorize('create', $role = new Role);
        return  Permission::all();
    }

    public function store(SaveRolesRequest $request)
    {
        $this->authorize('create', new Role);
        $role = Role::create($request->validated());
        if ($request->filled('permissions')) {
           $role->givePermissionTo($request->permissions);
        }

    }


    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $datos = [
            'permissions'   => Permission::all(),
            'role'          => $role
        ];

        if (request()->wantsJson()) {
            return response()->json($datos, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }


    public function update(SaveRolesRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->update($request->validated());
        $role->permissions()->detach();
        if ($request->filled('permissions')) {
           $role->givePermissionTo($request->permissions);
        }

    }


    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
    }
}
