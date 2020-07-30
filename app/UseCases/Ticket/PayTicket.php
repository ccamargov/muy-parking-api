<?php

namespace App\UseCases;
use App\Ticket;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Collection;

final class PayTicket
{
    private const PAYMENT_REFERENCE_NOT_FOUND = 'Payment reference [%s] not found.';
    private const PAYMENT_REFERENCE_ALREADY_PAID = 'The ticket with payment reference [%s] is already settled.';

    private $paymentReference; // Same id field in model
    private $ammountToPay;

    public function __construct(string $paymentReference, float $ammountToPay) {
        $this->paymentReference = $paymentReference;
        $this->ammountToPay = $ammountToPay;
    }

    public function execute()
    {
        // Validate if the payment reference is registered.
        $ticket = Ticket::find($this->paymentReference);
        if ($ticket != null) {
            if (!$ticket->charge_paid) {
                $ticket->charge_paid = $this->ammountToPay;
                // TO-DO Implement exchange validation with plan conditions.
                $ticket->payment_time = Carbon::now();
                if ($ticket->save()) {
                    return new TicketResource($ticket);
                }
            } else {
                return response()->json(
                    ['error_msg' => sprintf(self::PAYMENT_REFERENCE_ALREADY_PAID, $this->paymentReference)],
                    Response::HTTP_CONFLICT
                );
            }
        } else {
            return response()->json(
                ['error_msg' => sprintf(self::PAYMENT_REFERENCE_NOT_FOUND, $this->paymentReference)],
                Response::HTTP_NOT_FOUND
            );
        }
    }

}