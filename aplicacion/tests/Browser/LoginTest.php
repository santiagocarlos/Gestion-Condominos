<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function registered_users_can_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'sscarlos56@gmail.com')
                    ->type('password', '123123')
                    ->press('#btn-login')
                    ->screenshot('login')
                    ->assertAuthenticated();
        });
    }
}
