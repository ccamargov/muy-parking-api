<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    // Define the relation between Vehicle and ParkingContracts. A Vehicle has many ParkingContracts related.
    public function parkingContracts()
    {
        return $this->hasMany('App\ParkingContract');
    }
}
