<?php

namespace Tests\Feature\Admin;

use App\{Profession, User, UserProfile};
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'first_name' => 'Luis',
        'last_name' => 'Parrado',
        'email' => 'luisprmat@gmail.com',
        'bio' => 'Programador de Laravel y Vue.js',
        'profession_id' => '',
        'twitter' => 'https://twitter.com/luisparrado',
    ];

    /** @test */
    function a_user_can_edit_its_profile()
    {
       $user = factory(User::class)->create();

       $newProfession = factory(Profession::class)->create();

       //$this->actingAs($user);

       $response = $this->get('/editar-perfil/');

       $response->assertStatus(200);

       $response = $this->put('/editar-perfil/', [
          'first_name' => 'Luis',
          'last_name' => 'Parrado',
          'email' => 'luisprmat@gmail.com',
          'bio' => 'Programador de Laravel y Vue.js',
          'twitter' => 'https://twitter.com/luisparrado',
          'profession_id' => $newProfession->id,
       ]);

       $response->assertRedirect();

       $this->assertDatabaseHas('users', [
           'first_name' => 'Luis',
           'last_name' => 'Parrado',
           'email' => 'luisprmat@gmail.com',
       ]);

       $this->assertDatabaseHas('user_profiles', [
           'bio' => 'Programador de Laravel y Vue.js',
           'twitter' => 'https://twitter.com/luisparrado',
           'profession_id' => $newProfession->id,
       ]);
    }

    /** @test */
    function the_user_cannot_change_its_role()
    {
        $user = factory(User::class)->create([
            'role' => 'user',
        ]);

        $response = $this->put('/editar-perfil/', $this->withData([
            'role' => 'admin',
        ]));

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'user',
        ]);
    }

    /** @test */
    function the_user_cannot_change_its_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('old12345'),
        ]);

        $response = $this->put('/editar-perfil/', $this->withData([
            'email' => 'luisprmat@gmail.com',
            'password' => 'new12345',
        ]));

        $response->assertRedirect();

        $this->assertCredentials([
            'email' => 'luisprmat@gmail.com',
            'password' => 'old12345',
        ]);
    }
}
