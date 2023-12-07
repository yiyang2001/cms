<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
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
