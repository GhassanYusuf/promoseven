<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

		$companies = array(
			array('name' => 'C HOTEL'),
            array('name' => 'CAMELOT'),
            array('name' => 'CITY CENTER CO WLL'),
            array('name' => 'CORAL BAY'),
            array('name' => 'CORAL SALON'),
            array('name' => 'CORAL SPA'),
            array('name' => 'DOMESTIC'),
            array('name' => 'FAIRMECH'),
            array('name' => 'GEMS'),
            array('name' => 'GOOD WHEELS'),
            array('name' => 'GULF EXPORT TECH '),
            array('name' => 'JJS'),
            array('name' => 'MCN'),
            array('name' => 'MIKNAS INDUSTRIAL'),
            array('name' => 'ON THE ROAD'),
            array('name' => 'PROMOSEVEN'),
            array('name' => 'RAYES'),
            array('name' => 'REAL ESTATE'),
            array('name' => 'SEVEN ENERGY'),
            array('name' => 'SEVEN HOTEL'),
            array('name' => 'SEVEN INTERIORS'),
            array('name' => 'SEVEN LEISURE'),
            array('name' => 'SEVEN PILLARS'),
            array('name' => 'STEEL TECH'),
            array('name' => 'TARBOUCHE'),
        );

        DB::table('companies')->insert($companies);
    }
}
