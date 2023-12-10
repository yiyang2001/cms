@extends('backend.layouts.app')
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
    <script src="{{ asset('vendor/plugins/lightslider/js/lightslider.js') }}"></script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Announcement Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Announcement Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $announcement->title }}</h3>
                            </div>
                            <div class="card-body">
                                <p>{!! $announcement->content !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Image</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12" name="img-slider">
                                    @if (isset($announcement->images))
                                        <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach ($announcement->images as $key => $image)
                                                    <li data-target="#imageCarousel" data-slide-to="{{ $key }}"
                                                        class="{{ $loop->first ? 'active' : '' }}"></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($announcement->images as $key => $image)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ asset($image['path']) }}" alt="Announcement Image"
                                                            class="d-block w-100">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#imageCarousel" role="button"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#imageCarousel" role="button"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    @else
                                        No attachment available.
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Attachment</h3>
                            </div>
                            <div class="card-body">
                                @if ($announcement->file)
                                    <a href="{{ asset('storage/' . $announcement->file) }}"
                                        target="_blank">{{ $announcement->file }}</a>
                                @else
                                    No attachment available.
                                @endif
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
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
