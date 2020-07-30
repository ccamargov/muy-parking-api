<?php

namespace App\UseCases;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Resources\ParkingContractResource;
Use App\ParkingContract;
Use App\Owner;
Use App\Vehicle;
Use App\Plan;

final class StoreParkingContract
{
    private const VEHICLE_ALREADY_HAS_ACTIVE_CONTRACT_ERR_MSG = 'The vehicle with plates [%s] already has an assigned active contract.';
    private const INVIDALID_FOREIGN_KEYS_DATA = 'The data related to vehicle,'
        . ' owner or plan, are invalid (One of these records does not exist in the system). Please validate.';

    private $requestData;

    public function __construct(Request $requestData) {
        $this->requestData = $requestData;
    }

    public function execute()
    {
        // Check if the vehicle has a active ParkingContract.
        $numOfContractsActive = ParkingContract::getCountOfContractsActiveByPlateId($this->requestData->input('vehicle_id'));
        if ($numOfContractsActive > 0) {
            return response()->json(
                ['error_msg' => sprintf(self::VEHICLE_ALREADY_HAS_ACTIVE_CONTRACT_ERR_MSG, $this->requestData->input('vehicle_id'))],
                Response::HTTP_CONFLICT
            );
        }
        // Validate records in the others models
        $ownerEntity = Owner::find($this->requestData->input('owner_id'));
        $vehicleEntity = Vehicle::find($this->requestData->input('vehicle_id'));
        $planEntity = Plan::find($this->requestData->input('plan_id'));

        if (!$ownerEntity || !$vehicleEntity || !$planEntity) {
            return response()->json(
                ['error_msg' => self::INVIDALID_FOREIGN_KEYS_DATA],
                Response::HTTP_BAD_REQUEST
            );
        }

        // IF all its OK, create the contract and response with the object.
        $parkingContract = new ParkingContract;
        $parkingContract->owner_id = $this->requestData->input('owner_id');
        $parkingContract->vehicle_id = $this->requestData->input('vehicle_id');
        $parkingContract->plan_id = $this->requestData->input('plan_id');
        $parkingContract->start_date_plan = $this->requestData->input('start_date_plan');
        $parkingContract->finish_date_plan = $this->requestData->input('finish_date_plan');

        if ($parkingContract->save()) {
            return new ParkingContractResource($parkingContract);
        }
    }
}