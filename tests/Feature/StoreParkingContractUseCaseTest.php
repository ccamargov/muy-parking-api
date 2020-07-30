<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\ParkingContract;
use App\Vehicle;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class StoreParkingContractUseCaseTest extends TestCase {

    private const API_TOKEN = 's2tUUqrD9iIUkrL9TNPrrUKtLTmSNUjZGnbz9SFvxMM25qARRAAONHs8IgDs';
    private const PLATE_NUMBER = 'XPQkME';

    public $paramsToSend = [
        'api_token' => self::API_TOKEN,
        'owner_id' => '123456',
        'vehicle_id' => self::PLATE_NUMBER,
        'plan_id' => 2,
        'start_date_plan' => '2020-07-30 02:04:08',
        'finish_date_plan' => '2020-10-30 02:04:08'
    ];

    /**
     * Check the response of the use case when the vehicle was not send in the request.
     *
     * @return void
     */
    public function testApiWithNotBodyDataParam() {
        $response = $this->json('POST', 'api/v1/parking-contract', ['api_token' => self::API_TOKEN]);
        $response->assertStatus(422);
    }

    /**
     * Check the response of the use case when the vehicle has already an active ParkingContract.
     *
     * @return void
     */
    public function testApiWithVehicleThatHasAlreadyParkingContract() {
        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->shouldReceive('getCountOfContractsActiveByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn(3);
        app()->instance(ParkingContract::class, $parkingContract);

        $response = $this->call('POST', 'api/v1/parking-contract', $this->paramsToSend);
        $response->assertStatus(409);
    }

    /**
     * Verify the response of the use case when the vehicle does not have an active contract,
     * but the parameters sent are corrupt (They do not exist in the corresponding tables by id).
     *
     * @return void
     */
    public function testApiWithVehicleWithoutActiveParkingContractWithCorruptData() {
        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->shouldReceive('getCountOfContractsActiveByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn(0);
        app()->instance(ParkingContract::class, $parkingContract);

        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn(null);
        app()->instance(Vehicle::class, $vehicle);

        $response = $this->call('POST', 'api/v1/parking-contract', $this->paramsToSend);
        $response->assertStatus(400);
    }

}