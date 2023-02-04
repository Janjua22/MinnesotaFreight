<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Truck;

class TruckImport implements ToModel, WithHeadingRow{
    /**
     * @param array - $row
     *
     * @return Truck|null
     */
    public function model(array $row){
        $note = "";

        if($row['type'] != "" && $row['type'] != null){
            $note .= "Type: ".$row['type'];
        }
        if($row['plate_number'] != "" && $row['plate_number'] != null){
            $note .= "<br/>Plate Number: ".$row['plate_number'];
        }
        if($row['plate_expiry'] != "" && $row['plate_expiry'] != "0000-00-00"){
            $note .= "<br/>Plate Expiry: ".$row['plate_expiry'];
        }

        return new Truck([
            'truck_number' => $row['number'],
            'type_id' => 1,
            'ownership' => 'Company Owned',
            'current_location' => 1,
            'note' => $note,
            'created_at' => now(),
            'status' => 1
        ]);
    }
}