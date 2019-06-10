<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        Role::truncate();
        User::truncate();

        $adminRole = Role::create(['name' => 'Admin', 'display_name' => 'Administrador']);
        $writerRole = Role::create(['name' => 'Writer', 'display_name' => 'Escritor']);

        $viewPostsPermision = Permission::create(['name' => 'Ver noticias']);
        $createPostsPermision = Permission::create(['name' => 'Crear noticias']);
        $updatePostsPermision = Permission::create(['name' => 'Modificar noticias']);
        $deletePostsPermision = Permission::create(['name' => 'Eliminar noticias']);

        $viewUsersPermision = Permission::create(['name' => 'Ver usuarios']);
        $createUsersPermision = Permission::create(['name' => 'Crear usuarios']);
        $updateUsersPermision = Permission::create(['name' => 'Modificar usuarios']);
        $deleteUsersPermision = Permission::create(['name' => 'Eliminar usuarios']);

        $viewRolesPermision = Permission::create(['name' => 'Ver roles']);
        $createRolesPermision = Permission::create(['name' => 'Crear roles']);
        $updateRolesPermision = Permission::create(['name' => 'Modificar roles']);
        $deleteRolesPermision = Permission::create(['name' => 'Eliminar roles']);

        $writerRole->givePermissionTo($createPostsPermision);

        $admin = new User;
        $admin->name = "Christian parra";
        $admin->email = "christian_cj26@hotmail.com";
        $admin->password = "tequila12";
        $admin->save();

        $admin->assignRole($adminRole);

        $admin2 = new User;
        $admin2->name = "Irma sandoval";
        $admin2->email = "irma_sandoval@hotmail.com";
        $admin2->password = "tequila12";
        $admin2->save();

        $admin2->assignRole($writerRole);

        $admin2->givePermissionTo($viewPostsPermision);
    }
}
