<?php if ($_settings->userdata('type') != 1) : ?>


    <div class="chat-btn">
        <button class="btn btn-success btn-lg rounded-pill" id="openChatBtn">Chat</button>
    </div>
    <div class="card  w-50   direct-chat direct-chat-primary" style="z-index: 4; " id="newConvo">
        <div class="row">
            <div class="col-5 ">
                <div class="card  h-100 mb-0">
                    <div class="card-header">
                        <div class="input-group search">

                            <input type="text" placeholder="Search..." id=" Search" name="name_search" class="form-control search">

                        </div>
                    </div>
                    <div class="card-body p-2" style="height: 250px ;">
                        <div class=" users-list">

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-7">
                <div class="card h-100 mb-0">
                    <div class="card-header  ">
                        <div class="row">
                            <div class="col-8">
                                <div>

                                    <img class="direct-chat-img  border-1 border-primary mr-2" id="user-img" src="" alt="" />
                                    <span class="chatName ml-1 text-capitalize font-weight-bold"></span>
                                    <p class="status  text-capitalize font-weight-bold"></p>
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-tool " id="minimize">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>


                        </div>
                    </div>
                    <div class="card-body bg-light p-2">
                        <div class="direct-chat-messages">
                            <?php if ($_settings->userdata('type') == 2) : ?>
                                <p>Select any Driver User</p>
                            <?php elseif ($_settings->userdata('type') == 3) : ?>
                                <p>Welcome to chat support of CTMO Select any of our officer if you have any question</p>
                            <?php endif ?>

                        </div>
                        <div class="end-convo"></div>
                        <!-- /.direct-chat-pane -->
                    </div>
                    <div class="card-footer">
                        <form id="send_chat" action="">
                            <div class="input-group">
                                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $_settings->userdata('unique_id'); ?>" hidden>
                                <input type="text" class="unique_id" name="unique_id" hidden>
                                <textarea name="message" class="form-control type_msg" class="message" placeholder="Type your message..."></textarea>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="d-none" id="sent_message">
    <div class="direct-chat-msg right  ml-4">
        <img class="direct-chat-img border-1 border-primary" src="<?php echo validate_image($_settings->userdata('avatar')) ?>" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text "></div>
        <!-- /.direct-chat-text -->
    </div>
</div>
<div class="d-none" id="receive_message">
    <div class="direct-chat-msg mr-4">
        <img class="direct-chat-img border-1 border-primary" src="<?php echo validate_image($_settings->info('bot_avatar')) ?>" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">

        </div>
        <!-- /.direct-chat-text -->

    </div>
</div>

<a href="#" class="d-none" id="allUsers">
    <div class="content">
        <img class="direct-chat-img border-1 border-primary mr-2" src="" alt="message user image">
        <div class="details">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="text-capitalize name"></span>
                    <div>
                        <span class="uniq" style="display: none;"></span>

                        <p class="message"></p>

                    </div>
                </div>
                <div class="status-dot align-self-center" style="font-size: 10px;"><i class="fas fa-circle "></i></div>
            </div>

        </div>
    </div>
</a>


