<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Transfer;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function addFundsToWallet($user_id, $amount)
    {
        $this->walletService->addToWallet($user_id, $amount);
        // Additional logic or response
    }

    public function deductFundsFromWallet($user_id, $amount)
    {
        $this->walletService->deductFromWallet($user_id, $amount);
        // Additional logic or response
    }

    public function getWalletBalance($user_id)
    {
        $balance = $this->walletService->getWalletBalance($user_id);
        // Return or use the balance
    }


    public function showWallet()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve all wallets of the user
        $userWallets = $user->wallets()->get();

        // Fetch information for the first wallet by default
        $selectedWallet = $userWallets->first();

        // Retrieve the user's wallet details
        $wallet = $user->wallet; // Assuming the relationship exists between User and Wallet models

        // Fetch transaction history for the selected wallet
        $transactions = $selectedWallet ? $selectedWallet->transactions()->latest()->paginate(10) : collect();

        return view('wallet.show', compact('userWallets', 'selectedWallet', 'transactions'));
    }

    public function transfer()
    {
        // Get the authenticated user
        $user = auth()->user();
        $wallet = $user->wallet;

        $transferHistory = Transfer::where('from_id', $wallet->id)
            ->join('transactions', 'transactions.id', '=', 'transfers.deposit_id')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->get();


        $userEmails = User::where('id', '!=', $user->id)->pluck('email', 'id');
        return view('wallet.transfer', compact('transferHistory', 'userEmails'));
    }

    public function handleTransfer(Request $request)
    {
        $user = auth()->user();

        // Get the recipient user and perform the transfer
        $recipient = User::find($request->recipient);
        if (!$recipient) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Recipient not found.'], 404);
            }
            return redirect()->route('wallet.transfer')->with('error', 'Recipient not found.');
        }

        $amount = (float) $request->input('amount');

        try {
            $user->transfer($recipient, $amount); // Transfer funds to recipient

            if ($request->ajax()) {
                return response()->json(['success' => 'Transfer successful.'], 200);
            }
            return redirect()->route('wallet.transfer')->with('success', 'Transfer successful.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Transfer failed: ' . $e->getMessage()], 500);
            }
            return redirect()->route('wallet.transfer')->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    public function withdrawalRequest(){
        $withdrawalRequests = WithdrawalRequest::where('status', 'pending')->get();
        $withdrawalRequestsHistory = WithdrawalRequest::whereIn('status', ['approved','rejected'])->get();

        return view('wallet.withdrawalRequest', ['withdrawalRequests' => $withdrawalRequests, 'withdrawalRequestsHistory' => $withdrawalRequestsHistory]);
    }

    public function approveWithdrawalRequest($id){
        $withdrawalRequest = WithdrawalRequest::find($id);
        $withdrawalRequest->status = 'approved';
        $withdrawalRequest->save();

        return response()->json(['message' => 'Request from '. $withdrawalRequest->user->email .' approved successfully']);
    }

    public function rejectWithdrawalRequest($id){
        $withdrawalRequest = WithdrawalRequest::find($id);
        $withdrawalRequest->status = 'rejected';
        $withdrawalRequest->save();

        return response()->json(['message' => 'Request rejected successfully']);
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
