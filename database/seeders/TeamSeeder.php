<?php

namespace Database\Seeders;

use App\Models\Team;
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
        Team::factory()->create(['name' => 'Styde']);
        Team::factory()->create(['name' => 'IEDTCPQ']);
        Team::factory()->create(['name' => 'Coca Cola']);
        Team::factory()->create(['name' => 'Postobón']);
        Team::factory()->create(['name' => 'Open English']);

        Team::factory()->count(10)->create();
    }
}
