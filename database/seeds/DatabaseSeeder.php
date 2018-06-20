<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('users')->insert(
	    	[
		    'username' => 'test0',
		    'email' => str_random(10).'@gmail.com',
		    'IsFrozen' => 0,
		    'password' => bcrypt('secret'),
		    'roleId' => rand(1,4),
	         ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => 'test1',
			    'email' => str_random(10).'@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('secret'),
			    'roleId' => rand(1,4),
		    ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => 'test2',
			    'email' => str_random(10).'@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('secret'),
			    'roleId' => rand(1,4),
		    ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => 'test3',
			    'email' => str_random(10).'@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('secret'),
			    'roleId' => rand(1,4),
		    ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => str_random(10),
			    'email' => str_random(10).'@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('secret'),
			    'roleId' => rand(1,4),
		    ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => 'test4',
			    'email' => str_random(10).'@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('secret'),
			    'roleId' => rand(1,4),
		    ]
	    );
	    DB::table('users')->insert(
		    [
			    'username' => 'kleynAdmin',
			    'email' => 'kleynpark@gmail.com',
			    'IsFrozen' => 0,
			    'password' => bcrypt('admin'),
			    'roleId' => 1,
		    ]
	    );

	    DB::table('roles')->insert([
		    'roleName' => 'Administrator',
	    ]);
	    DB::table('roles')->insert([
		    'roleName' => 'Terrainworker',
	    ]);
	    DB::table('roles')->insert([
		    'roleName' => 'Salesman',
	    ]);
	    DB::table('roles')->insert([
		    'roleName' => 'Guest',
	    ]);
        $this->call(SeedPermissons::class);
    }
}
