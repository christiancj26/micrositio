<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Redimencionar;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public function index()
    {
        return $users = User::allowed()->orderBy('id', 'desc')->paginate(5);
    }

    public function getAvatar(User $user){
        if ($user->id == Auth::user()->id) {
            return $user->avatar;
        }
        return Auth::user()->avatar;
    }

    public function create()
    {
        $datos = [
            'roles'                  => Role::with('permissions')->get(),
            'permissions'             => Permission::all()
        ];
        if (request()->wantsJson()) {
            return $datos;
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function store(Request $request)
    {
       $this->authorize('create', new User);
       if ($request->hasFile('avatar')) {
           $data = $request->validate([
                'name' => 'required|string|max:255',
                'avatar' => 'image',
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }else{
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = request()->file('avatar')->store('storage/avatars');
             //Resize image here
           /* $thumbnailpath = public_path($data['avatar']);
            $img = new Redimencionar();
            $img->redimencionarImgAvatar($thumbnailpath);*/
        }

        $data['password'] = str_random(8);

        $user = User::create($data);

        if ($request->filled('roles')) {
            $user->assignRole($request->roles);
        }

        if ($request->filled('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        /*UserWasCreated::dispatch($user, $data['password']);*/
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return $user = User::with('roles', 'permissions', 'posts')->find($user->id);

       if (request()->wantsJson()) {
            return response()->json($user, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        if (request()->wantsJson()) {
            return response()->json($user, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        if ($request->hasFile('avatar')) {
            $imageUrl = $user->avatar = request()->file('avatar')->store('storage/avatars');
            //Resize image here
            $thumbnailpath = public_path($imageUrl);
            $img = new Redimencionar();
            $img->redimencionarImgAvatar($thumbnailpath);

        }

        /*$user->roles()->detach();
        if ($request->filled('roles')) {
            $user->assignRole($request->roles);
        }

        $user->permissions()->detach();
        if ($request->filled('permissions')) {
            $user->givePermissionTo($request->permissions);
        }
*/
        $user->save();
    }


    public function destroy(User $user)
    {
       $this->authorize('delete', $user);

       if (request()->wantsJson() && $user->id != '1') {
            $user->delete();
        }else{
           return response()->json(['error' => 'Forbiden'], 403, []);
        }
    }
}
