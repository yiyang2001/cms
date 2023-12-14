@extends('backend.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
    <link href="{{ asset('css/user-profile.css') }}" rel="stylesheet">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Profile</h1>
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
        <section>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        @if ($user->image_path)
                                            <img src="{{ asset($user->image_path) }}" alt="User Image"
                                                class="rounded-circle img-fluid"
                                                style="height: 150px; width: 150px; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                                alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                        @endif
                                        <h5 class="my-3">{{ $user->name }}</h5>
                                        {{-- <p class="text-muted mb-1">Full Stack Developer</p>
                                <p class="text-muted mb-4">Bay Area, San Francisco, CA</p> --}}
                                        <div class="stars">
                                            {{ $averageRating }}
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($averageRating))
                                                    <span class="filled">&#9733;</span>
                                                @else
                                                    <span class="empty">&#9734;</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="mb-4">
                                            <span class="fas fa-star-half-alt"></span> {{ $totalReviews }}
                                            person reviewed
                                        </div>

                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="button" class="btn btn-outline-primary ms-1">
                                                <a href="{{ route('chat.chat', ['user_id' => $user->id]) }}"
                                                    id="chatButton">
                                                    Message
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-info">
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#socialMediaModal">
                                Edit Social Media
                            </button> --}}
                                    <div class="card-header">
                                        <h3 class="card-title">About My Social Media</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                                <p class="mb-0"><a href="{{ $instagramProfileUrl }}"
                                                        target="_blank">{{ $instagramUsername }}</a>
                                            </li>

                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>

                                                <p class="mb-0">{{ $user->social_media['facebook'] }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">About Me</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Full Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->name }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Phone</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->phone_no }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Bio</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->bio }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Location</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->location }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Education</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->education }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Occupation</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->occupation }}</p>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#editModal">
                                            Edit Details
                                        </button>
                                    </div>
                                </div> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Additional content or sections -->
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Display average rating -->
                                        <div class="col-md-4 offset-md-1">
                                            <div class="rating-block">
                                                <h4>Average User Rating</h4>
                                                <h2 class="bold padding-bottom-7">{{ $averageRating }} <small>/
                                                        5</small></h2>
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= round($averageRating))
                                                            <span class="filled">&#9733;</span>
                                                        @else
                                                            <span class="empty">&#9734;</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div>
                                                    <span class="fas fa-star-half-alt"></span> {{ $totalReviews }}
                                                    person reviewed
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5">
                                            <!-- Display Rating Breakdown -->
                                            <div class="rating-breakdown">
                                                <h4>Rating breakdown</h4>
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <span class="filled">&#9733;</span>{{ $i }}
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="progress">
                                                                @php
                                                                    $percentage = $percentages[$i] ?? 0; // Get percentage value
                                                                @endphp
                                                                <div class="progress-bar progress-bar-success"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                                    aria-valuemax="100"
                                                                    style="width: {{ $percentage }}%">
                                                                    <span class="sr-only">{{ $percentage }}%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Display the number of users who rated -->
                                                        <div class="col-md-1">
                                                            {{ $ratingBreakdown[$i] ?? 0 }}
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <hr />

                                    <!-- Display User Reviews -->
                                    <div class="col-md-10 offset-md-1">
                                        <div class="review-block">
                                            @if ($reviews->isEmpty())
                                                <span class="text-center">
                                                    <p>No review available.</p>
                                                </span>
                                            @else
                                                @foreach ($reviews as $review)
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image"
                                                                class="img-rounded">
                                                            <div class="review-block-name"><a
                                                                    href="{{ route('user-profile', $review->user_id) }}">{{ $review->reviewer->name }}</a>
                                                            </div>
                                                            <div class="review-block-date">
                                                                {{ $review->created_at->format('M d, Y') }}<br />
                                                                {{ $review->created_at->format('h:i A') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <div class="review-block-rate">
                                                                <div class="star">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= round($review->rating))
                                                                            <span class="filled">&#9733;</span>
                                                                        @else
                                                                            <span class="empty">&#9734;</span>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="review-block-title"></div>
                                                            <div class="review-block-description">{{ $review->content }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                @endforeach
                                                <div class="d-flex justify-content-center">
                                                    {{ $reviews->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if (auth()->check() && auth()->user()->id !== $user->id)
                                        <div class="col-md-10 offset-md-1">
                                            <div class="add-review-block">
                                                <form id="reviewForm"
                                                    action="{{ route('user.submit_review', $user->id) }}" method="POST">
                                                    @csrf
                                                    <h4>Add a Review</h4>
                                                    <div class="form-group">
                                                        <label for="rating">Rating:</label>
                                                        <div class="rating-stars">
                                                            <input type="hidden" name="rating" id="rating"
                                                                value="0">
                                                            <span class="star" data-value="1">&#9733;</span>
                                                            <span class="star" data-value="2">&#9733;</span>
                                                            <span class="star" data-value="3">&#9733;</span>
                                                            <span class="star" data-value="4">&#9733;</span>
                                                            <span class="star" data-value="5">&#9733;</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="content">Review</label>
                                                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Your Review"></textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="button" class="btn btn-primary"
                                                                id="submitReview">Submit Review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script>
    $(document).ready(function() {
        // Keep selected stars highlighted on hover
        $('.rating-stars .star').on('mouseenter', function() {
            const value = $(this).data('value');
            $('.rating-stars .star').removeClass('hover');
            $(this).prevAll('.star').addBack().addClass('hover');
        });

        // Keep selected stars highlighted when the mouse leaves the stars
        $('.rating-stars').on('mouseleave', function() {
            $('.rating-stars .star').removeClass('hover');
            $('.rating-stars .star.selected').prevAll('.star').addBack().addClass('hover');
        });

        // Select stars on click
        $('.rating-stars .star').on('click', function() {
            const value = $(this).data('value');
            $('#rating').val(value);
            $('.rating-stars .star').removeClass('selected');
            $(this).prevAll('.star').addBack().addClass('selected');
        });

        $('#submitReview').on('click', function() {
            const selectedRating = $('.rating-stars .star.selected').length;
            if (selectedRating < 1) {
                event.preventDefault(); // Prevent form submission if rating is less than 1
                alert('Please select a minimum rating of one star.');
                return false;
            }
            const formData = $('#reviewForm').serialize();

            $.ajax({
                url: "{{ route('user.submit_review', $user->id) }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.status === 'fail') {
                        toastr.error(response.message);
                        return false;
                    }
                    $('#reviewForm')[0].reset();
                    toastr.success(response.message);
                    fetchRatingInfo(userId);
                    // You can redirect or display a success message here
                },
                error: function(xhr) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });
        });

        function fetchRatingInfo(userId) {
            $.ajax({
                url: `/user/${userId}/rating-info`,
                type: 'GET',
                success: function(response) {
                    const averageRating = response.averageRating;
                    const maxRating = 5; // Maximum rating value
                    const ratingData = response.ratingData;
                    const ratingBreakdown = response.ratingBreakdown;
                    const reviewsData = response.reviewsData;
                    console.log(ratingData);
                    console.log(ratingBreakdown);
                    console.log(reviewsData);
                    let starsHTML =
                        `<h4>Average User Rating</h4><h2 class="bold padding-bottom-7">${averageRating} <small>/
                                                        5</small></h2><div class="stars">`;

                    for (let i = 1; i <= maxRating; i++) {
                        if (i <= averageRating) {
                            starsHTML += '<span class="filled">&#9733; </span>';
                        } else {
                            starsHTML += '<span class="empty">&#9734; </span>';
                        }
                    }
                    starsHTML += '</div><div><span class="fas fa-star-half-alt"></span> ' + response
                        .totalReviews + ' person reviewed</div>';

                    $('.rating-block').html(starsHTML);

                    let ratingBreakdownHTML = '<h4>Rating breakdown</h4>';

                    for (let i = 5; i >= 1; i--) {
                        ratingBreakdownHTML += `
                            <div class="row">
                                <div class="col-md-2">
                                    <span class="filled">&#9733;</span>${i}
                                </div>
                                <div class="col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success"
                                            role="progressbar"
                                            aria-valuenow="${ratingData[i] ? ratingData[i] : 0}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            style="width: ${ratingData[i] ? ratingData[i] : 0}%">
                                            <span class="sr-only">${ratingData[i] ? ratingData[i]: 0}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    ${ratingBreakdown[i] ? ratingBreakdown[i] : 0}
                                </div>
                            </div>`;
                    }

                    $('.rating-breakdown').html(ratingBreakdownHTML);

                    let reviewBlockHTML = '';

                    if (reviewsData.length === 0) {
                        reviewBlockHTML += `
                            <span class="text-center">
                                <p>No review available.</p>
                            </span>`;
                    } else {
                        reviewsData.forEach(review => {
                            reviewBlockHTML += `
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                        <div class="review-block-name">
                                            <a href="/user-profile/${review.user_id}">${review.name}</a>
                                        </div>
                                        <div class="review-block-date">
                                            ${new Date(review.created_at).toLocaleDateString()}<br />
                                            ${new Date(review.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="review-block-rate">
                                            <div class="star">`;

                            for (let i = 1; i <= 5; i++) {
                                if (i <= Math.round(review.rating)) {
                                    reviewBlockHTML +=
                                        '<span class="filled">&#9733;</span>';
                                } else {
                                    reviewBlockHTML += '<span class="empty">&#9734;</span>';
                                }
                            }

                            reviewBlockHTML += `
                                        </div>
                                    </div>
                                    <div class="review-block-description">${review.content}</div>
                                </div>
                            </div>
                            <hr />`;
                        });
                    }

                    $('.review-block').html(reviewBlockHTML);

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    // Handle errors if any
                }
            });
        }

        // Call fetchRatingInfo function on document load
        const userId = '{{ $user->id }}';
        // fetchRatingInfo(userId);
    });


    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function uploadImage() {
        // Submit the form when the "Upload" button is clicked
        document.querySelector('#uploadModal form').submit();
    }
</script>
