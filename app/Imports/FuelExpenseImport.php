<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\FuelExpense;

class FuelExpenseImport implements ToModel, WithHeadingRow{
    /**
     * Selected truck's id.
     * 
     * @var int
     */
    protected $truckId;

    /**
     * Selected truck's id.
     * 
     * @var int
     */
    protected $loadId;

    /**
     * Imported sheet's id.
     * 
     * @var int
     */
    protected $sheetId;

    /**
     * Constructor function for the class.
     * 
     * @param int - $truckId
     */
    function __construct(int $truckId, int $loadId, int $sheetId){
        $this->truckId = $truckId;
        $this->loadId = $loadId;
        $this->sheetId = $sheetId;
    }

    /**
     * @param array - $row
     *
     * @return FuelExpense|null
     */
    public function model(array $row){
        if($row['tran_date']){
            return new FuelExpense([
                'sheet_id' => $this->sheetId,
                'truck_id' => $this->truckId,
                'load_id' => $this->loadId,
                'date' => trim($row['tran_date']), // Date::excelToDateTimeObject($row['tran_date'])
                'state_code' => trim($row['state_prov']),
                'location_name' => trim($row['location_name']),
                'fee' => $row['fees'],
                'unit_price' => $row['unit_price'],
                'volume' => $row['qty'],
                'fuel_type' => trim($row['item']),
                'amount' => $row['amt'],
                'total' => $row['amt'] + $row['fees'],
                'settled' => 0,
            ]);
        }
    }
}