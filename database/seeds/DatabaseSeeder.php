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
        
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(GroupesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);

        /*factory(App\Abonnement::class, 3)->create()->each(function(App\Abonnement $abonnement) {
                factory(App\User::class, 10)
                    ->create([
                        'groupe_id' => $abonnement->groupe_id,
                    ]);
            });;*/
    }
}
