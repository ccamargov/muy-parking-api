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
    public static function findActiveTicketByParkingContract(int $parkingContractId)
    {
        return Ticket::where('parking_contract_id', $parkingContractId)
            ->whereNotNull('entry_time')
            ->whereNull('exit_time')
            ->get();
    }
}
