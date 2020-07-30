<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UseCases\StoreParkingContract;

class ParkingContractController extends Controller
{
    /**
     * Create new parking contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createContract(Request $request) {
        $this->validateData($request, [
            'owner_id' => 'required',
            'vehicle_id' => 'required',
            'plan_id' => 'required',
            'start_date_plan' => 'required',
            'finish_date_plan' => 'required'
        ]);
        
        $storeParkingContract = new StoreParkingContract($request);
        return $storeParkingContract->execute();
    }

    /**
     * Validate basic data to save the record.
     *
     * @param  Request  $request
     */
    private function validateData(Request $request, array $fields) {
        $validation = Validator::make($request->all(), $fields);
        $validation->validate();
    }
  
}
