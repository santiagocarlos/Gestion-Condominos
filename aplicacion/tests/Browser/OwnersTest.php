<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OwnersTest extends DuskTestCase
{
    /**
     * @test
     */
    public function admin_can_store_owners()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\User::findOrFail(1);
            $browser->loginAs($user)
                ->visit('/admin/owners/create')
                    ->type('name', 'Prueba Nombre')
                    ->type('last_name', 'Prueba Apellido')
                    ->type('ci', '12345678')
                    ->type('birth', '02-01-2000')
                    ->type('email', 'prueba@test.com')
                    ->type('phone', '0414-1234567')
                    ->type('password', bcrypt('123123'))
                    ->type('password_confirmation', bcrypt('123123'))
                    ->select('apartments')
                    ->type('role', 2)
                    ->press('#btn-save')
                    ->screenshot('owners-save')
                    ->assertSee('Agregar Propietario!');
        });
    }
}
