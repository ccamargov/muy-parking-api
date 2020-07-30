<?php

namespace App\UseCases;
use App\Vehicle;
use App\ParkingContract;
use App\Ticket;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TicketResource;

final class StoreEntranceTicket
{
    private const TICKET_ACTIVATED_WITHOUT_DEPARTURE_ERR_MSG = 'Vehicle with active ticket without departure registration.';
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
                // Validate if exists o not a active ticket without departure data.
                $anyActiveTicketByContract = Ticket::hasActiveTicketByParkingContract($parkingContract->id);
                if (!$anyActiveTicketByContract) {
                    $ticket = new Ticket;
                    $ticket->parking_contract_id = $parkingContract->id;
                    $ticket->entry_time = Carbon::now();
                    if ($ticket->save()) {
                        return new TicketResource($ticket);
                    }
                } else {
                    return response()->json(
                        ['error_msg' => self::TICKET_ACTIVATED_WITHOUT_DEPARTURE_ERR_MSG],
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