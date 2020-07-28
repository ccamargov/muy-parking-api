<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // Define the relation between Plan and ParkingContracts. A Plan has many ParkingContracts related.
    public function parkingContracts() {
        return $this->hasMany('App\ParkingContract');
    }
}
