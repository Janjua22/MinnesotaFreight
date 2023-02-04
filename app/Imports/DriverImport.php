<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Models\DriverDetail;
use App\Models\DriverLicenseInfo;
use App\Models\User;
use App\Models\City;

class DriverImport implements ToModel, WithHeadingRow{
    /**
     * @param array - $row
     *
     * @return DriverDetail|null
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
            if($row['e_mail']){
                $first_name = '';
                $last_name = '';
                $nameDivided = explode(" ", $row['name']);

                foreach($nameDivided as $index => $chunk){
                    if($index == 0){
                        $first_name = strtolower($chunk);
                    } else{
                        $last_name .= strtolower($chunk)." ";
                    }
                }

                $user = User::create([
                    'first_name' => ucfirst($first_name),
                    'last_name' => ucfirst($last_name),
                    'email' => trim(strtolower($row['e_mail'])),
                    'password' => Hash::make('12345678'),
                    'image' => 'img/user/drivers/default.jpg',
                    'phone' => trim($row['telephone']),
                    'address' => trim($row['address']),
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'role_id' => 2
                ]);

                $percentage = explode(".", $row['percentage']);

                DriverDetail::create([
                    'user_id' => $user->id,
                    'street' => null,
                    'suite' => null,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'zip' => $row['postal'],
                    'payment_type' => 3,
                    'manual_pay' => null,
                    'off_mile_fee' => null,
                    'on_mile_fee' => null,
                    'off_mile_range' => null,
                    'pay_percent' => $percentage[0],
                    'med_renewal' => ($row['next_medical'] != "0000-00-00")? $row['next_medical'] : null,
                    'hired_at' => ($row['doh'] != "0000-00-00")? $row['doh'] : null,
                    'fired_at' => null,
                    'truck_assigned' => null
                ]);

                return new DriverLicenseInfo([
                    'user_id' => $user->id,
                    'license_number' => $row['license_number'],
                    'expiration' => ($row['license_expiry'] != "0000-00-00")? $row['license_expiry'] : null,
                    'issue_state' => $state_id,
                    'file_license' => null,
                    'file_medical' => null
                ]);
            }
        }
    }
}