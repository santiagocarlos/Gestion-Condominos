<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'super-admin';
        $role->display_name = 'Super Administrador';
        $role->save();

        /*$role = new Role();
        $role->name = 'admin';
        $role->display_name = 'Administrador';
        $role->save();*/

		$role = new Role();
        $role->name = 'owner';
        $role->display_name = 'Propietario';
        $role->save();
    }
}
