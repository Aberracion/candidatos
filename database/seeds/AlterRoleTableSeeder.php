<?php

use Illuminate\Database\Seeder;
use Candidatos\Role;


class AlterRoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roleu = Role::where('name', 'user')->first();
        $rolea = Role::where('name', 'admin')->first();
        $roles = Role::where('name', 'super')->first();

        $roles->description_en = 'Superadministrator';
        $rolea->description_en = 'Administrator';
        $roleu->description_en = 'User';

        $roleu->save();
        $rolea->save();
        $roles->save();
    }

}
