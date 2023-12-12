@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="card-title mb-0">Transfer Funds</h3>
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

                            <form method="POST" action="{{ route('wallet.transfer') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="recipient_email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Recipient Email') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" id="recipient" name="recipient"
                                            data-placeholder="Please select recipient..." style="width: 100%;">
                                            <option value="" selected disabled></option>
                                            @foreach ($userEmails as $id => $email)
                                                <option value="{{ $id }}">{{ $email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="amount"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>
                                    <div class="col-md-6">
                                        <input id="amount" type="number"
                                            class="form-control @error('amount') is-invalid @enderror" name="amount"
                                            required autocomplete="off">
                                        @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Transfer') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Transfer History Section -->
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-info text-white text-center">
                            <h3 class="card-title mb-0">Transfer History</h3>
                        </div>
                        <div class="card-body">
                            <table id="transferTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Transfer to</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transferHistory as $transfer)
                                        <tr>
                                            <td>{{ $transfer->email }}</td>
                                            <td>{{ $transfer->amount }}</td>
                                            <td>
                                                <span class="badge badge-success">{{ ucfirst($transfer->transfer_status) }}</span>
                                            </td>
                                            <td>{{ $transfer->transfer_created_at }}</td>
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
            $('#transferTable').DataTable(
                {
                    "order": [[ 3, "desc" ]]
                }
            );

            $('#recipient').select2({
                placeholder: 'Select User Email',
            });
        });
    </script>
@endsection
