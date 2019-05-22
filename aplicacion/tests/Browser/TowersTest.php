<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TowersTest extends DuskTestCase
{
    /**
     * @test
     */
    public function admin_can_add_towers()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\User::findOrFail(1);
            $browser->loginAs($user)
                    ->visit('/admin/towers/create')
                    ->type('tower', 'Torre de Prueba')
                    ->select('admin_id', '1')
                    ->press('#btn-save')
                    ->screenshot('towers')
                    ->assertSee('Guardado exitosamente!');
        });
    }
}
