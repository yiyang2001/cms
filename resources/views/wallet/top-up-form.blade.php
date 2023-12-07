@extends('backend.layouts.app')
<script src="https://js.stripe.com/v3/"></script>
@section('content')
    <div class="content-wrapper" style="height:auto;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Wallet</h1>
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
            <div class="container-fluid">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Top-Up Your Wallet</h3>
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

                            <form action="{{ route('stripe.top-up.submit') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Choose an amount:</label><br>
                                    <button type="button" class="btn btn-primary mr-2"
                                        onclick="setAmount('price_1OGScOK5fjUPDfEoTOnQM75S')">RM10</button>
                                    <button type="button" class="btn btn-primary mr-2"
                                        onclick="setAmount('price_1OGSiNK5fjUPDfEoXbJow8HE')">RM20</button>
                                    <button type="button" class="btn btn-primary mr-2"
                                        onclick="setAmount('price_1OGSijK5fjUPDfEopFaeIOZp')">RM30</button>
                                </div>
                                <input type="hidden" name="priceId" id="priceId" value="price_1OGScOK5fjUPDfEoTOnQM75S">
                                <button type="submit" class="btn btn-primary">Top Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAmount(priceId) {
            document.getElementById('priceId').value = priceId;
            document.getElementById('stripeForm').submit();
        }
    </script>
@endsection
