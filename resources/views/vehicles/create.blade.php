@extends('backend.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.2/dist/jquery.min.js"></script> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
@section('content')
    <div class="content-wrapper" style="height:auto;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Vehicle</h1>
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
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Vehicle</h3>
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
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('form.data') }}" name="vehicleForm" id="vehicleForm" method="POST"
                            class="dropzone" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Vehicle Name </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Vehicle Nick Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="vehicle_id" name="vehicle_id" id="vehicle_id"
                                        value="">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <select class="form-control select2" id="vehicle_type" name="vehicle_type"
                                        data-placeholder="Please select vehicles..." style="width: 100%;">
                                        @foreach ($type_options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <select class="form-control select2" id="brand" name="brand"
                                        data-placeholder="Please select a brand..." style="width: 100%;">
                                        @foreach ($brand_options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control" id="model" name="model"
                                        placeholder="Enter model" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control" id="color" name="color"
                                        placeholder="Enter color" required>
                                </div>
                                <div class="form-group">
                                    <label for="number_plate">Number Plate</label>
                                    <input type="text" class="form-control" id="number_plate" name="number_plate"
                                        placeholder="Enter number plate" required>
                                </div>
                                <div class="form-group">
                                    <label for="available_seats">Available Seats</label>
                                    <input type="number" class="form-control" id="available_seats" name="available_seats"
                                        placeholder="Enter available seats" required>
                                </div>
                                <!-- Dropzone container -->
                                <div class="form-group">
                                    <label for="vehicle_images">Vehicle Images</label>
                                    <div class="dropzone" id="vehicle-dropzone" name="vehicle-dropzone"></div>
                                </div>
                                <!-- Add more form fields as per your requirements -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Initialize Dropzone
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' '], // Define the separators to create new tags
                createTag: function(params) { // Allow creating new tags
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
                templateResult: function(data) { // Format the display of new tags
                    var $result = $("<span></span>");
                    $result.text(data.text);
                    if (data.newTag) {
                        $result.append(" <em>(New)</em>");
                    }
                    return $result;
                }
            });

            let token = $('meta[name="csrf-token"]').attr('content');
            // Initialize Dropzone
            var myDropzone = new Dropzone("#vehicle-dropzone", {
                url: "{{ url('/storeimage') }}", // Set the URL where the images will be uploaded
                parallelUploads: 5, // Set the number of parallel uploads
                maxFilesize: 10, // Set the maximum file size in MB
                addRemoveLinks: true, // Enable remove file links
                dictDefaultMessage: "Drop files here or click to upload", // Set the default message
                dictFileTooBig: "File is too big. Max filesize: 10MB.", // Set the file size error message
                dictInvalidFileType: "Invalid file type. Only image files are allowed.", // Set the invalid file type error message
                dictRemoveFile: "Remove", // Set the remove file link text
                previewsContainer: "#vehicle-dropzone", // Set the container to display the previews
                autoProcessQueue: false, // Make sure the files aren't queued until manually added
                clickable: "#vehicle-dropzone", // Set the element that triggers file selection
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token
                },
                init: function() {
                    var myDropzone = this;
                    //form submission code goes here
                    $("form[name='vehicleForm']").submit(function(event) {
                        //Make sure that the form isn't actully being sent.
                        event.preventDefault();

                        URL = $("#vehicleForm").attr('action');
                        formData = $('#vehicleForm').serialize();
                        $.ajax({
                            type: 'POST',
                            url: URL,
                            data: formData,
                            success: function(result) {
                                if (result.status == "success") {
                                    // fetch the useid 
                                    var vehicle_id = result.vehicle_id;
                                    $("#vehicle_id").val(
                                        vehicle_id
                                    ); // inseting userid into hidden input field
                                    //process the queue
                                    myDropzone.processQueue();

                                    // Display the success message
                                    toastr.success("Image uploaded successfully.");
                                } else {
                                    console.log("error");
                                }
                            }
                        });
                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        let vehicle_id = document.getElementById('vehicle_id').value;
                        formData.append('vehicle_id', vehicle_id);
                    });

                    this.on("success", function(file, response) {
                        //reset the form
                        $('#vehicleForm')[0].reset();
                        //reset dropzone
                        $('#vehicle-dropzone').empty();
                    });

                    this.on("queuecomplete", function() {

                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        let vehicle_id = document.getElementById('vehicle_id').value;
                        formData.append('vehicle_id', vehicle_id);
                    });
                    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                    // of the sending event because uploadMultiple is set to true.
                    this.on("sendingmultiple", function() {
                        // Gets triggered when the form is actually being sent.
                        // Hide the success button or the complete form.
                        // let vehicle_id = document.getElementById('vehicle_id').value;
                        // formData.append('vehicle_id', vehicle_id);
                    });

                    this.on("successmultiple", function(files, response) {
                        // Gets triggered when the files have successfully been sent.
                        // Redirect user or notify of success.
                    });

                    this.on("errormultiple", function(files, response) {
                        // Gets triggered when there was an error sending the files.
                        // Maybe show form again, and notify user of error
                    });
                }
            });
        });
    </script>
@endsection
