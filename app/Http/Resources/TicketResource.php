<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource 
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
            'entry_time' => $this->entry_time,
            'exit_time' => $this->entry_time,
            'charge_paid' => $this->charge_paid,
            'exchange_value' => $this->exchange_value,
            'payment_time' => $this->payment_time,
            'total_stay_mins' => $this->total_stay_mins,
        ];
    }
}
