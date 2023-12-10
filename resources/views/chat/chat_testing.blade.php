@extends('backend.layouts.app')
<style>
    body {
        background-color: #f4f7f6;
        margin-top: 20px;
    }

    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }

    .chat-app .people-list {
        width: 280px;
        position: absolute;
        left: 0;
        top: 0;
        padding: 20px;
        z-index: 7
    }

    .chat-app .chat {
        margin-left: 280px;
        border-left: 1px solid #eaeaea
    }

    .people-list {
        -moz-transition: .5s;
        -o-transition: .5s;
        -webkit-transition: .5s;
        transition: .5s
    }

    .people-list .chat-list li {
        padding: 10px 15px;
        list-style: none;
        border-radius: 3px
    }

    .people-list .chat-list li:hover {
        background: #efefef;
        cursor: pointer
    }

    .people-list .chat-list li.active {
        background: #efefef
    }

    .people-list .chat-list li .name {
        font-size: 15px
    }

    .people-list .chat-list img {
        width: 45px;
        border-radius: 50%
    }

    .people-list img {
        float: left;
        border-radius: 50%
    }

    .people-list .about {
        float: left;
        padding-left: 8px
    }

    .people-list .status {
        color: #999;
        font-size: 13px
    }

    .chat .chat-header {
        padding: 15px 20px;
        border-bottom: 2px solid #f4f7f6
    }

    .chat .chat-header img {
        float: left;
        border-radius: 40px;
        width: 40px
    }

    .chat .chat-header .chat-about {
        float: left;
        padding-left: 10px
    }

    .chat .chat-history {
        padding: 20px;
        border-bottom: 2px solid #fff
    }

    .chat .chat-history ul {
        padding: 0
    }

    .chat .chat-history ul li {
        list-style: none;
        margin-bottom: 30px
    }

    .chat .chat-history ul li:last-child {
        margin-bottom: 0px
    }

    .chat .chat-history .message-data {
        margin-bottom: 15px
    }

    .chat .chat-history .message-data img {
        border-radius: 50%;
        width: 40px;
        object-fit: cover;
    }

    .chat .chat-history .message-data-time {
        color: #434651;
        padding-left: 6px
    }

    .chat .chat-history .message {
        color: #444;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 7px;
        display: inline-block;
        position: relative
    }

    .chat .chat-history .message:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #fff;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .my-message {
        background: #efefef
    }

    .chat .chat-history .my-message:after {
        bottom: 100%;
        left: 30px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #efefef;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .other-message {
        background: #e8f1f3;
        text-align: right
    }

    .chat .chat-history .other-message:after {
        border-bottom-color: #e8f1f3;
        left: 93%
    }

    .chat .chat-message {
        padding: 20px
    }

    .online,
    .offline,
    .me {
        margin-right: 2px;
        font-size: 8px;
        vertical-align: middle
    }

    .online {
        color: #86c541
    }

    .offline {
        color: #e47297
    }

    .me {
        color: #1d8ecd
    }

    .float-right {
        float: right
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0
    }

    @media only screen and (max-width: 767px) {
        .chat-app .people-list {
            height: 465px;
            width: 100%;
            overflow-x: auto;
            background: #fff;
            left: -400px;
            display: none
        }

        .chat-app .people-list.open {
            left: 0
        }

        .chat-app .chat {
            margin: 0
        }

        .chat-app .chat .chat-header {
            border-radius: 0.55rem 0.55rem 0 0
        }

        .chat-app .chat-history {
            height: 300px;
            overflow-x: auto
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 992px) {
        .chat-app .chat-list {
            height: 650px;
            overflow-x: auto
        }

        .chat-app .chat-history {
            height: 600px;
            overflow-x: auto
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
        .chat-app .chat-list {
            height: 480px;
            overflow-x: auto
        }

        .chat-app .chat-history {
            height: calc(100vh - 350px);
            overflow-x: auto
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
                        <h1 class="m-0">Chat</h1>
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
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card chat-app">
                        <div id="plist" class="people-list">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input id="search-input" type="text" class="form-control" placeholder="Search...">
                            </div>
                            <ul class="list-unstyled chat-list mt-2 mb-0" id="chatlist"
                                style="height: 450px; overflow-y: scroll;">

                            </ul>
                        </div>
                        <div class="chat">
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                        </a>
                                        <div class="chat-about">
                                            <h6 class="m-b-0">
                                                <a href="{{ route('user-profile', ['user_id' => $user_id]) }}"
                                                    id="user-name">{{ $receiverName }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#transferModal">
                                            <i class="fas fa-money-bill-wave"></i> Transfer
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-history" style="height: 400px; overflow-y: scroll;">
                                <ul class="m-b-0" id="message-list">
                                    <!-- Messages will be dynamically inserted here -->
                                </ul>
                            </div>
                            <form id="send-message-form" method="POST">
                                @csrf
                                <div class="chat-message clearfix">
                                    <div class="input-group mb-0">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-send"></i></span>
                                        </div>
                                        <!-- Form to send a new message -->
                                        <input type="hidden" name="receiver_id" id="receiver_id"
                                            value="{{ $user_id }}">
                                        <input type="text" class="form-control" placeholder="Type your message"
                                            id="message" name="message">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Transfer Funds</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Add your transfer form here -->
                    <form id="transferForm" action="{{ route('wallet.transfer') }}" method="post">
                        @csrf
                        <!-- Transfer form fields -->
                        <!-- Example: -->
                        <div class="form-group">
                            <label for="recipient">Recipient Email</label>
                            <!-- Check exist of $user->email -->
                            @if (isset($user->email))
                                <input type="email" class="form-control" id="recipient" name="recipient"
                                    value="{{ $user->email }}" required readonly>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <!-- Add a number input field -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RM</span>
                                </div>
                                <!-- Add a number input field -->
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <small>Your can transfer up to: RM {{ auth()->user()->wallet->balance }}</small>

                        </div>
                        @if (isset($user->id))
                            <input type="hidden" name="recipient" id="recipient" value="{{ $user->id }}">
                        @endif
                </div>
                <div class="modal-footer">
                    <!-- Submit button for the transfer -->
                    <button type="submit" class="btn btn-primary">Transfer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Event listener for search input
        $('#search-input').on('keyup', function() {
            var searchQuery = $(this).val().toLowerCase();
            // console.log(searchQuery);
            // Filter the list items based on search query
            // var userName = $('#user_name').text();
            // console.log(userName);
            $('#chatlist li').each(function() {
                var userName = $(this).find('#user_name').text().toLowerCase();
                console.log(userName);
                console.log(searchQuery)
                if (userName.includes(searchQuery)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        function asset(path) {
            var url = new URL(path, window.location.origin);
            return url.href;
        }
        // Update the user name
        var userDisplayName = "{{ $receiverName }}";

        // Function to update the message list
        function updateMessageList(messages) {
            var messageList = $('#message-list');
            messageList.empty(); // Clear the existing messages

            // Loop through the messages and append them to the message list
            messages.forEach(function(message) {
                var senderName = message.sender_name;
                var receiverName = message.receiver_name;
                var messageText = message.message;
                var messageTime = formatDateTime(message.created_at);
                var sender_avatar = message.sender_image_path ||
                    "https://bootdey.com/img/Content/avatar/avatar7.png";
                var receiver_avatar = message.receiver_image_path ||
                    "https://bootdey.com/img/Content/avatar/avatar7.png";


                var listItem = $('<li class="clearfix"></li>');
                var messageData = $('<div class="message-data"></div>');
                var messageDataTime = $('<span class="message-data-time"></span>').text(messageTime);
                var avatarPath = receiverName === userDisplayName ? receiver_avatar : sender_avatar;
                var avatarSrc = asset(avatarPath);
                // var avatar = $('<img src="' + avatarSrc + '"alt="avatar">');
                var avatar = $(
                    '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">'
                );
                var messageContent = $('<div class="message"></div>').text(messageText);

                if (receiverName === userDisplayName) {
                    listItem.addClass('clearfix');
                    listItem.append(
                        $('<div class="message-data text-right"></div>').append(messageDataTime,
                            avatar)
                    );
                    listItem.append($('<div class="message other-message float-right"></div>').text(
                        messageText));
                } else {
                    listItem.addClass('clearfix');
                    listItem.append(messageData.append(messageDataTime, avatar));
                    listItem.append(messageContent.addClass('my-message'));
                }

                // Append the message item to the message list
                messageList.append(listItem);
            });
        }

        // Function to format the date and time
        function formatDateTime(dateString) {
            var formattedDate = new Date(dateString);

            var year = formattedDate.getFullYear();
            var month = ('0' + (formattedDate.getMonth() + 1)).slice(-2);
            var day = ('0' + formattedDate.getDate()).slice(-2);
            var hour = ('0' + (formattedDate.getHours() % 12 || 12)).slice(-2);
            var minute = ('0' + formattedDate.getMinutes()).slice(-2);
            var second = ('0' + formattedDate.getSeconds()).slice(-2);
            var ampm = formattedDate.getHours() >= 12 ? 'PM' : 'AM';

            var formattedDateString = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' +
                second + ' ' + ampm;

            return formattedDateString;
        }

        // Event listener for the message form submission
        $('#send-message-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the form data
            var formData = $(this).serialize();

            // Send the AJAX request
            $.ajax({
                url: "{{ route('chat.send') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    // Handle the successful response
                    console.log(
                        response); // You can do something with the response if needed
                    // Clear the input field
                    $('#send-message-form input[name="message"]').val('');

                    // Fetch the updated chat messages
                    fetchChatMessages();
                },
                error: function(error) {
                    // Handle the error
                    console.log(error);
                }
            });
        });

        // Fetch and update the chat messages
        function fetchChatMessages() {
            var receiver_id = $('#receiver_id').val();
            // Send the AJAX request to fetch the messages
            $.ajax({
                url: "{{ route('chat.messages_chat', ['user_id' => $user_id]) }}",
                type: "GET",
                success: function(response) {
                    // Handle the successful response
                    console.log(response); // You can do something with the response if needed
                    var messages = response.messages;
                    // Update the message list with the fetched messages
                    updateMessageList(messages);
                },
                error: function(error) {
                    // Handle the error
                    console.log(error);
                },
                complete: function() {
                    // Call the function again after 5 seconds (5000 milliseconds)
                    setTimeout(fetchChatMessages, 5000);
                    setTimeout(fetchUserChat, 5000);
                }
            });
        }

        // Call the fetchChatMessages function to initially load the chat messages
        fetchChatMessages();

        function fetchUserChat() {
            var receiver_id = $('#receiver_id').val();
            // Send the AJAX request to fetch the messages
            $.ajax({
                url: "{{ route('chat.userChat', ['user_id' => $user_id]) }}",
                type: "GET",
                success: function(response) {
                    // Handle the successful response
                    console.log(response); // You can do something with the response if needed
                    var messages = response.messages;
                    // Update the message list with the fetched messages
                    // Update the message list with the fetched messages
                    var chatList = $('.chat-list');
                    chatList.empty(); // Clear existing list

                    messages.forEach(function(message) {
                        var listItem = $('<li class="clearfix"></li>');
                        var chatUrl = '{{ url('chat') }}/' + message.user_id;
                        var chatLink = $('<a></a>').attr('href', chatUrl);
                        var date = formatDateTime(message.created_at);

                        chatLink.click(function() {
                            var userId = $(this).attr('data-user-id');
                            window.location.href = '{{ url('chat') }}/' + userId;
                        });

                        chatLink.attr('data-user-id', message.user_id);
                        if (message.image_path == null) {
                            var avatar = $(
                                '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">'
                            );
                        } else {
                            var avatar = $(
                                '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">'
                            );
                            // var avatar = $('<img src="' + message.image_path +
                            //     '" alt="avatar">');
                        }

                        var about = $('<div class="about"></div>');
                        var name = $('<div class="name" id="user_name">' + message
                            .user_name + '</div>');
                        var status = $('<div class="status">' + date + '</div>');

                        about.append(name);
                        about.append(status);

                        chatLink.append(avatar);
                        chatLink.append(about);
                        listItem.append(chatLink);
                        if (userDisplayName === message.user_name) {
                            $('.chat-list li').removeClass('active');
                            listItem.addClass('active');
                        }
                        chatList.append(listItem);
                    });

                },
                error: function(xhr, status, error) {
                    // Handle the error
                    console.log(error);
                },
            });
        }

        fetchUserChat();

        $('#transferForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Send form data using AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    toastr.success('Transfer successful!');
                    // Refresh modal content on success
                    $('#transferModal').modal('hide'); // Hide the modal
                    $('#transferModal').on('hidden.bs.modal', function(e) {
                        $(this).find('.modal-content').load(location.href +
                            ' .modal-content');
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error if necessary
                    toastr.error('Transfer failed');
                }
            });
        });
    });
</script>
