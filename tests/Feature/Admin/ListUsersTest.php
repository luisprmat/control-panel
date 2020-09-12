<?php

namespace Tests\Feature\Admin;

use App\Models\Login;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    function it_shows_the_users_list()
    {
        User::factory()->create([
            'first_name' => 'Stella',
            'last_name' => 'Carlson',
        ]);

        User::factory()->create([
            'first_name' => 'Pedro',
            'last_name' => 'Pérez',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee(trans('users.title.index'))
            ->assertSee('Stella Carlson')
            ->assertSee('Pedro Pérez');

        $this->assertNotRepeatedQueries();
    }

    /** @test  */
    function it_paginates_the_users()
    {
        User::factory()->create([
            'first_name' => 'Tercer Usuario',
            'created_at' => now()->subDays(5),
        ]);

        User::factory()->times(12)->create([
            'created_at' => now()->subDays(4),
        ]);

        User::factory()->create([
            'first_name' => 'Decimoséptimo Usuario',
            'created_at' => now()->subDays(2),
        ]);

        User::factory()->create([
            'first_name' => 'Segundo Usuario',
            'created_at' => now()->subDays(6),
        ]);

        User::factory()->create([
            'first_name' => 'Primer Usuario',
            'created_at' => now()->subWeek(),
        ]);

        User::factory()->create([
            'first_name' => 'Decimosexto Usuario',
            'created_at' => now()->subDays(3),
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Decimoséptimo Usuario',
                'Decimosexto Usuario',
                'Tercer Usuario',
            ])
            ->assertDontSee('Segundo Usuario')
            ->assertDontSee('Primer Usuario');

        $this->get('/usuarios?page=2')
            ->assertSeeInOrder([
                'Segundo Usuario',
                'Primer Usuario',
            ])
            ->assertDontSee('Tercer Usuario');
    }

    /** @test */
    function users_are_ordered_by_name()
    {
        User::factory()->create(['first_name' => 'John' , 'last_name' => 'Dow']);
        User::factory()->create(['first_name' => 'Richard' , 'last_name' => 'Roe']);
        User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Dow']);

        $this->get('/usuarios?order=name')
            ->assertSeeInOrder([
                'Jane Dow',
                'John Dow',
                'Richard Roe'
            ]);

        $this->get('/usuarios?order=name-desc')
            ->assertSeeInOrder([
                'Richard Roe',
                'John Dow',
                'Jane Dow',
            ]);
    }

    /** @test */
    function users_are_ordered_by_email()
    {
        User::factory()->create(['email' => 'john.dow@example.com']);
        User::factory()->create(['email' => 'richard.row@example.net']);
        User::factory()->create(['email' => 'jane.dow@example.com']);

        $this->get('/usuarios?order=email')
            ->assertSeeInOrder([
                'jane.dow@example.com',
                'john.dow@example.com',
                'richard.row@example.net',
            ]);

        $this->get('/usuarios?order=email-desc')
            ->assertSeeInOrder([
                'richard.row@example.net',
                'john.dow@example.com',
                'jane.dow@example.com',
            ]);
    }

    /** @test */
    function users_are_ordered_by_registration_date()
    {
        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Dow',
            'created_at' => now()->subDays(2),
        ]);
        User::factory()->create([
            'first_name' => 'Richard',
            'last_name' => 'Roe',
            'created_at' => now()->subDays(3),
        ]);
        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Dow',
            'created_at' => now()->subDays(5),
        ]);

        $this->get('/usuarios?order=date')
            ->assertSeeInOrder([
                'Jane Dow',
                'Richard Roe',
                'John Dow',
            ]);

        $this->get('/usuarios?order=date-desc')
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);
    }

    /** @test */
    function users_are_ordered_by_login_date()
    {
        Login::factory()->create([
            'created_at' => now()->subDays(3),
            'user_id' => User::factory()->create(['first_name' => 'John', 'last_name' => 'Dow'])
        ]);

        Login::factory()->create([
            'created_at' => now()->subDay(),
            'user_id' => User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Dow'])
        ]);

        Login::factory()->create([
            'created_at' => now()->subDays(2),
            'user_id' => User::factory()->create(['first_name' => 'Richard', 'last_name' => 'Roe'])
        ]);

        $this->get('/usuarios?order=login')
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);

        $this->get('/usuarios?order=login-desc')
            ->assertSeeInOrder([
                'Jane Dow',
                'Richard Roe',
                'John Dow',
            ]);
    }

    /** @test */
    function invalid_order_query_data_is_ignored_and_the_default_order_is_used_instead()
    {
        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Dow',
            'created_at' => now()->subDays(2),
        ]);
        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Dow',
            'created_at' => now()->subDays(5),
        ]);
        User::factory()->create([
            'first_name' => 'Richard',
            'last_name' => 'Roe',
            'created_at' => now()->subDays(3),
        ]);

        $this->get('/usuarios?order=id')
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);

        $this->get('/usuarios?order=invalid_column-desc')
            ->assertOk()
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);

        $this->get('/usuarios?order=name-descendent')
            ->assertOk()
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);

        $this->get('/usuarios?order=asc-name')
            ->assertOk()
            ->assertSeeInOrder([
                'John Dow',
                'Richard Roe',
                'Jane Dow',
            ]);
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios en esta lista');
    }

    /** @test  */
    function it_shows_the__deleted_users()
    {
        User::factory()->create([
            'first_name' => 'Stella',
            'last_name' => 'Carlson',
            'deleted_at' => now(),
        ]);

        User::factory()->create([
            'first_name' => 'Pedro',
            'last_name' => 'Pérez',
        ]);

        $this->get('/usuarios/papelera')
            ->assertStatus(200)
            ->assertSee(trans('users.title.trash'))
            ->assertSee('Stella Carlson')
            ->assertDontSee('Pedro Pérez');
    }
}
