<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Transfer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function paymentReport($id)
    {
        $transfer = Transfer::find($id);

        if ($transfer === null) {
            return redirect()->back()->with('error', 'Transfer not found');
        }
        $transfer = Transfer::select('transfers.*', 'transactions.*', 'users.*', 
        'transfers.id as transfer_id', 'transactions.id as transaction_id',
        'transfers.status as transfer_status', 'transfers.created_at as transfer_created_at',
        'transfers.uuid as transfer_uuid', 'transactions.uuid as transaction_uuid')
            ->join('transactions', 'transactions.id', '=', 'transfers.deposit_id')
            ->join('users', 'users.id', '=', 'transactions.payable_id')
            ->where('transfers.id', $id)
            ->first();

        if ($transfer !== null && isset($transfer->meta)) {
            $transfer->meta = json_decode($transfer->meta, true);
        }


        // dd($transfer);

        return view('backend.report.paymentReport', compact('transfer'));
    }
}
