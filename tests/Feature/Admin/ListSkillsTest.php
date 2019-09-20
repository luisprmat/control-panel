<?php

namespace Tests\Feature\Admin;

use App\Skill;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListSkillsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_skills_list()
    {
        factory(Skill::class)->create(['name' => 'PHP']);

        factory(Skill::class)->create(['name' => 'JS']);

        factory(Skill::class)->create(['name' => 'TDD']);

        $this->get('/habilidades')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'JS',
                'PHP',
                'TDD',
            ]);
    }
}
