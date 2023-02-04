<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;
use App\Models\City;

class CustomerImport implements ToModel, WithHeadingRow{
    /**
     * @param array - $row
     *
     * @return Customer|null
     */
    public function model(array $row){
        $city_id = null;
        $state_id = null;
        $country_id = 231; // 231 is United States id in country database...

        $cities = City::where('name', 'LIKE', '%'.$row['city'].'%')->get();

        foreach($cities as $city){
            if($city->state->country->id == $country_id){ 
                if($state_id == null){
                    $state_id = $city->state->id;
                    $city_id = $city->id;
                }
            }
        }

        if($city_id && $state_id){
            return new Customer([
                'name' => $row['company_name'],
                'type' => 'Direct',
                'street' => $row['address'],
                'suite' => null,
                'state_id' => $state_id,
                'city_id' => $city_id,
                'zip' => $row['zip'],
                'lat' => null,
                'lng' => null,
                'phone' => $row['telephone'],
                'status' => 1
            ]);
        }
    }
}