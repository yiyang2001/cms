<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{

    public function showTopUpForm()
    {
        return view('wallet.top-up-form');
    }

    public function handleTopUp(Request $request)
    {
        $selectedPriceId = $request->input('priceId'); // Get the amount from the request
        $user = $request->user(); // Assuming you're using Laravel's authentication
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $selectedPriceId,
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.top-up.success'),
                'cancel_url' => route('stripe.top-up.cancel'),
            ]);

            $paymentIntentId = $checkout_session->payment_intent; // Retrieve payment intent ID

            return redirect($checkout_session->url);
            $paymentIntentId = $checkout_session->payment_intent; // Retrieve payment intent ID

            $payment = PaymentIntent::retrieve($paymentIntentId);

            if ($payment->status === 'succeeded') {
                $amount = $payment->amount / 100; // Convert amount from cents to dollars (or relevant currency)
                $user->deposit($amount); // Update the user's wallet balance after successful top-up
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function handlePaymentConfirmation(Request $request)
    {
        // Retrieve payment information from the query parameters
        $user = Auth::user();
        $success = $request->query('success');
        $paymentIntentId = $request->query('payment_intent');
        $amount = $request->query('amount');

        if ($success) {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $payment = PaymentIntent::retrieve($paymentIntentId);

                if ($payment->status === 'succeeded') {
                    $amount = $amount / 100; // Convert amount from cents to dollars (or relevant currency)
                    // Update the user's wallet balance after successful top-up
                    $user->deposit($amount);
                    // Perform any other necessary actions upon successful payment
                    return redirect()->route('payment.success');
                }
            } catch (\Exception $e) {
                return redirect()->route('payment.error')->with('error', $e->getMessage());
            }
        } else {
            // Handle payment cancellation or failure
            return redirect()->route('payment.cancel');
        }
    }

    // public function handlePaymentConfirmation(Request $request)
    // {
    //     // Retrieve payment information from the Stripe webhook payload or confirmation route
    //     $paymentIntentId = $request->input('payment_intent');

    //     try {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));

    //         // Retrieve payment details
    //         $payment = PaymentIntent::retrieve($paymentIntentId);

    //         if ($payment->status === 'succeeded') {
    //             $amount = $payment->amount / 100; // Convert amount from cents to dollars (or relevant currency)
    //             // Update the user's wallet balance after successful top-up
    //             // Assuming you have a method like deposit() in your User model to handle the wallet update
    //             $user = User::find($payment->metadata->user_id); // Assuming user_id is stored in metadata
    //             $user->deposit($amount);
    //         }

    //         // Respond with a success message or any necessary action
    //         return response()->json(['message' => 'Payment processed successfully']);
    //     } catch (\Exception $e) {
    //         // Handle exceptions or payment failure
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function createCheckoutSession(Request $request)
    {
        $amount = $request->input('amount') * 100; // Get the amount from the request and convert to cents
        $user = $request->user();

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'myr', // Replace with your currency
                            'product_data' => [
                                'name' => 'Wallet Top-Up',
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.top-up') . '?' . http_build_query(['success' => true]),
                'cancel_url' => route('stripe.top-up') . '?' . http_build_query(['success' => false]),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function paymentSuccess()
    {
        // Logic for handling successful payment
        return view('payment.success'); // Display a success page
    }

    public function paymentError()
    {
        // Logic for handling payment error
        return view('payment.error'); // Display an error page
    }

    public function paymentCancel()
    {
        // Logic for handling payment cancellation
        return view('payment.cancel'); // Display a cancellation page
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
