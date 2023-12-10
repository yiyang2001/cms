@extends('backend.layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Announcements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
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
                                    <h3 class="card-title">Create Announcements</h3>
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
                                    <form name="announcement_form" id="announcement_form"
                                        action="{{ route('announcements.storeData') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="announcement_id" name="announcement_id"
                                            id="announcement_id" value="">
                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" name="title" id="title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Content:</label>
                                            <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="file">File (PDF, DOC, DOCX):</label>
                                            <input type="file" name="file" id="file" class="form-control-file">
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="image">Image (JPEG, PNG, GIF):</label>
                                            <div class="dropzone" id="image-dropzone" name="image-dropzone"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            tinymce.init({
                selector: '#content',
                plugins: 'advlist autolink lists link image charmap preview anchor',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | link',
                height: 400,
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save(); // Save content to the textarea on change
                    });
                }
            });

            let token = $('meta[name="csrf-token"]').attr('content');
            // Initialize Dropzone
            var myDropzone = new Dropzone("#image-dropzone", {
                url: "{{ url('/announcements/image/upload') }}", // Set the URL where the images will be uploaded
                parallelUploads: 5, // Set the number of parallel uploads
                maxFilesize: 10, // Set the maximum file size in MB
                addRemoveLinks: true, // Enable remove file links
                dictDefaultMessage: "Drop files here or click to upload", // Set the default message
                dictFileTooBig: "File is too big. Max filesize: 10MB.", // Set the file size error message
                dictInvalidFileType: "Invalid file type. Only image files are allowed.", // Set the invalid file type error message
                dictRemoveFile: "Remove", // Set the remove file link text
                previewsContainer: "#image-dropzone", // Set the container to display the previews
                autoProcessQueue: false, // Make sure the files aren't queued until manually added
                clickable: "#image-dropzone", // Set the element that triggers file selection
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token
                },
                init: function() {
                    var myDropzone = this;
                    //form submission code goes here
                    $("form[name='announcement_form']").submit(function(event) {
                        //Make sure that the form isn't actully being sent.
                        event.preventDefault();

                        URL = $("#announcement_form").attr('action');
                        formData = $('#announcement_form').serialize();
                        $.ajax({
                            type: 'POST',
                            url: URL,
                            data: formData,
                            success: function(result) {
                                if (result.status == "success") {
                                    // fetch the useid 
                                    var announcement_id = result.announcement_id;
                                    $("#announcement_id").val(
                                        announcement_id
                                    ); // inseting userid into hidden input field
                                    //process the queue
                                    myDropzone.processQueue();
                                    toastr.options = {
                                        "closeButton": true,
                                        "progressBar": true,
                                        "timeOut": "3000",
                                        "positionClass": "toast-top-right"
                                    }
                                    // Display the success message
                                    toastr.success("Image uploaded successfully.");
                                    toastr.success(
                                        "Announcement created successfully.");
                                } else {
                                    console.log("error");
                                }
                            }
                        });
                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        let announcement_id = document.getElementById('announcement_id').value;
                        formData.append('announcement_id', announcement_id);
                    });

                    this.on("success", function(file, response) {
                        //reset the form
                        $('#announcement_form')[0].reset();
                        //reset dropzone
                        $('#image-dropzone').empty();
                    });

                    this.on("queuecomplete", function() {

                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        let announcement_id = document.getElementById('announcement_id').value;
                        formData.append('announcement_id', announcement_id);
                    });
                    this.on("sendingmultiple", function() {

                    });

                    this.on("successmultiple", function(files, response) {

                    });

                    this.on("errormultiple", function(files, response) {

                    });
                }
            });
        });
    </script>
@endsection
