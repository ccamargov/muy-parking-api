<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\User;
use App\Vehicle;
use App\Owner;
use App\Plan;
use App\ParkingContract;

class DatabaseTest extends TestCase {

    /**
     * Check that all Models are correctly configured.
     *
     * @return void
     */
    public function testModelsTables() {
        $this->assertTrue(User::all() != null);
        $this->assertTrue(Vehicle::all() != null);
        $this->assertTrue(Owner::all() != null);
        $this->assertTrue(ParkingContract::all() != null);
    }

}