@extends('backend.layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
<script>
    // Call the initMap function when the page has finished loading
    google.maps.event.addDomListener(window, 'load', initMap);
    // Function to initialize the map
    function initMap() {
        // Create a new map instance
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 0,
                lng: 0
            }, // Set initial map center
            zoom: 14 // Set initial zoom level
        });

        // Try to get the user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Add a marker for the user's current location
                var marker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    title: 'userLocation',
                    animation: google.maps.Animation.DROP // Add animation to the marker
                });

                // // Add an info window to show the title
                // var infoWindow = new google.maps.InfoWindow({
                //     content: 'Your Location'
                // });

                // // Show the info window when the marker is clicked
                // marker.addListener('click', function() {
                //     infoWindow.open(map, marker);
                // });

                // Center the map on the user's current location
                map.setCenter(userLocation);

                // Get the actual address using Geocoder
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'location': userLocation
                }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            // Use the first result's formatted address
                            var locationName = results[0].formatted_address;
                            var infoWindowContent = 'You are NOW at: ' + locationName;

                            // Create an info window with the updated content
                            var infoWindow = new google.maps.InfoWindow({
                                content: infoWindowContent
                            });


                            infoWindow.open(map, marker);
                            // Show the info window when the marker is clicked
                            marker.addListener('click', function() {
                                infoWindow.open(map, marker);
                            });
                        }
                    }
                });
            }, function() {
                // Handle geolocation error
                alert('Error: The Geolocation service failed.');
            });
        } else {
            // Browser doesn't support geolocation
            alert('Error: Your browser doesn\'t support geolocation.');
        }
    }

    function updateEnlargedImage(location) {
        var imageUrl = 'https://maps.googleapis.com/maps/api/streetview?size=800x600&location=' + location +
            '&key={{ env('GOOGLE_MAP_KEY') }}';
        document.getElementById('enlargedImage').src = imageUrl;
    }
