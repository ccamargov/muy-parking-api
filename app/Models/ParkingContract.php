<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingContract extends Model
{
    // Define the relation between ParkingContract and Owner. A ParkingContract belongs to Owner.
    public function owner()
    {
        return $this->belongsTo('App\Owner');
    }

    // Define the relation between ParkingContract and Vehicle. A ParkingContract has related a vehicle.
    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    // Define the relation between ParkingContract and Vehicle. A ParkingContract has related a plan.
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    // Define the relation between ParkingContract and Tickets. A ParkingContract has many Tickets related.
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * Find active contract related to vehicle (By plate number).
     *
     * @param  string  $plateNumber
     * @return Illuminate\Support\Collection
     */
    public static function findActiveContractByPlateId(string $plateNumber)
    {
        return ParkingContract::where('vehicle_id', $plateNumber)
            ->where('is_active', true)
            ->get()
            ->first();
    }

    /**
     * Find active contract related to vehicle (By plate number).
     *
     * @param  string  $plateNumber
     * @return int
     */
    public static function getCountOfContractsActiveByPlateId(string $plateNumber)
    {
        return ParkingContract::where('vehicle_id', $plateNumber)
            ->where('is_active', true)
            ->get()
            ->count();
    }

    /**
     * Find contracts related to vehicle (By plate number).
     *
     * @param  string  $plateNumber
     * @return Illuminate\Support\Collection
     */
    public static function findContractsIdsArrayByPlateId(string $plateNumber)
    {
        return ParkingContract::where('vehicle_id', $plateNumber)->pluck('id')->toArray();
    }
}
