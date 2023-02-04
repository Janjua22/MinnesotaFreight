<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use App\Models\Country;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $json = Storage::get('public/json-data/countries.json');
        $countries = json_decode($json);
        $data = array();

        foreach($countries->countries as $obj){
            array_push($data, [
                'id' => intval($obj->c_id),
                'name' => $obj->c_name,
                'iso2' => $obj->c_iso2,
                'phone_code' => intval($obj->c_phone_code)
            ]);
        }

        Country::truncate();

        Country::insert($data);
    }
}
