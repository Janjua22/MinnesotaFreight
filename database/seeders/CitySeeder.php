<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\City;

class CitySeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $json = Storage::get('public/json-data/cities.json');
        $cities = json_decode($json);
        $data = array();

        foreach($cities->cities as $obj){
            array_push($data, [
                'id' => intval($obj->cty_id),
                'name' => $obj->cty_name,
                'state_id' => intval($obj->state_id)
            ]);
        }

        City::truncate();

        foreach(array_chunk($data, 10000) as $chunkedData){
            City::insert($chunkedData);
        }
    }
}
