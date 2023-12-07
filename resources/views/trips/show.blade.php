@extends('backend.layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">



<style>
    .icon-text-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }

    .icon {
        font-size: 40px;
        width: 40px;
        /* Adjust the width of the icon as needed */
        height: 40px;
        /* Adjust the height of the icon as needed */
    }

    .text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .smaller-text {
        font-size: 15px;
        /* Adjust the font size of the smaller text as needed */
    }

    img {
        border-radius: 10px;
    }

    img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>

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
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-10 offset-md-1"> --}}
                <div class="col-md-12">
                    <div class="card mb-6">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="col-md-10">
                                    <div class="icon-text-container">
                                        <div class="icon">
                                            <i class="bi bi-pin-map-fill"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="text">
                                                <h4>{{ strtok($trips->pickup_location, ',') }}</h4>
                                                <h4 class="smaller-text">{{ $trips->pickup_location }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#" data-toggle="modal" data-target="#imageModal"
                                                onclick="updateEnlargedImage('{{ urlencode($trips->pickup_location) }}')">
                                                <img src="https://maps.googleapis.com/maps/api/streetview?size=300x200&location={{ urlencode($trips->pickup_location) }}&key={{ env('GOOGLE_MAP_KEY') }}"
                                                    alt="Pickup Location Preview" style="height:auto; width:150px;">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="icon-text-container">
                                        <div class="icon">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </div>
                                    </div>


                                    <div class="icon-text-container">
                                        <div class="icon">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <div class="col-md-9">

                                            <div class="text">
                                                <h4>{{ strtok($trips->destination_location, ',') }}</h4>
                                                <h4 class="smaller-text">{{ $trips->destination_location }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#" data-toggle="modal" data-target="#imageModal"
                                                onclick="updateEnlargedImage('{{ urlencode($trips->destination_location) }}')">
                                                <img src="https://maps.googleapis.com/maps/api/streetview?size=300x200&location={{ urlencode($trips->destination_location) }}&key={{ env('GOOGLE_MAP_KEY') }}"
                                                    alt="Destination Location Preview" style="height:auto; width:150px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    @if (auth()->id() === $trips->user_id)
                                        <a href="{{ route('trips.edit', $trips) }}" class="btn btn-primary mr-2">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    @endif
                                    @if (auth()->id() === $trips->user_id)
                                        <form action="{{ route('trips.destroy', $trips) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this trip?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                    @if (auth()->id() != $trips->driver_id && $trips->status == 'pending')
                                        <form action="{{ route('trips.requestTrip', $trips->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="origin_lat" value="{{ $trips->origin_lat }}">
                                            <input type="hidden" name="origin_lng" value="{{ $trips->origin_lng }}">
                                            <input type="hidden" name="destination_lat"
                                                value="{{ $trips->destination_lat }}">
                                            <input type="hidden" name="destination_lng"
                                                value="{{ $trips->destination_lng }}">
                                            <input type="hidden" name="pickup_location"
                                                value="{{ $trips->pickup_location }}">
                                            <input type="hidden" name="pickup_location"
                                                value="{{ $trips->pickup_location }}">
                                            <input type="hidden" name="destination_location"
                                                value="{{ $trips->destination_location }}">
                                            <input type="hidden" name="seats_requested" value="1">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Are you sure you want to request this trip?')">
                                                <i class="fa fa-plus-circle"></i> Request Trip
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>


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
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0">Departure Time</h5>
                                    <p class="mb-0">{{ $trips->departure_time->format('d-M-Y(l)') }}</p>
                                    <p class="mb-0">{{ $trips->departure_time->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <h5 class="mb-0">Seats Available</h5>
                                    <p class="mb-0">{{ $trips->available_seats }}</p>
                                </div>
                                <div>
                                    <h5 class="mb-0">Price</h5>
                                    <p class="mb-0">RM{{ $trips->pricing }}</p>
                                </div>
                                <div>
                                    <h5 class="mb-0">Driver</h5>
                                    <p class="mb-0">{{ $trips->driver->name }}</p>
                                    @if (auth()->id() != $trips->driver_id)
                                        <button type="button" class="btn btn-outline-primary ms-1">
                                            <a href="{{ route('chat.chat', ['user_id' => $trips->driver_id]) }}"
                                                id="chatButton">
                                                Message Driver
                                            </a>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header">
                            <h3 class="mb-0"> Riders </h3>
                        </div>
                        <div class="card-body">

                            <table id="passengers-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th style="width:200px">Pickup Location</th>
                                        <th style="width:200px">Destination Location</th>
                                        <th>Requested At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trips->requests as $request)
                                        @if ($request->status == 'approved')
                                            <tr class="table-success">
                                            @elseif ($request->status == 'pending')
                                            <tr class="table-warning">
                                            @elseif ($request->status == 'rejected')
                                            <tr class="table-danger">
                                            @else
                                            <tr>
                                        @endif
                                        <td>{{ $request->user->name }}</td>
                                        <td>{{ $request->pickup_location }}</td>
                                        <td>{{ $request->destination_location }}</td>
                                        <td>{{ $request->created_at }}</td>
                                        <td>{{ $request->status }}</td>
                                        <td>

                                            @if (auth()->id() == $trips->driver_id && $request->status == 'pending')
                                                <form action="{{ route('trip_requests.update', $request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success">Accept</button>
                                                </form>
                                                <form action="{{ route('trip_requests.update', $request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger">Reject</button>
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="Enlarged Image" id="enlargedImage" style="max-width: 100%;">
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    $(document).ready(function() {

        $("#passengers-table").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"],
            "rowCallback": function(row, data) {
                // Check the status column for "pending"
                if (data.status == "pending") {
                    $(row).addClass('pending-row');
                }
            }
        }).buttons().container().appendTo('#passengers-table_wrapper .col-md-6:eq(0)');
    });

    function updateEnlargedImage(location) {
        var imageUrl = 'https://maps.googleapis.com/maps/api/streetview?size=800x600&location=' + location +
            '&key={{ env('GOOGLE_MAP_KEY') }}';
        document.getElementById('enlargedImage').src = imageUrl;
    }
</script>
{{-- 
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script> --}}
{{-- @section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Trip {{ $trips->id }}</div>
                <div class="card-body">

                    <a href="{{ url('/trip') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/trip/' . $trips->id . '/edit') }}" title="Edit Trip"><button
                            class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Edit</button></a>

                    <form method="POST" action="{{ url('trip' . '/' . $trips->id) }}" accept-charset="UTF-8"
                        style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Trip"
                            onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                aria-hidden="true"></i> Delete</button>
                    </form>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $trips->id }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
