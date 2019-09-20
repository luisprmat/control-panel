<?php

use App\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Skill::class)->create(['name' => 'HTML']);
        factory(Skill::class)->create(['name' => 'CSS']);
        factory(Skill::class)->create(['name' => 'JS']);
        factory(Skill::class)->create(['name' => 'PHP']);
        factory(Skill::class)->create(['name' => 'SQL']);
        factory(Skill::class)->create(['name' => 'OOP']);
        factory(Skill::class)->create(['name' => 'TDD']);
    }
}

