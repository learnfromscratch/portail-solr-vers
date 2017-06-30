<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(['name' => 'create', 'description' => 'Permission de créer']);
        DB::table('permissions')->insert(['name' => 'read', 'description' => 'Permission de lire']);
        DB::table('permissions')->insert(['name' => 'update', 'description' => 'Permission de modifier']);
        DB::table('permissions')->insert(['name' => 'destroy', 'description' => 'Permission de supprimer']);
    }
}
