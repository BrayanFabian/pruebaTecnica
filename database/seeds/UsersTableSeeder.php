<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //obtener los roles
      $role_user = Role::where('name', 'user')->first();
      $role_admin = Role::where('name', 'admin')->first();

      //crear el usuario Administrador
      $user = new User();
      $user->name = 'Admin';
      $user->email = 'admin@mail.com';
      $user->password = bcrypt('admin123');
      $user->save();
      //asignar rol
      $user->roles()->attach($role_admin);

      //crear un usuario básico
      $user = new User();
      $user->name = 'User';
      $user->email = 'user@mail.com';
      $user->password = bcrypt('user123');
      $user->save();
      //asignar rol
      $user->roles()->attach($role_user);
    }
}
