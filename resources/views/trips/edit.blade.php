@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trips</h1>
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
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">{{ __('Edit Trip') }}</div>
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
                            <form method="POST" action="{{ route('trips.update', $trip->id) }}" id="tripForm">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="from"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Estimated Time Arrival') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="eta" type="text" class="form-control" name="eta"
                                                value="{{ $trip->eta }}" readonly>
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
                                        <input id="from" type="text" class="form-control" name="from"
                                            value="{{ $trip->pickup_location }}" required>
                                        <input type="hidden" id="origin_lat" name="origin_lat"
                                            value="{{ $trip->origin_lat }}">
                                        <input type="hidden" id="origin_lng" name="origin_lng"
                                            value="{{ $trip->origin_lng }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="to"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Destination') }}</label>

                                    <div class="col-md-6">
                                        <input id="to" type="text" class="form-control" name="to"
                                            value="{{ $trip->destination_location }}" required>
                                        <input type="hidden" id="destination_lat" name="destination_lat"
                                            value="{{ $trip->destination_lat }}">
                                        <input type="hidden" id="destination_lng" name="destination_lng"
                                            value="{{ $trip->destination_lng }}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="departure_time"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Departure Time') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group date" id="datetimepicker">
                                            <input type="datetime-local" class="form-control datetimepicker-input"
                                                name="departure_time" value="{{ $trip->departure_time }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vehicle_type" class="col-md-4 col-form-label text-md-right">Vehicle</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" id="vehicle_id" name="vehicle_id"
                                            data-placeholder="Please select vehicles..." style="width: 100%;">
                                            @foreach ($vehicles as $option)
                                                <option value="{{ $option['id'] }}"
                                                    @if ($option['id'] == $trip->vehicle_id) selected @endif>{{ $option['name'] }}
                                                    [{{ $option['number_plate'] }}]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="available_seats"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Seats Available') }}</label>
                                    <div class="col-md-6">
                                        <input id="available_seats" type="number" min="1" max="50"
                                            class="form-control" name="available_seats"
                                            value="{{ $trip->available_seats }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pricing" class="col-md-4 col-form-label text-md-right">Pricing</label>
                                    <div class="col-md-6">
                                        <input id="pricing" type="number" min="0" step="0.01"
                                            class="form-control" name="pricing" value="{{ $trip->pricing }}" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary float-right">
                                            {{ __('Update Trip') }}
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // alert("Departure time: " + "{{ $trip->departure_time }}".toLocaleString());
        $("input[type=datetime-local]").click(function() {
            // var formattedDate = moment("{{ $trip->departure_time }}").format('YYYY-MM-DD HH:mm');
            // console.log(formattedDate)
            var config = {
                enableTime: true,
                minDate: "today", // Disable dates before today
                // dateFormat: "Y-m-d ",
                // // altInput: true,
                // // altFormat: "d-M-Y h:i",
            };
            flatpickr("input[type=datetime-local]", config);
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
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
            // var formattedDate = moment("{{ $trip->departure_time }}").format('YYYY-MM-DD HH:mm');
            // console.log(formattedDate)
            var config = {
                enableTime: true,
                minDate: "today", // Disable dates before today
                // dateFormat: "Y-m-d ",
                // // altInput: true,
                // // altFormat: "d-M-Y h:i",
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
                    if (response.success) {
                        toastr.success(response.success);

                        toastr.info(
                            'Redirecting you to view the trip in <span id="countdown">5</span> seconds'
                        );

                        var redirectUrl =
                            "{{ route('trips.show', $trip->id) }}"; // Replace 'show' with the actual route name and $id with the desired value

                        var countdownElement = document.getElementById(
                            'countdown');
                        var countdown = 5;

                        var countdownInterval = setInterval(function() {
                            countdown--;
                            countdownElement.textContent =
                                countdown;

                            if (countdown <= 0) {
                                clearInterval(
                                    countdownInterval);
                                window.location.href =
                                    redirectUrl;
                            }
                        }, 1000);
                    } else {
                        toastr.error(response.error);
                    }



                    // Reset the form
                    // $('#tripForm')[0].reset();

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
