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
                                    <h3 class="card-title">Search Results</h3>
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


                                    @if (count($trips) > 0)
                                        <div class="card">
                                            <div class="card-body">
                                                @foreach ($trips as $trip)
                                                    <h3>{{ $trip->driver->name }}</h3>
                                                    <p>Departure time:
                                                        {{ $trip->departure_time->format('Y-m-d H:i:s') }}</p>
                                                    <p>Pickup location: {{ $trip->pickup_location }}</p>
                                                    <p>Destination location: {{ $trip->destination_location }}</p>
                                                    <p>Available seats: {{ $trip->available_seats }}</p>
                                                    <form method="POST" action="{{ route('trips.joinTrip', $trip->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                                        <div class="form-group row">
                                                            <label for="pickup_location"
                                                                class="col-md-4 col-form-label text-md-right">Pickup
                                                                Location</label>

                                                            <div class="col-md-6">
                                                                <input id="pickup_location" type="text"
                                                                    class="form-control @error('pickup_location') is-invalid @enderror"
                                                                    name="pickup_location"
                                                                    value="{{ $trip->pickup_location }}" required
                                                                    autocomplete="pickup_location" autofocus>

                                                                {{-- @error('pickup_location')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}
                                                                        </span>
                                                                    @enderror --}}
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="destination_location"
                                                                class="col-md-4 col-form-label text-md-right">Destination
                                                                Location</label>

                                                            <div class="col-md-6">
                                                                <input id="destination_location" type="text"
                                                                    class="form-control @error('destination_location') is-invalid @enderror"
                                                                    name="destination_location"
                                                                    value="{{ $trip->destination_location }}" required
                                                                    autocomplete="destination_location">

                                                                {{-- @error('destination_location')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror --}}
                                                            </div>
                                                        </div>

                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6 offset-md-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Join Trip
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endforeach
                                                <table id="passengers-table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Pickup Location</th>
                                                            <th>Destination Location</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trip->riders as $rider)
                                                            <tr>
                                                                <td>{{ $rider->name }}</td>
                                                                <td>{{ $rider->pivot->pickup_location }}</td>
                                                                <td>{{ $rider->pivot->destination_location }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <p>No trips found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
@endsection
<script>
    $(document).ready(function() {
        $('#passengers-table').DataTable();
    });
</script>
