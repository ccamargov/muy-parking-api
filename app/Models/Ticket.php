<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Define the relation between Ticket and Owner. A Ticket belongs to ParkingContract.
    public function plan()
    {
        return $this->belongsTo('App\ParkingContract');
    }

    /**
     * Find active tickets related to ParkingContract, without departure info.
     *
     * @param  int  $parkingContractId
     * @return Illuminate\Support\Collection
     */
    public static function hasActiveTicketByParkingContract(int $parkingContractId)
    {
        $tickets = Ticket::where('parking_contract_id', $parkingContractId)->get();
        if (count($tickets) == 0) {
            return false;
        }
        $ticketsFiltered = $tickets->whereNotNull('entry_time')
            ->whereNull('exit_time');
        return (count($ticketsFiltered) > 0);
    }
}
