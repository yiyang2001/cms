@extends('backend.layouts.app')
<script src="https://js.stripe.com/v3/"></script>
@section('content')
    <div class="content-wrapper">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="card-title mb-0">Top-Up Your Wallet</h3>
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

                            @if (isset($walletBalance))
                                <div class="mb-3">
                                    <p>Your Current Wallet Balance: RM {{ $walletBalance }}</p>
                                </div>
                            @endif

                            <form action="{{ route('stripe.top-up.submit') }}" method="post" id="stripeForm">
                                @csrf
                                <div class="form-group">
                                    <div class="d-flex flex-column">
                                        <label class="btn btn-outline-primary rounded-pill mb-2">
                                            <input type="radio" name="priceId" value="price_1OGScOK5fjUPDfEoTOnQM75S"
                                                autocomplete="off">
                                            RM10
                                        </label>
                                        <label class="btn btn-outline-primary rounded-pill mb-2">
                                            <input type="radio" name="priceId" value="price_1OGSiNK5fjUPDfEoXbJow8HE"
                                                autocomplete="off">
                                            RM20
                                        </label>
                                        <label class="btn btn-outline-primary rounded-pill mb-2">
                                            <input type="radio" name="priceId" value="price_1OGSijK5fjUPDfEopFaeIOZp"
                                                autocomplete="off">
                                            RM30
                                        </label>
                                        <!-- Additional options can be added similarly -->
                                    </div>
                                </div>
                                <button type="button" onclick="submitStripeForm()"
                                    class="btn btn-success btn-block rounded-pill">Top Up</button>
                            </form>
                        </div>
                    </div>
                </div>
                                <!-- Top-Up History Section -->
                <div class="col-md-5">
                    <div class="card shadow-lg">
                        <div class="card-header bg-info text-white text-center">
                            <h3 class="card-title mb-0">Top-Up History</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display top-up history as a table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <!-- Add more columns if needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topUpHistory as $topUp)
                                        <tr>
                                            <td>{{ $topUp->created_at }}</td>
                                            <td>RM{{ $topUp->amount }}</td>
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
        function submitStripeForm() {
            var selectedPrice = document.querySelector('input[name="priceId"]:checked');
            if (selectedPrice) {
                document.getElementById('stripeForm').submit();
            } else {
                alert('Please select a top-up amount.');
            }
        }
    </script>
@endsection
