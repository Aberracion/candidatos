<?php

use Illuminate\Database\Seeder;
use Candidatos\Role;
use Candidatos\User;
use Candidatos\RoleUser;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = new Role();
        $roles->name = "super";
        $roles->description = "Superadministrador";
        $roles->save();

        $rolea = new Role();
        $rolea->name = "admin";
        $rolea->description = "Administrador";
        $rolea->save();

        $roleu = new Role();
        $roleu->name = "user";
        $roleu->description = "Usuario";
        $roleu->save();

        $user = new User();
        $user->name = 'superadmin';
        $user->email = 'pruebas@pruebas.com';
        $user->password = bcrypt('pruebas');
        $user->save();

        $roluser = new RoleUser();
        $roluser->user_id = $user->id;
        $roluser->role_id = $roles->id;
        $roluser->save();
    }

}
