<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use App\Marketer;
use App\Provider;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

	public function Permission()
	{
		$provider_permission = Permission::where('slug', 'cancel-reservation')->first();
		$marketer_permission = Permission::where('slug', 'cancel-reservation')->first();

		//RoleTableSeeder.php
		$provider_role = new Role();
		$provider_role->slug = 'provider';
		$provider_role->name = 'provider';
		$provider_role->save();
		$provider_role->permissions()->attach($provider_permission);

		$marketer_role = new Role();
		$marketer_role->slug = 'marketer';
		$marketer_role->name = 'marketer';
		$marketer_role->save();
		$marketer_role->permissions()->attach($marketer_permission);

		$provider_role = Role::where('slug', 'provider')->first();
		$marketer_role = Role::where('slug', 'marketer')->first();

		$reservation = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($provider_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($marketer_role);

		$provider_role = Role::where('slug', 'developer')->first();
		$marketer_role = Role::where('slug', 'manager')->first();
		$dev_perm = Permission::where('slug', 'create-tasks')->first();
		$manager_perm = Permission::where('slug', 'edit-users')->first();

		$developer = new User();
		$developer->name = 'Harsukh Makwana';
		$developer->email = 'harsukh21@gmail.com';
		$developer->password = bcrypt('harsukh21');
		$developer->save();
		$developer->roles()->attach($provider_role);
		$developer->permissions()->attach($dev_perm);

		$manager = new User();
		$manager->name = 'Jitesh Meniya';
		$manager->email = 'jitesh21@gmail.com';
		$manager->password = bcrypt('jitesh21');
		$manager->save();
		$manager->roles()->attach($marketer_role);
		$manager->permissions()->attach($manager_perm);


		return redirect()->back();
	}
}
