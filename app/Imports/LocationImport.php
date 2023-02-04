<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Models\Location;
use App\Models\City;

class LocationImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading{
    /**
     * Object of all location's collection.
     * 
     * @var object
     */
    protected $allLocations;

    /**
     * Contructor function for the class.
     * 
     * @param object - $allLocations
     */
    function __construct(object $allLocations){
        $this->allLocations = $allLocations;
    }
    
    /**
     * @param array - $row
     *
     * @return Location|null
     */
    public function model(array $row){
        $city_id = null;
        $state_id = null;
        $country_id = 231; // 231 is United States id in country database...

        $cities = City::where('name', 'LIKE', '%'.$row['city'].'%')->get();

        foreach($cities as $city){
            if($city->state->country->id == $country_id){ 
                if($state_id == null){
                    // if($city->name == $row['city']){
                    //     $state_id = $city->state->id;
                    //     $city_id = $city->id;
                    // }
                    $state_id = $city->state->id;
                    $city_id = $city->id;
                }
            }
        }

        if($city_id && $state_id){
            $rowAlreadyExists = $this->allLocations->where(['name' => $row['name'], 'city_id' => $city_id]);

            if($rowAlreadyExists->count() == 0){
                return new Location([
                    'name' => $row['name'],
                    'type' => 'Direct',
                    'street' => $row['address'],
                    'suite' => null,
                    'state_id' => $state_id,
                    'city_id' => $city_id,
                    'zip' => $row['postal_code'],
                    'lat' => null,
                    'lng' => null,
                    'phone' => $row['telephone'],
                    'status' => 1
                ]);
            }
        }
    }

    /**
     * Override interface method to define a batch size
     * to insert.
     * 
     * @return int
     */
    public function batchSize(): int{
        return 1000;
    }

    /**
     * Override interface method to define a chunk size
     * to read.
     * 
     * @return int
     */
    public function chunkSize(): int{
        return 1000;
    }
}