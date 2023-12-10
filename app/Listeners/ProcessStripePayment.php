<?php

namespace App\Listeners;

use App\Events\StripePaymentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessStripePayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StripePaymentReceived $event): void
    {
        $payload = $event->payload;

        // Handle the Stripe event payload here
        // Example: Access $payload['data'] to get the event data and process accordingly

        // Implement your logic to update the user's wallet, database, etc.
    }
}
