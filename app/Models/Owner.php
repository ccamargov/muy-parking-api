<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'document_number';
    public $incrementing = false;

    // Define the relation between Owner and ParkingContracts. A Owner has many ParkingContracts related.
    public function parkingContracts()
    {
        return $this->hasMany('App\ParkingContract');
    }
}
