@extends('backend.layouts.app')
@section('content')

    <style>
        /* Style for the delete button */
        .delete-button {
            background-color: #dc3545;
            /* Red background color */
            color: #fff;
            /* Text color */
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the delete button */
        .delete-button:hover {
            background-color: #c82333;
            /* Darker red on hover */
        }

        /* Style for the icon inside the delete button */
        .delete-button i {
            margin-right: 5px;
            /* Adjust the icon's spacing */
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Announcements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
                            <li class="breadcrumb-item active">Edit Announcement</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Announcement</h3>
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
                                        action="{{ route('announcements.updateData', $announcement->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="announcement_id" name="announcement_id"
                                            id="announcement_id" value="">
                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                value="{{ old('title', $announcement->title) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Content:</label>
                                            <textarea name="content" id="content" class="form-control" rows="4">{{ old('content', $announcement->content) }}</textarea>
                                        </div>
                                        <!-- Dropzone container -->
                                        <div class="form-group">
                                            <label for="announcement_image">Images</label>
                                            <div class="row" id="image-list" style="margin-bottom: 15px;">
                                                <!-- Display the list of uploaded images here -->
                                                @if ($images)
                                                    @foreach ($images as $image)
                                                        <div class="col-md-3">
                                                            <div class="image-item" name="image-item" id="image-item">
                                                                <img src="{{ asset($image['path']) }}"
                                                                    alt="Announcement Image" class="img-fluid">
                                                                <button class="delete-button" id="delete-button"
                                                                    data-image="{{ $image['path'] }}">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="dropzone" id="image-dropzone" name="image-dropzone"></div>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="file">File (PDF, DOC, DOCX):</label>
                                            <input type="file" name="file" id="file" class="form-control-file">
                                            @if ($announcement->file)
                                                <p><a href="{{ asset('storage/' . $announcement->file) }}"
                                                        target="_blank">{{ $announcement->file }}</a></p>
                                            @endif
                                        </div> --}}
                                        <button type="submit" class="btn btn-primary">Update</button>
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
                url: "{{ route('announcements.edit.updateImage') }}", // Set the URL where the images will be uploaded
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
                                    $("#announcement_id").val(
                                        {{ $announcement->id }}
                                    ); // inseting userid into hidden input field
                                    //process the queue
                                    myDropzone.processQueue();

                                    // Display the success message
                                    toastr.success(result.message);
                                    toastr.info(
                                        'Redirecting you to the announcement page in <span id="countdown">3</span> seconds'
                                    );

                                    var redirectUrl =
                                        "{{ route('announcements.show', $announcement->id) }}"; // Replace 'show' with the actual route name and $id with the desired value

                                    var countdownElement = document.getElementById(
                                        'countdown');
                                    var countdown = 3;

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
                                    console.log("error");
                                }
                            }
                        });
                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        formData.append('announcement_id', {{ $announcement->id }});
                    });

                    this.on("success", function(file, response) {
                        toastr.success(response.message);
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


            // Get all delete buttons
            const deleteButtons = document.querySelectorAll('#delete-button');

            // Add click event listeners to each delete button
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var imageToDelete = this.dataset.image;
                    $.ajax({
                        url: "{{ route('announcements.deleteImage') }}", // Replace with the actual URL endpoint for deleting the image
                        type: 'POST',
                        data: {
                            image: imageToDelete,
                            id: {{ $announcement->id }},
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Handle the success response
                            console.log(response);

                            // You can update the UI or perform any other action after successful deletion
                            //remove the image from the list
                            // Show success notification using Toastr
                            toastr.success('Image deleted successfully');
                            // Remove the image item from the DOM
                            const imageItem = button.closest('.col-md-3');
                            imageItem.remove();
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(error);
                            // You can display an error message or perform any other error handling
                        }
                    });
                });
            });
        });
    </script>
@endsection
