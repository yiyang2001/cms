@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container py-5">
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
                            @if ($wallet)
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4><i class="fas fa-coins mr-2"></i> Current Balance: RM{{ $wallet->balance }}</h4>
                                    <div>
                                        <a href="{{ route('stripe.top-up') }}" class="btn btn-success mr-2"><i class="fas fa-arrow-up mr-1"></i>
                                            Top Up</a>
                                        <a href="{{ route('stripe.withdraw') }}" class="btn btn-danger"><i class="fas fa-arrow-down mr-1"></i>
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
                                            <th>Amount</th>
                                            <!-- Add more columns if needed -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->type }}</td>
                                                <td>{{ $transaction->amount }}</td>
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
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "excel", "pdf", "print", "colvis"],
                "rowCallback": function(row, data) {
                    // Check the status column for "pending"
                    if (data.status == "pending") {
                        $(row).addClass('pending-row');
                    }
                }
            }).buttons().container().appendTo('#passengers-table_wrapper .col-md-6:eq(0)');
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
