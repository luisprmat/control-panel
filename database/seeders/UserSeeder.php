<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\Team;
use App\Models\User;
use App\Models\Skill;
use App\Models\Profession;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $professions;
    protected $skills;
    protected $teams;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fetchRelations();

        $user = $this->createAdmin();

        $user2 = User::factory()->create([
            'team_id' => $this->teams->firstWhere('name', 'IEDTCPQ'),
            'first_name' => 'Natalia',
            'last_name' => 'Manrique',
            'email' => 'natis_andru@hotmail.com',
            'password' => bcrypt('456789123'),
            'created_at' => now()->addHour(),
            'active' => true,
        ]);


        $user2->profile->update([
            'bio' => 'English teacher',
            'profession_id' => $this->professions->firstWhere('title', 'English teacher')->id,
        ]);

        foreach (range(1, 99) as $i) {
            $this->createRandomUser();
        }
    }

    protected function fetchRelations()
    {
        $this->professions = Profession::all();
        $this->skills = Skill::all();
        $this->teams = Team::all();
    }

    protected function createAdmin()
    {
        $admin = User::factory()->create([
            'team_id' => $this->teams->firstWhere('name', 'IEDTCPQ'),
            'first_name' => 'Luis',
            'last_name' => 'Parrado',
            'email' => 'luisprmat@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'created_at' => now(),
            'active' => true,
        ]);

        $admin->skills()->attach($this->skills->whereIn('name', [
            'HTML',
            'CSS',
            'OOP',
        ]));

        $admin->profile->update([
            'bio' => 'Programador, profesor, editor',
            'profession_id' => $this->professions->firstWhere('title', 'Desarrollador front-end')->id,
        ]);
    }

    protected function createRandomUser()
    {
        $user = User::factory()->create([
            'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
            'active' => rand(0, 3) ? true : false,
            'created_at' => now()->subDays(rand(1, 90)),
        ]);

        $user->skills()->attach($this->skills->random(rand(0, 7)));

        $user->profile->update([
            'profession_id' => rand(0, 2) ? $this->professions->random()->id: null,
        ]);

        Login::factory()->times(rand(1, 10))->create([
            'user_id' => $user->id
        ]);
    }
}
