<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Owner;
use App\Vehicle;

class ParkingContractResource extends JsonResource 
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner' => Owner::find($this->owner_id),
            'vehicle' => Vehicle::find($this->vehicle_id),
            'plan' => $this->plan,
            'start_date_plan' => $this->start_date_plan,
            'finish_date_plan' => $this->finish_date_plan
        ];
    }
}
