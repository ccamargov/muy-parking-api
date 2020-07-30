<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Ticket;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PayTicketUseCaseTest extends TestCase {

    private const API_TOKEN = 'f9xRfEujvTFWBJIybItPV9VxxAdErkxr7EAevVKzjscgIkJgC2fE6VA1n2Ye';
    private const PAYMENT_REFERENCE = 1;
    private const AMMOUNT_TO_PAY = 10;

    /**
     * Check the response of the use case when the request data was not send in the request.
     *
     * @return void
     */
    public function testApiWithNotBodyDataParam() {
        $response = $this->json('PUT', 'api/v1/ticket-payment', ['api_token' => self::API_TOKEN]);
        $response->assertStatus(422);
    }

    /**
     * Check the response of the use case when the payment reference does not exists.
     *
     * @return void
     */
    public function testApiWithNotRegisteredPaymentReference() {
        $ticket = Mockery::mock('overload:App\Ticket');
        $ticket->shouldReceive('find')
            ->with(self::PAYMENT_REFERENCE)
            ->once()
            ->andReturn(null);
        app()->instance(Ticket::class, $ticket);

        $response = $this->call('PUT', 'api/v1/ticket-payment', [
            'api_token' => self::API_TOKEN,
            'payment_reference' => self::PAYMENT_REFERENCE,
            'owner_ammount' => self::AMMOUNT_TO_PAY
        ]);
        $response->assertStatus(404);
    }

    /**
     * Check the response of the use case when the payment reference has already been settled.
     *
     * @return void
     */
    public function testApiWithPaymentReferenceSettled() {
        $ticket = Mockery::mock('overload:App\Ticket');
        $ticket->charge_paid = 1;
        $ticket->shouldReceive('find')
            ->with(self::PAYMENT_REFERENCE)
            ->once()
            ->andReturn($ticket);
        app()->instance(Ticket::class, $ticket);

        $response = $this->call('PUT', 'api/v1/ticket-payment', [
            'api_token' => self::API_TOKEN,
            'payment_reference' => self::PAYMENT_REFERENCE,
            'owner_ammount' => self::AMMOUNT_TO_PAY
        ]);
        $response->assertStatus(409);
    }
}