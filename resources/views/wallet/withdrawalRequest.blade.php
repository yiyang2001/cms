@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Withdrawal Request</h1>
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

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-7">
                        <div class="card shadow-lg">
                            <div class="card-header ">
                                <h3 class="card-title mb-0">Withdrawal Requests</h3>
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

                                <div class="table-responsive">
                                    <table id="withdrawalTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Applicant</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($withdrawalRequests as $request)
                                                <tr>
                                                    <td>{{ $request->user->email }}</td>
                                                    <td>{{ $request->amount }}</td>
                                                    <td>
                                                        @if ($request->status == 'pending')
                                                            <span
                                                                class="badge badge-info">{{ ucfirst($request->status) }}</span>
                                                        @elseif ($request->status == 'approved')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($request->status) }}</span>
                                                        @elseif ($request->status == 'rejected')
                                                            <span
                                                                class="badge badge-danger">{{ ucfirst($request->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $request->created_at }}</td>
                                                    <td>
                                                        <button type="button" class="btn-sm btn-success approve-request"
                                                            data-request-id="{{ $request->id }}">
                                                            <i class="fas fa-user-check"></i> Approve
                                                        </button>
                                                        <button type="button" class="btn-sm btn-danger reject-request"
                                                            data-request-id="{{ $request->id }}">
                                                            <i class="far fa-times-circle"></i> Reject
                                                        </button>

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow-lg">
                            <div class="card-header bg-info text-white text-center">
                                <h3 class="card-title mb-0">Withdrawal Request History</h3>
                            </div>
                            <div class="card-body">
                                <table id="withdrawalTable2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Applicant</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawalRequestsHistory as $request)
                                            <tr>
                                                <td>{{ $request->user->email }}</td>
                                                <td>{{ $request->amount }}</td>
                                                <td>
                                                    @if ($request->status == 'pending')
                                                        <span
                                                            class="badge badge-info">{{ ucfirst($request->status) }}</span>
                                                    @elseif ($request->status == 'approved')
                                                        <span
                                                            class="badge badge-success">{{ ucfirst($request->status) }}</span>
                                                    @elseif ($request->status == 'rejected')
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($request->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $request->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <span id="countdown"></span>

    <script>
        $(document).ready(function() {
            $('#withdrawalTable').DataTable();
            $('#withdrawalTable2').DataTable();

            $('.approve-request').click(function() {
                const requestId = $(this).data('request-id');
                approveRequest(requestId);
            });

            $('.reject-request').click(function() {
                const requestId = $(this).data('request-id');
                rejectRequest(requestId);
            });

            function approveRequest(requestId) {
                $.ajax({
                    method: 'POST',
                    url: '/wallet/withdrawalRequest/approve/' + requestId,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Request Approved');
                        toastr.success(response.message);
                        toastr.info('Refresh page in <span id="countdown">3</span> seconds');

                        var countdownElement = document.getElementById('countdown');
                        var countdown = 3;

                        var countdownInterval = setInterval(function() {
                            countdown--;
                            countdownElement.innerHTML = countdown;

                            if (countdown <= 0) {
                                clearInterval(countdownInterval);
                                // Refresh the page after countdown
                                location.reload();
                            }
                        }, 1000);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            }

            function rejectRequest(requestId) {
                $.ajax({
                    method: 'POST',
                    url: '/wallet/withdrawalRequest/reject/' + requestId,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Request Rejected');
                        toastr.success(response.message);
                        toastr.info(
                            'Refresh page in <span id="countdown">3</span> seconds'
                        );
                        var countdownElement = document.getElementById(
                            'countdown');
                        var countdown = 3;

                        var countdownInterval = setInterval(function() {
                            countdown--;
                            countdownElement.textContent =
                                countdown;

                            if (countdown <= 0) {
                                clearInterval(countdownInterval);
                                // Refresh the page after countdown
                                location.reload();
                            }
                        }, 1000);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            }
        });
    </script>
@endsection
