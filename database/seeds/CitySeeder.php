<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(base_path() . '/database/seeds/cities.json');
        $json_a = json_decode($json, true);

        foreach ($json_a as $key => $city) {
            City::create(['uf_id' => $city['uf'], 'name' => $city['name']]);
        }

    }
}
