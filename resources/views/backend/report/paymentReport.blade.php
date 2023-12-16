@extends('backend.layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Payment Report</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i>TARUMT - Carpool Management System
                                        <small class="float-right">Date: {{ $transfer->created_at }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>TARUMT</strong><br>
                                        Ground Floor, Bangunan Tan Sri Khaw Kai Boh (Block A),<br>
                                        Jalan Genting Kelang, Setapak, <br>
                                        53300 Kuala Lumpur<br>
                                        Phone: 03-4145 0123<br>
                                        Email: info@tarc.edu.my.
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $transfer->name }}</strong><br>
                                        @php
                                            $addressParts = explode(',', $transfer->location);
                                            $lineCounter = 0;
                                            $totalParts = count($addressParts);
                                            foreach ($addressParts as $part) {
                                                echo trim($part);
                                                if (++$lineCounter < $totalParts) {
                                                    if ($lineCounter % 2 === 0) {
                                                        echo ',<br>';
                                                    } else {
                                                        echo ', ';
                                                    }
                                                }
                                            }
                                        @endphp
                                        <br>
                                        Phone: {{ $transfer->phone_no }}<br>
                                        Email: {{ $transfer->email }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #1000{{ $transfer->transfer_id }}</b><br>
                                    <br>
                                    <b>Payment ID:</b> {{ $transfer->transaction_id }}<br>
                                    {{-- <b>Payment Due:</b> 2/22/2014<br> --}}
                                    {{-- <b>Account:</b> 968-34567 --}}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                @if (isset($transfer->meta['meta']['from_name']) && isset($transfer->meta['meta']['to_name']))
                                                    <th>From Wallet</th>
                                                    <th>To Wallet</th>
                                                @else
                                                    <th>To Wallet</th>
                                                @endif
                                                <th>Serial#</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                @if (isset($transfer->meta['meta']['from_name']) && isset($transfer->meta['meta']['to_name']))
                                                    <td>{{ $transfer->meta['meta']['from_name'] }}</td>
                                                    <td>{{ $transfer->meta['meta']['to_name'] }}</td>
                                                @else
                                                    <td>{{ $transfer->name }}</td>
                                                @endif
                                                <td>{{ $transfer->transfer_uuid }}</td>
                                                <td>RM {{ number_format(round($transfer->amount, 2), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Payment Methods:</p>
                                    {{-- <img src="https://t3.gstatic.com/images?q=tbn:ANd9GcSJHbnfk81kA_5mIj81yhRy3R2LRx3S11OyMjC68QeONsOp5DXx" alt="Stripe"> --}}
                                    {{-- <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                                    <img src="../../dist/img/credit/american-express.png" alt="American Express">
                                    <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> --}}
                                    <i class="far fa-money-bill-alt nav-icon"></i> Stripe Wallet <br>
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        This payment is done via TARUMT Wallet.
                                        It will be deducted from your TARUMT Wallet.
                                        Payment is not refundable once it is done.
                                        Contact TARUMT Carpool management support team for more information.
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>RM {{ number_format(round($transfer->amount, 2), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (0%)</th>
                                                <td>RM 0</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>RM {{ number_format(round($transfer->amount, 2), 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            {{-- <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                            class="fas fa-print"></i> Print</a>
                                    <button type="button" class="btn btn-success float-right"><i
                                            class="far fa-credit-card"></i> Submit
                                        Payment
                                    </button>
                                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
                                </div>
                            </div> --}}
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
