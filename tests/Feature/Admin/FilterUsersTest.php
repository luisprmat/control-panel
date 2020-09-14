<?php

namespace Tests\Feature\Admin;

use App\Models\Skill;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function filter_users_by_state_active()
    {
        User::factory()->create(['first_name' => 'Usuario activo']);

        User::factory()->inactive()->create(['first_name' => 'Luis inactivo']);

        $response = $this->get('/usuarios?state=active');

        $response->assertSee('Usuario activo')
            ->assertDontSee('Luis inactivo');
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        User::factory()->create(['first_name' => 'Usuario activo']);

        User::factory()->inactive()->create(['first_name' => 'Luis inactivo']);

        $response = $this->get('/usuarios?state=inactive');

        $response->assertStatus(200);

        $response->assertDontSee('Usuario activo')
            ->assertSee('Luis inactivo');
    }

    /** @test */
    function filter_users_by_role_admin()
    {
        User::factory()->create([
            'role' => 'admin',
            'first_name' => 'Luis'
        ]);

        User::factory()->create([
            'role' => 'user',
            'first_name' => 'Jorge'
        ]);

        $response = $this->get('/usuarios?role=admin');

        $response->assertSee('Luis')
            ->assertDontSee('Jorge');
    }

    /** @test */
    function filter_users_by_role_user()
    {
        User::factory()->create([
            'role' => 'admin',
            'first_name' => 'Luis'
        ]);

        User::factory()->create([
            'role' => 'user',
            'first_name' => 'Jorge'
        ]);

        $response = $this->get('/usuarios?role=user');

        $response->assertStatus(200);

        $response->assertSee('Jorge')
            ->assertDontSee('Luis');
    }

    /** @test */
    function filter_user_by_skill()
    {
        $php = Skill::factory()->create(['name' => 'php']);
        $css = Skill::factory()->create(['name' => 'css']);

        $backendDev = User::factory()->create();
        $backendDev->skills()->attach($php);

        $fullStackDev = User::factory()->create();
        $fullStackDev->skills()->attach([$php->id, $css->id]);

        $frontendDev = User::factory()->create();
        $frontendDev->skills()->attach($css);

        $response = $this->get("/usuarios?skills[0]={$php->id}&skills[1]={$css->id}");

        $response->assertStatus(200);

        $response->assertSee($fullStackDev->name)
            ->assertDontSee($backendDev->name)
            ->assertDontSee($frontendDev->name);
    }

    /** @test */
    function filter_users_created_from_date()
    {
        $newestUser = User::factory()->create([
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = User::factory()->create([
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = User::factory()->create([
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = User::factory()->create([
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?from=01/10/2018');

        $response->assertOk();

        $response->assertSee($newUser->name)
            ->assertSee($newestUser->name)
            ->assertDontSee($oldUser->name)
            ->assertDontSee($oldestUser->name);
    }

    /** @test */
    function filter_users_created_to_date()
    {
        $newestUser = User::factory()->create([
            'created_at' => '2018-10-02 12:00:00',
        ]);

        $oldestUser = User::factory()->create([
            'created_at' => '2018-09-29 12:00:00',
        ]);

        $newUser = User::factory()->create([
            'created_at' => '2018-10-01 00:00:00',
        ]);

        $oldUser = User::factory()->create([
            'created_at' => '2018-09-30 23:59:59',
        ]);

        $response = $this->get('usuarios?to=30/09/2018');

        $response->assertOk();

        $response->assertSee($oldestUser->name)
            ->assertSee($oldUser->name)
            ->assertDontSee($newUser->name)
            ->assertDontSee($newestUser->name);
    }
}
