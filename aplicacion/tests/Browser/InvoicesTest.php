<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InvoicesTest extends DuskTestCase
{
    /**
     * @test
     */
    public function admin_can_add_invoices()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\User::findOrFail(1);
            $browser->loginAs($user)
                    ->visit('/admin/invoices/create')
                    ->type('nro_invoice', 55555)
                    ->select('expense_id')
                    ->type('date', '03-01-2019')
                    ->type('amount', 2000)
                    ->press('#btn-save')
                    ->screenshot('invoices')
                    ->assertSee('Guardado exitosamente!');
        });
    }
}
