<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\ParkingContract;
use App\Vehicle;
use App\Ticket;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ListPendingBalanceTicketsUseCaseTest extends TestCase {

    private const API_TOKEN = 'f9xRfEujvTFWBJIybItPV9VxxAdErkxr7EAevVKzjscgIkJgC2fE6VA1n2Ye';
    private const PLATE_NUMBER = 'XPQkME';

    /**
     * Check the response of the use case when the request data was not send in the request.
     *
     * @return void
     */
    public function testApiWithNotBodyDataParam() {
        $response = $this->json('GET', 'api/v1/pending-balance', ['api_token' => self::API_TOKEN]);
        $response->assertStatus(422);
    }

    /**
     * Check the response of the use case when the vehicle does not exist.
     *
     * @return void
     */
    public function testApiWithNotRegisteredPlateNumber() {
        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn(null);
        app()->instance(Vehicle::class, $vehicle);

        $response = $this->call('GET', 'api/v1/pending-balance', ['api_token' => self::API_TOKEN, 'plate_number' => self::PLATE_NUMBER]);
        $response->assertStatus(404);
    }

    /**
     * Check the response of the use case when the vehicle without contracts
     *
     * @return void
     */
    public function testApiWithVehicleWhitoutContracts() {

        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->plate_number = self::PLATE_NUMBER;
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($vehicle);
        app()->instance(Vehicle::class, $vehicle);

        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->shouldReceive('findContractsIdsArrayByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn([]);
        app()->instance(ParkingContract::class, $parkingContract);

        $response = $this->call('GET', 'api/v1/pending-balance', [
            'api_token' => self::API_TOKEN,
            'plate_number' => self::PLATE_NUMBER,
        ]);
        $response->assertStatus(404);
    }

    /**
     * Verify the response of the use case when the vehicle have contracts without pending balances.
     *
     * @return void
     */
    public function testApiWithVehicleWhitoutPendingBalances() {

        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->plate_number = self::PLATE_NUMBER;
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($vehicle);
        app()->instance(Vehicle::class, $vehicle);

        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->shouldReceive('findContractsIdsArrayByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn([1, 2, 3]);
        app()->instance(ParkingContract::class, $parkingContract);

        $ticket = Mockery::mock('overload:App\Ticket');
        $ticket->shouldReceive('findTicketsWithPendingBalanceByContractsIds')
            ->with([1, 2, 3])
            ->once()
            ->andReturn(null);
        app()->instance(Ticket::class, $ticket);

        $response = $this->call('GET', 'api/v1/pending-balance', [
            'api_token' => self::API_TOKEN,
            'plate_number' => self::PLATE_NUMBER,
        ]);
    }

}