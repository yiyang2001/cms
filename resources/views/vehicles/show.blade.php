@extends('backend.layouts.app')
<link href="{{ asset('vendor/plugins/lightslider/css/lightslider.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/plugins/lightslider/js/lightslider.js') }}"></script>

<style>
    .img-slider {
        width: 800px;
    }

    ul {
        list-style: none outside none;
        padding-left: 0;
        margin-bottom: 0;
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
        <div class="container">
            <div class="container-fliud">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Vehicle Details
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6" name="img-slider">
                                        <div id="vehicleCarousel" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach ($vehicle->images as $key => $image)
                                                    <li data-target="#vehicleCarousel" data-slide-to="{{ $key }}"
                                                        class="{{ $loop->first ? 'active' : '' }}"></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($vehicle->images as $key => $image)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ asset($image['path']) }}" alt="Vehicle Image"
                                                            class="d-block w-100">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#vehicleCarousel" role="button"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#vehicleCarousel" role="button"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text">{{ $vehicle->name }}</p>
                                        <hr>
                                        <p class="card-text">
                                            <strong>Brand:</strong> {{ $vehicle->brand }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Model:</strong> {{ $vehicle->model }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Color:</strong> {{ $vehicle->color }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Type:</strong> {{ $vehicle->vehicle_type }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Number:</strong> {{ $vehicle->number_plate }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Available Seat:</strong> {{ $vehicle->available_seat }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Created At:</strong> {{ $vehicle->created_at }}
                                        </p>
                                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary">Edit
                                            Vehicle</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var slider = $("#lightSlider").lightSlider({
                item: 1,
                autoWidth: false,
                slideMove: 1, // slidemove will be 1 if loop is true
                slideMargin: 10,

                addClass: '',
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
                easing: 'linear', //'for jquery animation',////

                speed: 400, //ms'
                auto: true,
                loop: true,
                slideEndAnimation: true,
                pause: 2000,

                keyPress: false,
                controls: true,
                prevHtml: '',
                nextHtml: '',

                rtl: false,
                adaptiveHeight: true,

                vertical: false,
                verticalHeight: 500,
                vThumbWidth: 100,

                thumbItem: 10,
                pager: true,
                gallery: true,
                galleryMargin: 5,
                thumbMargin: 5,
                currentPagerPosition: 'middle',

                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40,

                responsive: [],

                onBeforeStart: function(el) {},
                onSliderLoad: function(el) {},
                onBeforeSlide: function(el) {},
                onAfterSlide: function(el) {},
                onBeforeNextSlide: function(el) {},
                onBeforePrevSlide: function(el) {}
            });

        });
    </script>
@endsection
