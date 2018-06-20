<?php

use Illuminate\Database\Seeder;

class SeedPermissons extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissons')->truncate(); // maak leeg

        DB::table('permissons')->insert(['role_Id' => 1, 'IsAdmin' => 1, 'locationPermisson' => 1, 'picturePermisson' => 1]);
        DB::table('permissons')->insert(['role_Id' => 2, 'IsAdmin' => 0, 'locationPermisson' => 1, 'picturePermisson' => 1]);
        DB::table('permissons')->insert(['role_Id' => 3, 'IsAdmin' => 0, 'locationPermisson' => 0, 'picturePermisson' => 1]);
        DB::table('permissons')->insert(['role_Id' => 4, 'IsAdmin' => 0, 'locationPermisson' => 0, 'picturePermisson' => 0]);

    }
}
