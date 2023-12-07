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
                                    <h3 class="card-title">My Trips</h3>
                                    {{-- <div class="card-tools">
                                        <a href="{{ route('trips.create') }}" class="btn btn-primary">Add New Trip</a>
                                    </div> --}}
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

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Departure Time</th>
                                                <th style="width:150px;">Pickup Location</th>
                                                <th style="width:150px;">Destination Location</th>
                                                <th>Driver</th>
                                                <th>Passengers</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trips as $key => $trip)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $trip->departure_time }}</td>
                                                    <td>{{ $trip->pickup_location }}</td>
                                                    <td>{{ $trip->destination_location }}</td>
                                                    <td>{{ $trip->driver->name }}</td>
                                                    <td>
                                                        @foreach ($trip->tripRequests as $rider)
                                                            {{ $rider->user->name }} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('trips.show', $trip->id) }}"
                                                            class="btn btn-info">View</a>
                                                        @if ($trip->driver_id == auth()->id())
                                                            <a href="{{ route('trips.edit', $trip->id) }}"
                                                                class="btn btn-primary">Edit</a>
                                                            <form action="{{ route('trips.destroy', $trip->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this trip?')">Delete</button>
                                                            </form>
                                                        @endif
                                                    </td>
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
        </section>
    </div>
@endsection
