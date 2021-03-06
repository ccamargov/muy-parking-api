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
            'payment_reference' => $this->id,
            'entry_time' => $this->entry_time,
            'exit_time' => $this->exit_time,
            'charge_to_pay' => $this->charge_to_pay,
            'charge_paid' => $this->charge_paid,
            'exchange_value' => $this->exchange_value,
            'payment_time' => $this->payment_time,
            'total_stay_mins' => $this->total_stay_mins,
        ];
    }
}
