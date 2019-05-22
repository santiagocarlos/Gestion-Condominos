<?php

use App\Bank;
use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new Bank();
        $bank->name = 'Pago en Efectivo';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Provincial';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Caroní';
        $bank->save();

		$bank = new Bank();
        $bank->name = 'Corp Banca';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco del Caribe';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco de Venezuela';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Sofitasa';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banesco';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Fondo Común';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banfoandes';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Occidental de Descuento';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Venezolano de Crédito';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Exterior';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Mercantil';
        $bank->save();

        $bank = new Bank();
        $bank->name = 'Banco Del Sur';
        $bank->save();
    }
}
