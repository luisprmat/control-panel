<?php

namespace Tests\Browser\Admin;

use App\Profession;
use App\Skill;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_be_created()
    {
        $profession = factory(Profession::class)->create();

        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->browse(function (Browser $browser, $browser2) use ($profession, $skillA, $skillB) {
            $browser->visit('usuarios/nuevo')
                ->type('name', 'Luis')
                ->type('email', 'luisprmat@gmail.com')
                ->type('password', 'laravel')
                ->type('bio', 'Programador')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'http://twitter.com/luisparrado')
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role', 'user')
                ->press('Crear usuario');

            $browser2->visit('usuarios')
                ->assertSee('Luis')
                ->assertSee('luisprmat@gmail.com');
        });
    }
}
