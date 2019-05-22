<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends DuskTestCase
{
    /**
    @test
    */
    function test_can_see_user_profile()
    {
        $this->browse(function ($browser) {
            $browser->visit('/profile')
                ->waitFor('#user')
                ->assertSeeIn('.name', 'abalozz')
                ->assertSeeIn('.email', 'abalozz@example.com');
        });
    }
}
