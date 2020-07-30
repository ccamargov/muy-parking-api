<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Encapsulate APIs to validate access whit api_key from users table.
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    // Define route of API to: UseCase: Store entrance ticket in parking system
    Route::post('ticket-entrance', 'TicketController@storeEntrance')->name('ticket.entrance');
    // Define route of API to: UseCase: Store exit time to ticket in parking system
    Route::post('ticket-departure', 'TicketController@storeDeparture')->name('ticket.departure');
    // Define route of API to: UseCase: Obtains the list of outstanding balances payable, from the plate number.
    Route::get('pending-balance', 'TicketController@getTicketsWithPendingBalance')->name('ticket.pending_balance');
    // Define route of API to: UseCase: Create a new Parking Contract for Owner, Vehicle and Plan.
    Route::post('parking-contract', 'ParkingContractController@createContract')->name('parking.contract');
});