</script>
<style>
    .icon-text-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        padding-bottom: 10px;
    }

    .icon {
        font-size: 20px;
        width: 20px;
        /* Adjust the width of the icon as needed */
        height: 20px;
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

    .gray-text {
        color: #888;
    }

    .gray-icon {
        color: #888;
    }
</style>
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Weclome {{ auth()->user()->name }} Back!</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ auth()->user()->role }} Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Upcoming Trips</h4>
                        @if(isset($upcomingTrip))
                        <div class="card">
                            <div class="card-header">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <dt>Trip ID: {{ $upcomingTrip->id }}</>
                                    <dd>
                                        <i class="icon fas fa-exclamation-triangle" style="color: red;"></i>
                                        <span style="color: red;">Trip Start:
                                            {{ $upcomingTrip->departure_time->diffForHumans() }}
                                        </span>
                                    </dd>
                                </div>

                                {{-- <div class="alert alert-warning alert-dismissible ml-2">
                                        <dt><i class="icon fas fa-exclamation-triangle"></i> Trip Start at {{ $upcomingTrip->departure_time->diffForHumans() }}</dt>
                                    </div> --}}
                            </div>
                            <div class="card-body">
                                {{-- <div class="d-flex align-items-center justify-content-between"> --}}
                                <div class="d-flex">
                                    <div class="col-md-4">
                                        <a href="#" data-toggle="modal" data-target="#imageModal"
                                            onclick="updateEnlargedImage('{{ urlencode($upcomingTrip->destination_location) }}')">
                                            <img src="https://maps.googleapis.com/maps/api/streetview?size=300x300&location={{ urlencode($upcomingTrip->destination_location) }}&key={{ env('GOOGLE_MAP_KEY') }}"
                                                alt="Destination Location Preview" style="height:130px; width:130px;">
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="icon-text-container"
                                            style="display: flex; justify-content: space-between;">
                                            <div class="icon-text-container" style="display: inline-flex;">
                                                <div class="icon">
                                                    <!-- Icon for the date component -->
                                                    <i class="bi bi-calendar-day gray-icon"></i>
                                                </div>
                                                <dt>
                                                    {{ date('Y-m-d', strtotime($upcomingTrip->departure_time)) }}
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-record-circle gray-icon"></i>
                                            </div>
                                            <dt>{{ strtok($upcomingTrip->pickup_location, ',') }}</dt>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-three-dots-vertical gray-icon"></i>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-geo-alt-fill gray-icon"></i>
                                            </div>
                                            <dt>{{ strtok($upcomingTrip->destination_location, ',') }} </dt>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="icon-text-container"
                                            style="display: flex; justify-content: space-between;">
                                            <div class="icon-text-container">
                                                <div class="icon">
                                                    <!-- Icon for the time component -->
                                                    <i class="bi bi-clock gray-icon"></i>
                                                </div>
                                                <dt>
                                                    {{ date('h:i A', strtotime($upcomingTrip->departure_time)) }}
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-people-fill gray-icon"></i>
                                            </div>
                                            <a
                                                href="{{ route('user-profile', ['user_id' => $upcomingTrip->driver->id]) }}">
                                                <dt>{{ $upcomingTrip->driver->name }}</dt>
                                        </div>
                                        @if (auth()->user()->id != $upcomingTrip->driver_id)
                                            <a href="{{ route('chat.chat', ['user_id' => $upcomingTrip->driver_id]) }}"
                                                class="btn btn-outline-primary ms-1">
                                                <i class="bi bi-chat"></i> Contact Driver
                                            </a>
                                        @endif
                                        {{-- <a href="{{ route('chat.chat', ['user_id' => $upcomingTrip->driver_id]) }}" class="btn btn-primary">Contact Driver</a> --}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="{{ route('trips.show', $upcomingTrip->trip_id) }}"
                                        class="btn btn-primary btn-block">Show Details</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card">
                            <div class="card-header">
                                No Upcoming Trip
                            </div>
                            <div class="card-body">
                                <p>You don't have any upcoming trips at the moment.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h4>Existing Trips</h4>
                        @if(isset($existingTrip))
                        <div class="card">
                            <div class="card-header">
                                <div style="display: flex; align-items: top; justify-content: space-between;">
                                    <dt>Trip ID: {{ $existingTrip->id }}</>
                                        <div class="ml-2">
                                    <dd><i class="icon fas fa-exclamation-triangle" style="color: green;"></i> <span
                                            style="color: green;">Trip Done:
                                            {{ $existingTrip->departure_time->diffForHumans() }}</span></dd>
                                </div>

                                {{-- <div class="alert alert-warning alert-dismissible ml-2">
                                      <dt><i class="icon fas fa-exclamation-triangle"></i> Trip Start at {{ $upcomingTrip->departure_time->diffForHumans() }}</dt>
                                  </div> --}}
                            </div>
                            <div class="card-body">
                                {{-- <div class="d-flex align-items-center justify-content-between"> --}}
                                <div class="d-flex">
                                    <div class="col-md-4">
                                        <a href="#" data-toggle="modal" data-target="#imageModal"
                                            onclick="updateEnlargedImage('{{ urlencode($existingTrip->destination_location) }}')">
                                            <img src="https://maps.googleapis.com/maps/api/streetview?size=300x300&location={{ urlencode($existingTrip->destination_location) }}&key={{ env('GOOGLE_MAP_KEY') }}"
                                                alt="Destination Location Preview" style="height:130px; width:130px;">
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="icon-text-container"
                                            style="display: flex; justify-content: space-between;">
                                            <div class="icon-text-container" style="display: inline-flex;">
                                                <div class="icon">
                                                    <!-- Icon for the date component -->
                                                    <i class="bi bi-calendar-day gray-icon"></i>
                                                </div>
                                                <dt>
                                                    {{ date('Y-m-d', strtotime($existingTrip->departure_time)) }}
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-record-circle gray-icon"></i>
                                            </div>
                                            <dt>{{ strtok($existingTrip->pickup_location, ',') }}</dt>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-three-dots-vertical gray-icon"></i>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-geo-alt-fill gray-icon"></i>
                                            </div>
                                            <dt>{{ strtok($existingTrip->destination_location, ',') }} </dt>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="icon-text-container"
                                            style="display: flex; justify-content: space-between;">
                                            <div class="icon-text-container">
                                                <div class="icon">
                                                    <!-- Icon for the time component -->
                                                    <i class="bi bi-clock gray-icon"></i>
                                                </div>
                                                <dt>
                                                    {{ date('h:i A', strtotime($existingTrip->departure_time)) }}
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="icon-text-container">
                                            <div class="icon">
                                                <i class="bi bi-people-fill gray-icon"></i>
                                            </div>
                                            <dt>{{ $existingTrip->driver->name }}</dt>
                                        </div>
                                        @if (auth()->user()->id != $existingTrip->driver_id)
                                            <a href="{{ route('chat.chat', ['user_id' => $existingTrip->driver_id]) }}"
                                                class="btn btn-outline-primary ms-1">
                                                <i class="bi bi-chat"></i> Contact Driver
                                            </a>
                                        @endif
                                        {{-- <a href="{{ route('chat.chat', ['user_id' => $upcomingTrip->driver_id]) }}" class="btn btn-primary">Contact Driver</a> --}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="{{ route('trips.show', $existingTrip->trip_id) }}"
                                        class="btn btn-primary btn-block">Show Details</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card">
                            <div class="card-header">
                                No Existing Trip
                            </div>
                            <div class="card-body">
                                <p>You don't have any eixisting trips at the moment.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div id="map" style="height: 260px;"></div>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('trips.myTrips') }}" class="small-box bg-info" style="height: 120px;">
                        <div class="inner">
                            <h3>Your Trip</h3>
                            <p style="margin-right: 60px;">View your trip, edit or cancel your trip as you want</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </a>
                    <a href="{{ route('trips.create') }}" class="small-box bg-success" style="height: 120px;">
                        <div class="inner">
                            <h3>Create Trip</h3>
                            <p style="margin-right: 60px;">Start to create your carpool trip now</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </a>
                </div>
            </div>


            <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
