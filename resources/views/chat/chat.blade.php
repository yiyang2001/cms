@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Chat</div>
                    <div class="card-body">
                        <!-- Display the chat messages -->
                        <div id="chat-messages">
                            @foreach ($messages as $message)
                                <div>
                                    <strong>{{ $message->sender->name }}:</strong> {{ $message->message }}
                                </div>
                            @endforeach
                        </div>
                        <!-- Form to send a new message -->
                        <form id="send-message-form" action="{{ route('chat.send', ['receiver_id' => $user_id]) }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Type your message" name="message">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


// // Handle form submit event
// $('#send-message-form').on('submit', function(event) {
//     event.preventDefault(); // Prevent the default form submission
//     // fetchChatMessages();
//     // Get the form data
//     var formData = $(this).serialize();

//     // Send the AJAX request
//     $.ajax({
//         url: "{{ route('chat.send') }}",
//         type: "POST",
//         data: formData,
//         success: function(response) {
//             // Handle the successful response
//             console.log(
//                 response); // You can do something with the response if needed
//             // Clear the input field
//             $('#send-message-form input[name="message"]').val('');
//             // Fetch the updated chat messages
//             fetchChatMessages();
//         },
//         error: function(error) {
//             // Handle the error
//             // console.log(error);
//         }
//     });
// });

// function fetchChatMessages() {
//     // Get the receiver_id value
//     var receiverId = $('#send-message-form input[name="receiver_id"]').val();

//     // Make an AJAX request to get the updated chat messages
//     $.ajax({
//         url: "{{ route('chat.messages_chat') }}",
//         type: "GET",
//         data: {
//             receiver_id: receiverId
//         }, // Pass the receiver_id as a parameter
//         success: function(response) {
//             // Update the chat messages container with the new messages
//             var messagesHtml = '';

//             Object.values(response.messages).forEach(function(message) {
//                 messagesHtml += '<div>';
//                 messagesHtml += '<strong>' + message.user_name + ':</strong> ' +
//                     message.message;
//                 messagesHtml += '</div>';
//             });

//             $('#chat-messages').html(messagesHtml);
//             console.log(response);
//         },
//         error: function(error) {
//             // Handle the error
//             console.log(error);
//         },
//         complete: function() {
//             // Call the function again after 5 seconds (5000 milliseconds)
//             setTimeout(fetchChatMessages, 5000);
//         }
//     });
// }

// fetchChatMessages(); // Fetch chat messages on page load


<li class="clearfix">
    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
    <div class="about">
        <div class="name">Vincent Porter</div>
        <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
    </div>
</li>
<li class="clearfix active">
    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
    <div class="about">
        <div class="name">Aiden Chavez</div>
        <div class="status"> <i class="fa fa-circle online"></i> online </div>
    </div>
</li>
<li class="clearfix">
    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
    <div class="about">
        <div class="name">Mike Thomas</div>
        <div class="status"> <i class="fa fa-circle online"></i> online </div>
    </div>
</li>
<li class="clearfix">
    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
    <div class="about">
        <div class="name">Christian Kelly</div>
        <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div>
    </div>
</li>
<li class="clearfix">
    <img src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="avatar">
    <div class="about">
        <div class="name">Monica Ward</div>
        <div class="status"> <i class="fa fa-circle online"></i> online </div>
    </div>
</li>
<li class="clearfix">
    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
    <div class="about">
        <div class="name">Dean Henry</div>
        <div class="status"> <i class="fa fa-circle offline"></i> offline since Oct 28
        </div>
    </div>
