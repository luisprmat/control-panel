<?php

namespace Tests\Feature\Admin;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    function search_users_by_first_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'email' => 'joel@example.net',
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'email' => 'ellie@example.com',
        ]);

        $this->get('/usuarios?search=Joel')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test  */
    function show_results_with_a_partial_search_by_first_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'email' => 'joel@example.net',
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'email' => 'ellie@example.com',
        ]);

        $this->get('/usuarios?search=Jo')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test  */
    function search_users_by_full_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'last_name' => 'Williams',
        ]);

        $this->get('/usuarios?search=Joel Miller')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test  */
    function show_results_with_a_partial_search_by_full_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'last_name' => 'Miller',
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'last_name' => 'Williams',
        ]);

        $this->get('/usuarios?search=Joel M')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && !$users->contains($ellie);
            });
    }

    /** @test  */
    function search_users_by_email()
    {
        $joel = User::factory()->create([
            'email' => 'joel@example.com'
        ]);

        $ellie = User::factory()->create([
            'email' => 'elli@example.net'
        ]);

        $this->get('/usuarios?search=joel@example.com')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && ! $users->contains($ellie);
            });
    }

    /** @test */
    function show_results_with_a_partial_search_by_email()
    {
        $joel = User::factory()->create([
            'email' => 'joel@example.com'
        ]);

        $ellie = User::factory()->create([
            'email' => 'elli@example.net'
        ]);
        $this->get('/usuarios?search=joel@exampl')
            ->assertStatus(200)
            ->assertViewHas('users', function ($users) use ($joel, $ellie) {
                return $users->contains($joel) && ! $users->contains($ellie);
        });

    }

    /** @test  */
    function search_users_by_team_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'team_id' => Team::factory()->create(['name' => 'Smuggler'])->id,
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);

        $marlene = User::factory()->create([
            'first_name' => 'Marlene',
            'team_id' => Team::factory()->create(['name' => 'Firefly'])->id,
        ]);

        $response = $this->get('/usuarios?search=Firefly')
            ->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($marlene)
            ->notContains($joel)
            ->notContains($ellie);
    }
    /** @test  */
    function partial_search_by_team_name()
    {
        $joel = User::factory()->create([
            'first_name' => 'Joel',
            'team_id' => Team::factory()->create(['name' => 'Smuggler'])->id,
        ]);

        $ellie = User::factory()->create([
            'first_name' => 'Ellie',
            'team_id' => null,
        ]);

        $marlene = User::factory()->create([
            'first_name' => 'Marlene',
            'team_id' => Team::factory()->create(['name' => 'Firefly'])->id,
        ]);

        $response = $this->get('/usuarios?search=Fire')
            ->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($marlene)
            ->notContains($joel)
            ->notContains($ellie);
    }
}
