<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UseCases\StoreEntranceTicket;

class TicketController extends Controller
{
    /**
     * Create record for new entrance ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeEntrance(Request $request) {
        $this->validateData($request, [
            'plate_number' => 'required'
        ]);

        $storeEntranceTicket = new StoreEntranceTicket($request->input('plate_number'));
        return $storeEntranceTicket->execute();
    }

    /**
     * Validate basic data to save a State record.
     *
     * @param  Request  $request
     */
    private function validateData(Request $request, array $fields) {
        $validation = Validator::make($request->all(), $fields);
        $validation->validate();
    }
  
}
