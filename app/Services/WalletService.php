<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function addToWallet($user_id, $amount)
    {
        $wallet = Wallet::where('user_id', $user_id)->firstOrFail();
        $wallet->balance += $amount;
        $wallet->save();

        return $wallet;
    }

    public function deductFromWallet($user_id, $amount)
    {
        $wallet = Wallet::where('user_id', $user_id)->firstOrFail();

        if ($wallet->balance < $amount) {
            // Handle insufficient balance error
            return false;
        }

        $wallet->balance -= $amount;
        $wallet->save();

        return $wallet;
    }

    public function getWalletBalance($user_id)
    {
        $wallet = Wallet::where('user_id', $user_id)->firstOrFail();
        return $wallet->balance;
    }
}
?>