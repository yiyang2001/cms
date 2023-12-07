@extends('backend.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

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



        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search for trips</h3>
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
                                {{-- <form method="POST" action="{{ route('trips.searchResults') }}" name="form">
                                    @csrf --}}
                                <div class="form-group row">
                                    <div class="col-lg-6 offset-3">
                                        <div id="map" style="height: 150px;"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pickup_location" class="col-md-4 col-form-label text-md-right">Pickup
                                        Location</label>

                                    <div class="col-md-6">
                                        <input id="pickup_location" type="text" class="form-control"
                                            name="pickup_location" value="" required>
                                        <input type="hidden" id="originLat" name="originLat">
                                        <input type="hidden" id="originLng" name="originLng">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="destination_location"
                                        class="col-md-4 col-form-label text-md-right">Destination Location</label>

                                    <div class="col-md-6">
                                        <input id="destination_location" type="text" class="form-control"
                                            name="destination_location" value="" required
                                            autocomplete="destination_location">
                                        <input type="hidden" id="destinationLat" name="destinationLat">
                                        <input type="hidden" id="destinationLng" name="destinationLng">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="button" class="btn btn-primary" name="submit"
                                            onclick="searchTrips()">
                                            Search
                                        </button>
                                    </div>
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid" id="searchResultDiv">
                <!-- Table to display search results -->
                <div class="card">
                    <div class="card-body">
                        <table id="result-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Driver</th>
                                    <th>Origin Location</th>
                                    <th>Destination Location</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Available Seats</th>
                                    <th style="width:200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- /.container-fluid -->
@endsection
<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>

<script>
    google.maps.event.addDomListener(window, 'load', initialize);


    function initialize() {
        var options = {
            componentRestrictions: {
                country: 'MY' // Restrict results to Malaysia only
            }
        };

        var fromInput = document.getElementById('pickup_location');
        var fromAutocomplete = new google.maps.places.Autocomplete(fromInput, options);
        fromAutocomplete.addListener('place_changed', function() {
            var place = fromAutocomplete.getPlace();
            updateMap();
        });

        var toInput = document.getElementById('destination_location');
        var toAutocomplete = new google.maps.places.Autocomplete(toInput, options);
        toAutocomplete.addListener('place_changed', function() {
            var place = toAutocomplete.getPlace();
            updateMap();
        });

        updateMap(); // Initialize the map with default values
    }

    function updateMap() {
        var originInput = document.getElementById('pickup_location');
        var destinationInput = document.getElementById('destination_location');
        var origin = originInput.value;
        var destination = destinationInput.value;

        if (origin && destination) {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10
            });

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            var request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);

                    var originLatLng = result.routes[0].legs[0].start_location;
                    var destinationLatLng = result.routes[0].legs[0].end_location;

                    // Save the latitude and longitude values to the database
                    saveToDatabase(originLatLng, destinationLatLng);
                }
            });
        }
    }

    function saveToDatabase(originLatLng, destinationLatLng) {
        // Set the latitude and longitude values in the hidden input fields
        document.getElementById('originLat').value = originLatLng.lat();
        document.getElementById('originLng').value = originLatLng.lng();
        document.getElementById('destinationLat').value = destinationLatLng.lat();
        document.getElementById('destinationLng').value = destinationLatLng.lng();

        // Submit the form
        // document.getElementById('tripForm').submit();
    }

    function searchTrips() {
        // event.preventDefault(); // Prevent form submission

        // Retrieve the pickup and destination locations from the form

        var originlat = document.getElementById('originLat').value;
        var originlng = document.getElementById('originLng').value;
        var destinationlat = document.getElementById('destinationLat').value;
        var destinationlng = document.getElementById('destinationLng').value;

        $.ajax({
            url: '{{ route('trips.searchResults') }}',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                originlat: originlat,
                originlng: originlng,
                destinationlat: destinationlat,
                destinationlng: destinationlng,
            },
            success: function(response) {
                // Process the response and update the DOM with the search results
                // updateSearchResults(response);
                console.log(response);
                if ($.fn.DataTable.isDataTable('#result-table')) {
                    $('#result-table').DataTable().destroy();
                }
                // Initialize the datatable
                $('#result-table').DataTable({
                    data: response.data,
                    columns: [{
                            data: 'driver_name'
                        },
                        {
                            data: 'pickup_location'
                        },
                        {
                            data: 'destination_location'
                        },
                        {
                            data: 'departure_date'
                        },
                        {
                            data: 'departure_time_formatted'
                        },
                        {
                            data: 'available_seats'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                var buttons = '';
                                buttons += '<a href="/trips/' + data +
                                    '" class="btn btn-info">View</a>';

                                if ({{ auth()->id() }} === row.user_id) {
                                    buttons +=
                                        ' <a href="{{ route('trips.edit', ':id') }}" class="btn btn-primary">Edit</a>'
                                        .replace(':id', data);
                                    buttons +=
                                        '<form action="{{ route('trips.destroy', ':id') }}" method="POST" class="d-inline">' +
                                        '@csrf @method('DELETE')' +
                                        '<button type="submit" class="btn btn-danger">Delete</button>' +
                                        '</form>'
                                        .replace(':id', data);
                                }

                                return buttons;
                            }
                        }
                    ],
                    columnDefs: [{
                        targets: 6, // Index of the action column
                        className: 'actions-column',
                        orderable: false,
                        searchable: false,
                        width: '250px'
                    }],
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#result-table").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#passengers-table_wrapper .col-md-6:eq(0)');
    });
</script>
