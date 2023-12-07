@extends('backend.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
    .live-location-icon {
        color: red;
        animation: pulse 0.8s infinite alternate;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.5);
        }
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
        <!-- /.content-header -->
        {{-- <div class="container" style="height: 30%;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" > --}}
        {{-- </div>
                </div>
            </div>
        </div> --}}

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Create New Trip') }}</div>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12" style="margin-bottom:15px;">
                                    <div id="map" style="height: 260px;"></div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('trips.store') }}" id="tripForm">
                                @csrf

                                <div class="form-group row">
                                    <label for="from"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Estimated Time Arrival') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="eta" type="text" class="form-control" name="eta"
                                                readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i
                                                        class="fas fa-map-marker-alt live-location-icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="from"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Origin') }}</label>

                                    <div class="col-md-6">
                                        <input id="from" type="text" class="form-control" name="from" required>
                                        <input type="hidden" id="originLat" name="originLat">
                                        <input type="hidden" id="originLng" name="originLng">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="to"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Destination') }}</label>

                                    <div class="col-md-6">
                                        <input id="to" type="text" class="form-control" name="to" required>
                                        <input type="hidden" id="destinationLat" name="destinationLat">
                                        <input type="hidden" id="destinationLng" name="destinationLng">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="departure_time"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Departure Time') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group date" id="datetimepicker">
                                            <input type="datetime-local" class="form-control datetimepicker-input"
                                                name="departure_time" />
                                            {{-- <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vehicle_type" class="col-md-4 col-form-label text-md-right">Vehicle</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" id="vehicle_id" name="vehicle_id"
                                            data-placeholder="Please select vehicles..." style="width: 100%;">
                                            @foreach ($vehicles as $option)
                                                <option value=""></option>
                                                <option value="{{ $option['id'] }}">{{ $option['name'] }}
                                                    [{{ $option['number_plate'] }}] </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="available_seats"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Seats Available') }}</label>
                                    <div class="col-md-6">
                                        <input id="available_seats" type="number" min="1" max="50"
                                            class="form-control" name="available_seats" value="" disabled required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pricing" class="col-md-4 col-form-label text-md-right">Pricing</label>
                                    <div class="col-md-6">
                                        <input id="pricing" type="number" min="0" step="0.01"
                                            class="form-control" name="pricing" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary float-right">
                                            {{ __('Create Trip') }}
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You have not created a vehicle yet. Please create a vehicle to proceed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Create Vehicle</a>
                </div>
            </div>
        </div>
    </div>
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Check if the user has created a vehicle
        var hasVehicle = {{ json_encode($vehicles->isNotEmpty()) }};

        // Show the warning modal if the user doesn't have a vehicle
        if (!hasVehicle) {
            $('#warningModal').modal('show');

            var countdown = 10; // Countdown in seconds
            var toastrOptions = {
                closeButton: false,
                progressBar: true,
                timeOut: 10000, // 5 seconds
                onHidden: function() {
                    window.location.href = "{{ route('vehicles.create') }}";
                }
            };

            var toastrContainerId = toastr.info(
                'You have not created a vehicle yet. Redirecting to create a vehicle page in <span id="countdown">' +
                countdown + '</span> seconds.', '', toastrOptions);

            var interval = setInterval(function() {
                countdown--;
                $('#countdown').text(countdown);

                if (countdown <= 0) {
                    clearInterval(interval);
                    toastr.clear(toastrContainerId);
                    window.location.href = "{{ route('vehicles.create') }}";
                }
            }, 1000);
        }

        $('.select2').select2({
            // tags: true,
            // tokenSeparators: [',', ' '], // Define the separators to create new tags
            // createTag: function(params) { // Allow creating new tags
            //     var term = $.trim(params.term);
            //     if (term === '') {
            //         return null;
            //     }
            //     return {
            //         id: term,
            //         text: term,
            //         newTag: true
            //     }
            // },
            // templateResult: function(data) { // Format the display of new tags
            //     var $result = $("<span></span>");
            //     $result.text(data.text);
            //     if (data.newTag) {
            //         $result.append(" <em>(New)</em>");
            //     }
            //     return $result;
            // }
        });

        $('#vehicle_id').change(function() {
            var selectedVehicleId = $(this).val();

            var selectedVehicle = {!! $vehicles !!}.find(function(vehicle) {
                return vehicle.id == selectedVehicleId;
            });
            // Update available seats input value
            if (selectedVehicle) {
                $('#available_seats').prop('disabled', false);
                $('#available_seats').val(selectedVehicle.available_seats);
            } else {
                $('#available_seats').prop('disabled', true);
                $('#available_seats').val('');
            }
        });

        $("input[type=datetime-local]").click(function() {
            var now = new Date();
            config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today", // Disable dates before today
                defaultDate: now // Set default date and time to now
            };
            flatpickr("input[type=datetime-local]", config);
        });

        // Handle form submission
        $('#tripForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Get the form data

            // Send AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Display success toastr notification
                    if(response.success){
                        toastr.success(response.success);
                    }
                    else{
                        toastr.error(response.error);
                    }
                    // Reset the form
                    $('#tripForm')[0].reset();

                    // Optional: Perform additional actions after successful submission

                },
                error: function(xhr, status, error) {
                    // Display error toastr notification
                    toastr.error('An error occurred. Please try again.');

                    // Optional: Handle specific error scenarios

                }
            });
        });
    });
</script>
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

        var fromInput = document.getElementById('from');
        var fromAutocomplete = new google.maps.places.Autocomplete(fromInput, options);
        fromAutocomplete.addListener('place_changed', function() {
            var place = fromAutocomplete.getPlace();
            updateMap();
        });

        var toInput = document.getElementById('to');
        var toAutocomplete = new google.maps.places.Autocomplete(toInput, options);
        toAutocomplete.addListener('place_changed', function() {
            var place = toAutocomplete.getPlace();
            updateMap();
        });

        updateMap(); // Initialize the map with default values
    }

    function updateMap() {
        var originInput = document.getElementById('from');
        var destinationInput = document.getElementById('to');

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
        var originLat = originLatLng.lat();
        var originLng = originLatLng.lng();
        var destinationLat = destinationLatLng.lat();
        var destinationLng = destinationLatLng.lng();

        // Set the latitude and longitude values in the hidden input fields
        document.getElementById('originLat').value = originLat;
        document.getElementById('originLng').value = originLng;
        document.getElementById('destinationLat').value = destinationLat;
        document.getElementById('destinationLng').value = destinationLng;

        // Calculate travel time using the latitude and longitude values
        calculateTravelTime(originLat, originLng, destinationLat, destinationLng);
    }

    function calculateTravelTime(originLat, originLng, destinationLat, destinationLng) {
        var origin = new google.maps.LatLng(originLat, originLng);
        var destination = new google.maps.LatLng(destinationLat, destinationLng);

        var directionsService = new google.maps.DirectionsService();

        var request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                var route = result.routes[0];
                var legs = route.legs;
                var travelTime = legs[0].duration.text;

                // Use the travelTime for further processing or display
                console.log("Estimated travel time:", travelTime);
                $('#eta').val(travelTime);
            } else {
                // Handle the error case when directions request fails
                console.error("Directions request failed:", status);
            }
        });

    }
</script>
