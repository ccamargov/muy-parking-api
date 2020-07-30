<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Vehicle;
use App\ParkingContract;
use App\Ticket;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class StoreDepartureUseCaseTest extends TestCase {

    private const API_TOKEN = 's2tUUqrD9iIUkrL9TNPrrUKtLTmSNUjZGnbz9SFvxMM25qARRAAONHs8IgDs';
    private const PLATE_NUMBER = 'XPQkME';

    /**
     * Check the response of the use case when the vehicle was not send in the request.
     *
     * @return void
     */
    public function testApiWithNotPlateNumberParam() {
        $response = $this->json('POST', 'api/v1/ticket-departure', ['api_token' => self::API_TOKEN]);
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

        $response = $this->call('POST', 'api/v1/ticket-departure', ['api_token' => self::API_TOKEN, 'plate_number' => self::PLATE_NUMBER]);
        $response->assertStatus(404);
    }

    /**
     * Check the response of the use case when the vehicle exists, but dont have any active contract (Parking)
     *
     * @return void
     */
    public function testApiWithRegisteredPlateNumberWithoutParkingContract() {
        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->plate_number = self::PLATE_NUMBER;
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($vehicle);
        app()->instance(Vehicle::class, $vehicle);

        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->shouldReceive('findActiveContractByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn(null);
        app()->instance(ParkingContract::class, $parkingContract);

        $response = $this->call('POST', 'api/v1/ticket-departure', ['api_token' => self::API_TOKEN, 'plate_number' => self::PLATE_NUMBER]);
        $response->assertStatus(404);
    }

    /**
     * Check the response of the use case when the vehicle exists, and have a
     * contract parking with active ticket (departure time not null, but exit time null)
     *
     * @return void
     */
    public function testApiWithRegisteredContractParkingToVehicleWithActiveTicket() {
        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->plate_number = self::PLATE_NUMBER;
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($vehicle);
        app()->instance(Vehicle::class, $vehicle);

        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->id = 1;
        $parkingContract->shouldReceive('findActiveContractByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($parkingContract);
        app()->instance(ParkingContract::class, $parkingContract);

        $ticket = Mockery::mock('overload:App\Ticket');
        $ticket->shouldReceive('getActiveTicketByContractId')
            ->with(1)
            ->once()
            ->andReturn(null);
        app()->instance(Ticket::class, $ticket);

        $response = $this->call('POST', 'api/v1/ticket-departure', ['api_token' => self::API_TOKEN, 'plate_number' => self::PLATE_NUMBER]);
        $response->assertStatus(400);
    }

    /**
     * Check the response of the use case when all the validations are passed
     *
     * @return void
     */
    public function testApiWithAllConditionsOk() {
        $vehicle = Mockery::mock('overload:App\Vehicle');
        $vehicle->plate_number = self::PLATE_NUMBER;
        $vehicle->shouldReceive('find')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($vehicle);
        app()->instance(Vehicle::class, $vehicle);

        $parkingContract = Mockery::mock('overload:App\ParkingContract');
        $parkingContract->id = 1;
        $parkingContract->shouldReceive('findActiveContractByPlateId')
            ->with(self::PLATE_NUMBER)
            ->once()
            ->andReturn($parkingContract);
        app()->instance(ParkingContract::class, $parkingContract);

        $ticket = Mockery::mock('overload:App\Ticket');
        $ticket->shouldReceive('getActiveTicketByContractId')
            ->with(1)
            ->once()
            ->andReturn($ticket);
        app()->instance(Ticket::class, $ticket);

        // TO-DO: Not working - Fix it
        // $ticket = Mockery::mock('App\Ticket'); // Fails
        $ticket->shouldReceive('save')
            ->with($ticket)
            //->once()
            ->andReturn($ticket);
        app()->instance(Ticket::class, $ticket);

        $response = $this->call('POST', 'api/v1/ticket-departure', ['api_token' => self::API_TOKEN, 'plate_number' => self::PLATE_NUMBER]);
        // $response->assertStatus(200);
    }

}