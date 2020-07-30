<?php

namespace App\UseCases;
use App\Vehicle;
use App\ParkingContract;
use App\Ticket;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TicketResource;

final class StoreDepartureTicket
{
    private const TICKET_ACTIVE_NOT_FOUND = 'The vehicle with plates [%s] does not have a ticket with a registered entry in the system.';
    private const CONTRACT_NOT_FOUND_ERR_MSG = 'Inactive or non-existent contract for the vehicle registered with the plate: [%s].';
    private const VEHICLE_NOT_FOUND_ERR_MSG = 'Vehicle with plate: [%s] not found.';

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
            $parkingContract = ParkingContract::findActiveContractByPlateId($vehicle->plate_number);
            if ($parkingContract != null) {
                // Get active ticket to update data.
                $activeTicket = Ticket::getActiveTicketByContractId($parkingContract->id);
                if ($activeTicket) {
                    $activeTicket->exit_time = Carbon::now();
                    if ($activeTicket->save()) {
                        return new TicketResource($activeTicket);
                    }
                } else {
                    return response()->json(
                        ['error_msg' => sprintf(self::TICKET_ACTIVE_NOT_FOUND, $this->plateNumber)],
                        Response::HTTP_BAD_REQUEST
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
}