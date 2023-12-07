@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trip</h1>
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
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All Trips</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('trips.create') }}" class="btn btn-primary">Add New Trip</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            <strong>{{ session('error') }}</strong>
                                        </div>
                                    @endif
                                    <table id="all-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th style="width:180px;">Pickup Location</th>
                                                <th style="width:180px;">Destination Location</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Driver</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trips as $key => $trip)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $trip->pickup_location }}</td>
                                                    <td>{{ $trip->destination_location }}</td>
                                                    <td>{{ $trip->departure_time->format('Y-m-d') }}</td>
                                                    <td>{{ $trip->departure_time->format('h:i A') }}</td>
                                                    <td>{{ $trip->driver->name }}</td>
                                                    @if ($trip->status == 'pending')
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                    @elseif($trip->status == 'rejected')
                                                        <td><span class="badge badge-danger">Rejected</span></td>
                                                    @elseif($trip->status == 'approved')
                                                        <td><span class="badge badge-success">Approved</span></td>
                                                    @else
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ route('trips.show', $trip->id) }}"
                                                            class="btn btn-primary btn-sm"><i
                                                                class="fas fa-folder"></i>View</a>
                                                        @if (auth()->user()->id == $trip->driver_id)
                                                            <a href="{{ route('trips.edit', $trip->id) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-pencil-alt">
                                                                </i>Edit</a>
                                                            <form action="{{ route('trips.destroy', $trip->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"> <i
                                                                        class="fas fa-trash">
                                                                    </i>Delete</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Start Location</th>
                                                <th>End Location</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Driver</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#all-table").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#all-table_wrapper .col-md-6:eq(0)');
    });
</script>
