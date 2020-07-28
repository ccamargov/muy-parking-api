<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Define the relation between Ticket and Owner. A Ticket belongs to ParkingContract.
    public function plan() {
        return $this->belongsTo('App\ParkingContract');
    }
}
