@extends('backend.layouts.app')
<script src="https://js.stripe.com/v3/"></script>
<style>
    .btn-radio input[type="radio"] {
        display: none;
        /* Hide the radio button */
    }

    .btn-radio.active {
        background-color: #007bff;
        /* Highlight color when selected */
        color: #fff;
        /* Text color when selected */
    }
</style>
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Top Up</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" id="current-page">Top Up</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
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
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="price_1OGScOK5fjUPDfEoTOnQM75S"
                                                class="btn btn-block btn-outline-secondary rounded-pill btn-radio">
                                                <input type="radio" name="priceId" id="price_1OGScOK5fjUPDfEoTOnQM75S"
                                                    value="price_1OGScOK5fjUPDfEoTOnQM75S" autocomplete="off">
                                                <i class="fas fa-coins"></i> RM10
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="price_1OGSiNK5fjUPDfEoXbJow8HE"
                                                class="btn btn-block btn-outline-secondary rounded-pill btn-radio">
                                                <input type="radio" name="priceId" id="price_1OGSiNK5fjUPDfEoXbJow8HE"
                                                    value="price_1OGSiNK5fjUPDfEoXbJow8HE" autocomplete="off">
                                                <i class="fas fa-coins"></i> RM20
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="price_1OGSijK5fjUPDfEopFaeIOZp"
                                                class="btn btn-block btn-outline-secondary rounded-pill btn-radio">
                                                <input type="radio" name="priceId" id="price_1OGSijK5fjUPDfEopFaeIOZp"
                                                    value="price_1OGSijK5fjUPDfEopFaeIOZp" autocomplete="off">
                                                <i class="fas fa-coins"></i> RM30
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="price_1OLbEYK5fjUPDfEoWIWMw4AI"
                                                class="btn btn-block btn-outline-secondary rounded-pill btn-radio">
                                                <input type="radio" name="priceId" id="price_1OLbEYK5fjUPDfEoWIWMw4AI"
                                                    value="price_1OLbEYK5fjUPDfEoWIWMw4AI" autocomplete="off">
                                                <i class="fas fa-coins"></i> RM50
                                            </label>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="price_1OLbElK5fjUPDfEosk36nGTd"
                                                class="btn btn-block btn-outline-secondary rounded-pill btn-radio">
                                                <input type="radio" name="priceId" id="price_1OLbElK5fjUPDfEosk36nGTd"
                                                    value="price_1OLbElK5fjUPDfEosk36nGTd" autocomplete="off">
                                                <i class="fas fa-coins"></i> RM100
                                            </label>
                                        </div>
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
        $(document).ready(function() {
            $('.btn-radio').click(function() {
                // Remove 'active' class from all labels
                $('.btn-radio').removeClass('active');
                // Add 'active' class only to the clicked label
                $(this).addClass('active');
                // Check the respective radio button
                $(this).find('input[type="radio"]').prop('checked', true);
            });
        });

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
