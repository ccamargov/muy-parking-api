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
    private const STORE_ENTRANCE_ERRORS = [
        'TICKET_ACTIVATED_WITHOUT_DEPARTURE' => 'Vehicle with active ticket without departure registration',
        'CONTRACT_NOT_FOUND' =>  'Inactive or non-existent contract for the vehicle registered with the plate: [%d]',
        'VEHICLE_NOT_FOUND' => 'Vehicle with plate: [%d] not found',
    ];

    private string $plateNumber;

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
                $activeTicketStamp = Ticket::findActiveTicketByParkingContract($parkingContract->id);
                if ($activeTicketStamp == null) {
                    $ticket = new Ticket;
                    $ticket->parking_contract_id = $parkingContract->id;
                    $ticket->entry_time = Carbon::now()->timestamp;
                    if ($ticket->save()) {
                        return new TicketResource($ticket);
                    }
                } else {
                    return response()->json(
                        ['error_msg' => self::STORE_ENTRANCE_ERRORS['TICKET_ACTIVATED_WITHOUT_DEPARTURE']],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    ['error_msg' => sprintf(self::STORE_ENTRANCE_ERRORS['CONTRACT_NOT_FOUND'], $this->plateNumber)],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            return response()->json(
                ['error_msg' => sprintf(self::STORE_ENTRANCE_ERRORS['VEHICLE_NOT_FOUND'], $this->plateNumber)],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}