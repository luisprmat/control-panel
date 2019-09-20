<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Team::class)->create(['name' => 'Styde']);
        factory(Team::class)->create(['name' => 'IEDTCPQ']);
        factory(Team::class)->create(['name' => 'Coca Cola']);
        factory(Team::class)->create(['name' => 'Postobón']);
        factory(Team::class)->create(['name' => 'Open English']);

        factory(Team::class)->times(10)->create();
    }
}
