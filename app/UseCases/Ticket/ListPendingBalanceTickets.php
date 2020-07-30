<?php

namespace App\UseCases;
use App\Vehicle;
use App\ParkingContract;
use App\Ticket;
use App\Plan;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Collection;

final class ListPendingBalanceTickets
{
    private const CONTRACT_NOT_FOUND_ERR_MSG = 'Non contracts found for the vehicle registered with the plate: [%s].';
    private const VEHICLE_NOT_FOUND_ERR_MSG = 'Vehicle with plate: [%s] not found.';
    private const NOT_TICKETS_FOUND_WITH_PENDING_BALANCE = 'The vehicle with plate: [%s] has not pending balance.';

    private $plateNumber;

    public function __construct(string $plateFilter) {
        $this->plateNumber = $plateFilter;
    }

    public function execute()
    {
        // Validate if the vehicle is registered.
        $vehicle = Vehicle::find($this->plateNumber);
        if ($vehicle != null) {
            // Validate if the vehicle has a active contract.
            $parkingContractsIds = ParkingContract::findContractsIdsArrayByPlateId($vehicle->plate_number);
            if (count($parkingContractsIds) > 0) {
                $ticketsResult = Ticket::findTicketsWithPendingBalanceByContractsIds($parkingContractsIds);
                if (count($ticketsResult) > 0) {
                    $this->updateTicketsUpdatedWithCharge($ticketsResult);
                    return TicketResource::collection($ticketsResult);
                } else {
                    return response()->json(
                        ['error_msg' => sprintf(self::NOT_TICKETS_FOUND_WITH_PENDING_BALANCE, $this->plateNumber)],
                        Response::HTTP_NOT_FOUND
                    );
                }
            } else {
                return response()->json(
                    ['error_msg' => sprintf(self::CONTRACT_NOT_FOUND_ERR_MSG, $this->plateNumber)],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            return response()->json(
                ['error_msg' => sprintf(self::VEHICLE_NOT_FOUND_ERR_MSG, $this->plateNumber)],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * This function update ticket data, with the calculation of total minutes in parking,
     * and the total charge for the payment.
     *
     * @return void
     */
    private function updateTicketsUpdatedWithCharge($tickets)
    {
        foreach ($tickets as $ticketItem) {
            $parkingContract = ParkingContract::find($ticketItem->parking_contract_id);
            $plan = Plan::find($parkingContract->plan_id);

            $diffMins = strtotime($ticketItem->exit_time) - strtotime($ticketItem->entry_time);

            if ($plan->has_daily_payment) {
                $ticketItem->charge_to_pay =
                    $plan->daily_payment_charge *  $diffMins;
            } elseif ($plan->has_monthly_dynamic_payment) { // Assume that the owner has 1 ticket per month.
                $ticketItem->charge_to_pay =
                    $plan->monthly_dynamic_payment_charge *  $diffMins;
            } elseif ($plan->has_monthly_static_payment) { // Assume that the owner has 1 ticket per month.
                $ticketItem->charge_to_pay = $plan->monthly_static_payment_charge;
            }
            $ticketItem->total_stay_mins = $diffMins;
            $ticketItem->save();
        }
    }
}