<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UseCases\StoreEntranceTicket;
use App\UseCases\StoreDepartureTicket;
use App\UseCases\ListPendingBalanceTickets;
use App\UseCases\PayTicket;

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
     * Create record for departure of ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeDeparture(Request $request) {
        $this->validateData($request, [
            'plate_number' => 'required'
        ]);
        $storeDepartureTicket = new StoreDepartureTicket($request->input('plate_number'));
        return $storeDepartureTicket->execute();
    }

    /**
     * Create record for departure of ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTicketsWithPendingBalance(Request $request) {
        $this->validateData($request, [
            'plate_number' => 'required'
        ]);
        $listPendingBalanceTickets = new ListPendingBalanceTickets($request->input('plate_number'));
        return $listPendingBalanceTickets->execute();
    }

    /**
     * Update payment ammount for ticket by reference_payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payTicketByReference(Request $request) {
        $this->validateData($request, [
            'payment_reference' => 'required',
            'owner_ammount' => 'required'
        ]);
        $PayTicket = new PayTicket($request->input('payment_reference'),
            $request->input('owner_ammount'));
        return $PayTicket->execute();
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
