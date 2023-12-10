<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook_secret'); // Get your endpoint's secret from config

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            // Other error handling
            Log::error('Stripe Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unexpected error'], 500);
        }

        Log::info('Stripe Webhook Success: ' . $event->id);
        // Handle successful payment events
        if ($event->type === 'checkout.session.completed') {
            $paymentIntent = $event->data->object; // Retrieve the payment intent or session object

            // Retrieve necessary data from $paymentIntent like amount, user ID, etc.
            $amount = $paymentIntent->amount_total / 100; // Convert amount from cents to dollars
            $userId = $paymentIntent->metadata->user_id; // Example: retrieve user ID from metadata

            // Update the user's wallet or account balance
            $user = User::find($userId);
            if ($user) {
                $user->deposit($amount); // Assuming 'deposit' method updates the user's wallet
            }

            Log::info($userId . ' wallet updated by ' . $amount . ' dollars');
            Log::info('Stripe Webhook: PaymentIntent succeeded');

            // Provide feedback to Stripe that the webhook was received
            return response()->json(['success' => true]);
        }

        // Respond with a 200 OK status to acknowledge receipt of the webhook
        return response()->json(['success' => true]);
    }

    // Show the top-up form view
    public function showTopUpForm()
    {
        $user = Auth::user();
        $walletBalance = $user->balance;
        $topUpHistory = $user->wallet->transactions()->where('type', 'deposit')->get();

        return view('wallet.top-up-form', ['walletBalance' => $walletBalance, 'topUpHistory' => $topUpHistory]);
    }

    // Handle the top-up request initiated by the user
    public function handleTopUp(Request $request)
    {
        $selectedPriceId = $request->input('priceId'); // Get the amount from the request
        $user = $request->user(); // Assuming you're using Laravel's authentication
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $selectedPriceId,
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'user_id' => $user->id,
                ],
                'success_url' => route('stripe.top-up.success'),
                'cancel_url' => route('stripe.top-up.cancel'),
            ]);

            return redirect($checkout_session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Handle successful top-up completion
    public function handleTopUpSuccess(Request $request)
    {
        // Redirect or display success message to the user
        return redirect()->route('stripe.top-up')->with('success', 'Payment successful. Wallet updated.');
    }

    // Handle canceled top-up
    public function handleTopUpCancel(Request $request)
    {
        // Handle payment cancellation
        return redirect()->route('stripe.top-up')->with('error', 'Payment cancelled.');
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

    public function withdraw()
    {
        $user = Auth::user();
        $walletBalance = $user->balance;
        $wallet = $user->wallet;
        $withdrawalRequests = WithdrawalRequest::where('user_id', $user->id)->get();
        return view('wallet.withdraw-form', ['walletBalance' => $walletBalance, 
        'wallet' => $wallet, 'withdrawalRequests' => $withdrawalRequests]);
    }

    public function handleWithdrawal(Request $request)
    {
        // Get the authenticated user's wallet
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return back()->with('error', 'Wallet not found for this user.');
        }

        // Get the withdrawal amount from the form input
        $withdrawalAmount = $request->input('amount');

        // Check if the withdrawal amount exceeds the available balance
        if ($withdrawalAmount > $wallet->balance) {
            return back()->with('error', 'Withdrawal amount exceeds available balance.');
        }

        // Create a withdrawal request record in the database
        WithdrawalRequest::create([
            'user_id' => Auth::id(),
            'amount' => $withdrawalAmount,
            'status' => 'pending', // Set status as pending for admin approval
        ]);

        // Update the wallet balance (subtract the withdrawal amount)
        $user->withdraw($withdrawalAmount);

        return back()->with('success', 'Withdrawal request submitted successfully.');
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
