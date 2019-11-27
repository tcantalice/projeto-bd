<?php

use App\Models\ClienteMensalista;
use Illuminate\Database\Seeder;

class ClienteMensalistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ClienteMensalista::class, 50)->create();
    }
}