</li>


                                    {{-- <div class="col-lg-6 hidden-sm text-right">
                                        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i
                                                class="fa fa-camera"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-outline-primary"><i
                                                class="fa fa-image"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-outline-info"><i
                                                class="fa fa-cogs"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-outline-warning"><i
                                                class="fa fa-question"></i></a>
                                    </div> --}}


                                    
                                    // Function to get the current time in format HH:mm AM/PM
                                    function getCurrentTime() {
                                        var now = new Date();
                                        var hours = now.getHours();
                                        var minutes = now.getMinutes();
                                        var ampm = hours >= 12 ? 'PM' : 'AM';
                                        hours = hours % 12;
                                        hours = hours ? hours : 12;
                                        minutes = minutes < 10 ? '0' + minutes : minutes;
                                        var time = hours + ':' + minutes + ' ' + ampm;
                                        return time;
                                    }

                                    $(document).ready(function() {

                                        // Hide all tabs initially except the first one
                                        $('.people-list').not(':first').hide();
                                
                                        // Add click event handler for tab selection
                                        $('.chat-list li').click(function() {
                                            // Remove 'active' class from all tabs
                                            $('.chat-list li').removeClass('active');
                                
                                            // Add 'active' class to the clicked tab
                                            $(this).addClass('active');
                                
                                            // Get the index of the clicked tab
                                            var index = $(this).index();
                                
                                            // Show the corresponding content tab and hide others
                                            $('.people-list').eq(index).show().siblings('.people-list').hide();
                                        });
                                
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
                                                // var messageTime = getCurrentTime();
                                                var messageTime = formatDateTime(message.created_at);
                                                var sender_avater = message.sender_image_path;
                                                var receiver_avater = message.receiver_image_path;
                                
                                                var listItem = $('<li class="clearfix"></li>');
                                                var messageData = $('<div class="message-data"></div>');
                                                var messageDataTime = $('<span class="message-data-time"></span>').text(messageTime);
                                                var avatar = $(
                                                    '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">');
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
                                
                                
                                
                                
                                        function formatDateTime(dateString) {
                                            var formattedDate = new Date(dateString);
                                
                                            var year = formattedDate.getFullYear();
                                            var month = ('0' + (formattedDate.getMonth() + 1)).slice(-2);
                                            var day = ('0' + formattedDate.getDate()).slice(-2);
                                            // var hour = ('0' + formattedDate.getHours() % 12).slice(-2);
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
                                                    // $('#message-input').val('');
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
                                                    console.log("Error status: " + status);
                                                    console.log("Error message: " + error);
                                                    console.log("Error response: " + xhr.responseText);
                                                },
                                                complete: function() {
                                                    // Call the function again after 5 seconds (5000 milliseconds)
                                                    // setTimeout(fetchChatMessages, 5000);
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
                                                    var date = formatDateTime(response.messages[0].created_at);
                                
                                                    // Update the message list with the fetched messages
                                                    var chatList = $('.chat-list');
                                                    chatList.empty(); // Clear existing list
                                
                                                    messages.forEach(function(message) {
                                                        var listItem = $('<li class="clearfix"></li>');
                                                        if (message.image_path == null) {
                                                            var avatar = $(
                                                                '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">'
                                                                );
                                                        } else {
                                                            var avatar = $('<img src="' + message.image_path +
                                                                '" alt="avatar">');
                                                        }
                                                        var about = $('<div class="about"></div>');
                                                        var name = $('<div class="name">' + message.user_name + '</div>');
                                                        var status = $('<div class="status">' + date + '</div>');
                                
                                                        about.append(name);
                                                        about.append(status);
                                
                                                        listItem.append(avatar);
                                                        listItem.append(about);
                                
                                                        chatList.append(listItem);
                                                    });
                                
                                                    // Hide all tabs initially except the first one
                                                    $('.people-list').not(':first').hide();
                                
                                                    // Add click event handler for tab selection
                                                    $('.chat-list li').click(function() {
                                                        // Remove 'active' class from all tabs
                                                        $('.chat-list li').removeClass('active');
                                
                                                        // Add 'active' class to the clicked tab
                                                        $(this).addClass('active');
                                
                                                        // Get the index of the clicked tab
                                                        var index = $(this).index();
                                
                                                        // Show the corresponding content tab and hide others
                                                        $('.people-list').eq(index).show().siblings('.people-list').hide();
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    // Handle the error
                                                    console.log(error);
                                                    console.log("Error status: " + status);
                                                    console.log("Error message: " + error);
                                                    console.log("Error response: " + xhr.responseText);
                                                },
                                            });
                                        }
                                
                                        fetchUserChat();
                                
                                    });F