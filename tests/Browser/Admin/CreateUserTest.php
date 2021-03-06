<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use App\Models\Skill;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\Profession;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_be_created()
    {
        $profession = Profession::factory()->create();

        $skillA = Skill::factory()->create();
        $skillB = Skill::factory()->create();

        $this->browse(function (Browser $browser) use ($profession, $skillA, $skillB) {
            $browser->visit('usuarios/nuevo')
                ->type('first_name', 'Luis')
                ->type('last_name', 'Parrado')
                ->type('email', 'luisprmat@gmail.com')
                ->type('password', 'laravel')
                ->type('bio', 'Programador')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'http://twitter.com/luisparrado')
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role', 'user')
                ->radio('state', 'active')
                ->press('Crear usuario')
                ->assertPathIs('/usuarios')
                ->assertSee('Luis')
                ->assertSee('luisprmat@gmail.com');;
        });

        $this->assertCredentials([
            'first_name' => 'Luis',
            'last_name' => 'Parrado',
            'password' => 'laravel',
            'role' => 'user',
            'active' => true,
        ]);

        $user = User::findByEmail('luisprmat@gmail.com');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador',
            'twitter' => 'http://twitter.com/luisparrado',
        ]);
    }
}
