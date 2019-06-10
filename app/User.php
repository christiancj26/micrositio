<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name','avatar', 'email', 'password',
    ];

    /* protected static function boot(){

        parent::boot();

        static::deleting(function($user){
            Storage::disk('local')->delete($user->avatar);
        });
    }*/

    public function getRouteKeyName(){
        return 'name';
    }

     public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function scopeAllowed($query){
        if (auth()->user()->can('view', $this)) {
            return  $query;
        }
        return  $query->where('id', auth()->id());
    }

    public function getRoleDisplayNames(){
        return $this->roles->pluck('display_name')->implode(', ');
    }

    public function getAllPermissionsAttribute() {
      $permissions = [];
        if (Auth::user()->hasRole('Admin')) {
            $permissions =  Permission::all()->pluck('name');
        }else{
            foreach (Permission::all() as $permission) {
              if (Auth::user()->can($permission->name)) {
                $permissions[] = $permission->name;
              }
            }
        }

        return $permissions;
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
