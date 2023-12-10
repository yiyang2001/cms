@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="card-title mb-0">Withdraw Funds</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display any success or error messages -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Display current balance available for withdrawal -->
                            <div class="mb-3">
                                @if ($wallet)
                                    <p><strong>Available Balance for Withdrawal: RM{{ $wallet->balance }}</strong></p>
                                @else
                                    <p>No wallet found for this user.</p>
                                @endif
                            </div>

                            <!-- Withdrawal form -->
                            <form action="{{ route('stripe.withdraw') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="amount">Withdrawal Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block rounded-pill">Withdraw</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Withdrawal Request History Section -->
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-info text-white text-center">
                            <h3 class="card-title mb-0">Withdrawal Request History</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display withdrawal request history as a table -->
                            <table id="transactionTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <!-- Add more columns if needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawalRequests as $request)
                                        <tr>
                                            <td>RM{{ $request->amount }}</td>
                                            <td>
                                                @if ($request->status == 'approved')
                                                    <span class="badge badge-success">{{ ucfirst($request->status) }}</span>
                                                @elseif ($request->status == 'pending')
                                                    <span class="badge badge-warning">{{ ucfirst($request->status) }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ ucfirst($request->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->created_at }}</td>
                                            <!-- Display more columns or information -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#transactionTable').DataTable(
            );
        });
    </script>
@endsection
