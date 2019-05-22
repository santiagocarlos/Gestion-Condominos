<?php

use App\WaysToPay;
use Illuminate\Database\Seeder;

class WaysToPaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ways_to_pay = new WaysToPay();
        $ways_to_pay->name = 'Efectivo';
        $ways_to_pay->save();

        $ways_to_pay = new WaysToPay();
        $ways_to_pay->name = 'Depósito Bancario';
        $ways_to_pay->save();

        $ways_to_pay = new WaysToPay();
        $ways_to_pay->name = 'Transferencia Bancaria del Mismo Banco';
        $ways_to_pay->save();

        $ways_to_pay = new WaysToPay();
        $ways_to_pay->name = 'Transferencia Bancaria de Otro Banco';
        $ways_to_pay->save();
    }
}
