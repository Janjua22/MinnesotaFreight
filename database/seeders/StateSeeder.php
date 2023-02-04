<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\State;

class StateSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $json = Storage::get('public/json-data/states.json');
        $states = json_decode($json);
        $data = array();

        foreach($states->states as $obj){
            array_push($data, [
                'id' => intval($obj->st_id),
                'name' => $obj->st_name,
                'country_id' => intval($obj->country_id)
            ]);
        }

        State::truncate();

        State::insert($data);
    }
}