<script>
    $(document).ready(function() {
        $('[name="message"]').keypress(function(e) {
            if (e.which === 13 && e.originalEvent.shiftKey == false) {
                $('#send_chat').submit();
                return false;
            }
        })

        $('#send_chat').submit(function(e) {
            e.preventDefault();
            start_loader()
            var message = $('[name="message"]').val();
            var incoming_id = $('[name="incoming_id"]').val();
            var unique_id = $('[name="unique_id"]').val();

            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=insert_chat',
                type: 'POST',
                data: {
                    message: message,
                    incoming_id: incoming_id, // Pass the unique_id here
                    unique_id: unique_id,
                },
                success: function(resp) {
                    if (resp == 1) {
                        var message = $('[name="message"]').val();
                        if (message == '' || message == null) return false;
                        $('[name="message"]').val('');

                    }

                    end_loader()
                }
            });

        })

        //Set Interval for List of User
        setInterval(() => {


            //Display all Drivers
            $.ajax({
                url: _base_url_ + 'classes/Users.php?f=display_user',
                type: 'POST',
                dataType: 'json',


                success: function(resp) {
                    if (resp) {
                        if (resp) {
                            var usersList = $('#newConvo .users-list');
                            usersList.empty();

                            resp.forEach(function(user) {
                                var allUsers = $('#allUsers').clone();
                                allUsers.find('.name').html(user.name);
                                allUsers.find('.message').html(user.last_message);
                                allUsers.find('.uniq').html(user.unique_id);
                                allUsers.find('.direct-chat-img').attr("src", "../" + user.avatar);
                                var statusDot = allUsers.find('.status-dot i');
                                if (user.status === "Online") {
                                    statusDot.addClass("text-success").removeClass("text-secondary");
                                } else {
                                    statusDot.addClass("text-secondary").removeClass("text-success");
                                }
                                $('#newConvo .users-list').append(allUsers.html());


                            });

                        }

                    }
                }
            });

        }, 500);




        setInterval(() => {

            var incoming_id = $('[name="incoming_id"]').val();
            var unique_id = $('[name="unique_id"]').val();
            var messages = $('#newConvo .direct-chat-messages');

            // Save current scroll position and height
            var shouldScrollBottom = (messages.prop('scrollHeight') - messages.scrollTop() === messages.outerHeight());

            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_chat',
                type: 'POST',
                data: {
                    incoming_id: incoming_id,
                    unique_id: unique_id,
                },
                dataType: 'json',
                success: function(resp) {
                    if (resp) {
                        var html = '';
                        for (var i = 0; i < resp.length; i++) {
                            var message = resp[i];
                            var uchat;

                            if (message.status == 1) {
                                uchat = $('#sent_message').clone();
                            } else {
                                uchat = $('#receive_message').clone();

                            }

                            uchat.find('.direct-chat-text').html(message.msg);
                            html += uchat.html();
                        }

                        messages.html(html);

                        // Scroll to bottom if previously at the bottom
                        if (shouldScrollBottom) {
                            messages.scrollTop(messages.prop('scrollHeight'));
                        }
                    }
                }
            });

        }, 500);



        $(".inputField").focus();

        $("#newConvo .direct - chat - messages").on("mouseenter", function() {
            chatBox.addClass("active");
        });
        $("#newConvo .direct - chat - messages").on("mouseleave", function() {
            chatBox.removeClass("active");
        });


        $('.type_msg').prop('disabled', true);
        $('#user-img').hide();

        function enableTextArea() {
            $('.type_msg').prop('disabled', false);
        }

        function showDirectChatImg() {
            $('#user-img').show();
        }


        function changeHeader(element) {
            var clickedName = $(element).find('.name').text();
            var isOnline = $(element).find('.status-dot i').hasClass('text-success');
            var uniqueId = $(element).find('.uniq').text();
            var imageSrc = $(element).find('.direct-chat-img').attr('src');


            $("#newConvo .card-header .status").text(isOnline ? 'Online' : 'Offline');
            $("#newConvo .card-header .chatName").text(clickedName);
            $("#newConvo .card-header .direct-chat-img").attr('src', imageSrc);


            // Set clicked unique ID to the unique_id input field
            $('#newConvo .card-footer .unique_id').val(uniqueId);

        }
        $('#newConvo').on('click', '.content', function() {
            changeHeader(this);
            enableTextArea();
            showDirectChatImg();

        });

        $('[name="name_search"]').keyup(function() {
            var searchText = $(this).val().toLowerCase();


        });

        function changeReceiveMessageImage(imageSrc) {
            $('#receive_message .direct-chat-img').attr('src', imageSrc);
        }

        // Click event handler when a user is clicked in the user list
        $('#newConvo').on('click', '.content', function() {
            var imageSrc = $(this).find('.direct-chat-img').attr('src');
            changeReceiveMessageImage(imageSrc); // Update the user's image in the #receive_message section
            // Other functionalities if needed
        });






        $('#newConvo').on('mouseenter', '.content', function() {
            $(this).css('cursor', 'pointer');
        }).on('mouseleave', '.content', function() {
            $(this).css('cursor', 'auto'); // Change cursor back to default
        });

        $("#openChatBtn").click(function() {
            $("#newConvo").show();
            $("#openChatBtn").hide();
        });

        $("#minimize").click(function() {
            $("#newConvo").hide();
            $("#openChatBtn").show();
        });
    })
</script>