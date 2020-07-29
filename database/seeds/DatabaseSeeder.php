<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Vehicle;
use App\Owner;
use App\Plan;
use App\ParkingContract;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Default values
        $def_records_to_inser = 25;
        $pivot_parking_contract_tbl = 'parking_contracts';

        // Filling Vehicles table.
        if ($this->emptyRecords(Vehicle::count())) {
            echo 'Inserting dummy data for Vehicle model...\n';
            factory(Vehicle::class, $def_records_to_inser)->create();
        }

        // Filling Owners table.
        if ($this->emptyRecords(Owner::count())) {
            echo 'Inserting dummy data for Owner model...\n';
            factory(Owner::class, $def_records_to_inser)->create();
        }

        // Filling Plans table.
        if ($this->emptyRecords(Plan::count())) {
            echo 'Inserting dummy data for Plan model...\n';
            factory(Plan::class, $def_records_to_inser)->create();
        }

        // Filling user table to get api_key
        if ($this->emptyRecords(User::count())) {
            echo 'Inserting dummy data for Users model...\n';
            factory(User::class, $def_records_to_inser)->create();
        }

        // Filling ParkingContract table. Dependencies: Vehicle, Owner, Plan.
        if (!$this->emptyRecords(Vehicle::count()) && !$this->emptyRecords(Owner::count()) &&
            !$this->emptyRecords(Plan::count()) && $this->emptyRecords(ParkingContract::count())) {
            $vehicles_collection = Vehicle::all();
            $owners_collection = Owner::all();
            $plans_collection = Plan::all();
            echo 'Inserting dummy data for ParkingContract pivot model...\n';
            for ($i = 0; $i <= $def_records_to_inser; $i++) {
                // Adding providers tho random product.
                factory(ParkingContract::class, $def_records_to_inser)->create();
            }
        }
    }

    // Function to validate empty records from ammount.
    private function emptyRecords($count) {
        return $count <= 0;
    }
}
