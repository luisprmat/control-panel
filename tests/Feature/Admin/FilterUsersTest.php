<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function filter_users_by_state_active()
    {
        $this->withoutExceptionHandling();

        $activeUser = factory(User::class)->create();
        $inactiveUser = factory(User::class)->create();

        $response = $this->get('/usuarios?state=active');

        $response->assertViewHas('users', function ($users) use ($activeUser, $inactiveUser) {
            return $users->contains($activeUser)
                && !$users->contains($inactiveUser);
        });
    }

    /** @test */
    function filter_users_by_state_inactive()
    {
        $this->withoutExceptionHandling();

        $activeUser = factory(User::class)->create();
        $inactiveUser = factory(User::class)->create();

        $response = $this->get('/usuarios?state=inactive');

        $response->assertStatus(200);

        $response->assertViewHas('users', function ($users) use ($activeUser, $inactiveUser) {
            return $users->contains($inactiveUser)
                && !$users->contains($activeUser);
        });
    }
}
