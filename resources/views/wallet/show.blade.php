@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Wallets</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" id="current-page"></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-wallet mr-2"></i> My Wallets
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($userWallets->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($userWallets as $wallet)
                                        <li class="list-group-item">
                                            <a href="{{ route('wallet.show', $wallet->id) }}">
                                                <i class="fas fa-wallet mr-2"></i> {{ $wallet->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No wallets found.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="card-title mb-0">
                                @if ($selectedWallet)
                                    <i class="fas fa-wallet mr-2"></i> <span
                                        id="walletName">{{ $selectedWallet->name }}</span>
                                    {{-- <button class="btn btn-sm btn-link text-white" onclick="toggleEdit()">Edit</button> --}}
                                @else
                                    Your Wallet
                                @endif
                            </h3>
                        </div>
                        <div class="card-body">
                            @if (isset($wallet))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4><i class="fas fa-coins mr-2"></i> Current Balance: RM{{ $wallet->balance }}</h4>
                                    <div>
                                        <a href="{{ route('stripe.top-up') }}" class="btn btn-success mr-2"><i
                                                class="fas fa-arrow-up mr-1"></i>
                                            Top Up</a>
                                        <a href="{{ route('stripe.withdraw') }}" class="btn btn-danger"><i
                                                class="fas fa-arrow-down mr-1"></i>
                                            Withdraw</a>
                                    </div>
                                </div>
                                <hr>
                                <!-- Transaction history -->
                                <h4>Transaction History</h4>
                                <table id="transactionTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <!-- Add more columns if needed -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                <td class="text-muted" data-sort="{{ $transaction->created_at }}">
                                                    {{ $transaction->created_at->format('d M y h:ia') }}
                                                </td>
                                                @if ($transaction->type == 'deposit')
                                                    <td class="text-success">{{ ucfirst($transaction->type) }}</td>
                                                @elseif($transaction->type == 'withdraw')
                                                    <td class="text-danger">{{ ucfirst($transaction->type) }}</td>
                                                @else
                                                    <td>{{ $transaction->type }}</td>
                                                @endif
                                                @if (isset($transaction->meta))
                                                    @if (isset($transaction->meta['meta']['to_id']))
                                                        @if ($transaction->meta['meta']['to_id'] == auth()->user()->id)
                                                            <td> Received from
                                                                {{ $transaction->meta['meta']['from'] }}
                                                            </td>
                                                        @else
                                                            <td>{{ $transaction->meta['meta']['description'] }}</td>
                                                        @endif
                                                    @endif
                                                @else
                                                    <td class="text-center">-</td>
                                                @endif
                                                @if ($transaction->amount < 0)
                                                    <td class="text-danger">- RM
                                                        {{ number_format(abs($transaction->amount), 2) }}</td>
                                                @else
                                                    <td class="text-primary">+ RM
                                                        {{ number_format($transaction->amount, 2) }}</td>
                                                @endif
                                                <!-- Add more columns and transaction data as needed -->
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No transactions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @else
                                <p>No wallet found for this user.</p>
                                <p>Please top up to create a wallet.</p>
                                <a href="{{ route('stripe.top-up') }}" class="btn btn-success"><i
                                        class="fas fa-arrow-up mr-1"></i>
                                    Top Up</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#transactionTable").DataTable({
                "columnDefs": [{
                    "targets": 0, // Targets the first column
                    "type": "date-eu" // Use "date-eu" type for correct date sorting
                }],
                "order": [
                    [0, "desc"]
                ]
            });
        });

        $(document).ready(function() {
            // Assuming 'userWallets' is passed from the controller containing user wallets collection
            @if ($userWallets->isNotEmpty())
                var firstWalletId = {{ $userWallets->first()->id }};
                $('a[href="{{ route('wallet.show', '') }}' + firstWalletId + '"]').addClass('active');
            @endif
        });
    </script>
@endsection
