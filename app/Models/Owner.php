<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    // Define the relation between Owner and ParkingContracts. A Owner has many ParkingContracts related.
    public function parkingContracts() {
        return $this->hasMany('App\ParkingContract');
    }
}
