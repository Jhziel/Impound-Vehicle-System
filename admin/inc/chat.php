<div class="chat-btn">
    <button class="btn btn-success btn-lg rounded-pill" id="openChatBtn">Chat</button>
</div>
<style>
    .content {
        position: relative;
    }

    .status-dot {
        position: absolute;
        font-size: 12px;
        bottom: 16px;
        left: 28px;
    }
</style>
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

                    </div>
                    <div class="end-convo"></div>
                    <!-- /.direct-chat-pane -->
                </div>
                <div class="card-footer">
                    <form id="send_chat" action="">
                        <div class="input-group">
                            <input type="text" class="sender_id" name="sender_id" value="<?php echo $_settings->userdata('unique_id'); ?>" hidden>
                            <input type="text" class="receiver_id" name="receiver_id" hidden>
                            <textarea name="message" class="form-control type_msg" class="message" placeholder="Type your message..."></textarea>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary send">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


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
        <img class="direct-chat-img chat-img border-1 border-primary" src="<?php echo validate_image($_settings->info('bot_avatar')) ?>" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">

        </div>
        <!-- /.direct-chat-text -->

    </div>
</div>
<div class="d-none" id="bot_chat">
    <div class="direct-chat-msg right mr-4">
        <img class="direct-chat-img border-1 border-primary" src="/../traffic_offense/uploads/pngtree-chatbot-icon-chat-bot-robot-png-image_4841963.png" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">

        </div>
        <!-- /.direct-chat-text -->

    </div>
</div>

<a href="#" class="d-none" id="allUsers">
    <div class="content">

        <img class="direct-chat-img border-1 border-primary mr-2" src="" alt="message user image">
        <div class="status-dot align-self-center"><i class="fas fa-circle "></i></div>
        <div class="details">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="text-capitalize name"></span>
                    <div>
                        <span class="uniq" style="display: none;"></span>
                        <span class="is_active" style="display: none;">No</span>

                        <p class="message"></p>

                    </div>
                </div>

            </div>

        </div>
    </div>
</a>


<script>
    $(document).ready(function() {

        var isActive = '';
        $('[name="message"]').keypress(function(e) {
            if (e.which === 13 && e.originalEvent.shiftKey == false) {
                $('#send_chat').submit();
                return false;
            }
        })

        var conn = new WebSocket('ws://localhost:8080?token=<?php echo $_settings->userdata('unique_id'); ?>');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {

            var list = $('#newConvo .users-list')

            function indivmess(targetId, message) {
                $('#newConvo .content').each(function() {
                    var id = $(this).find('.uniq').text();
                    var content = $(this);
                    if (id == targetId) {
                        $(this).find('.message').html(message);
                        list.prepend(content);

                    }
                });
            }

            function OnlineStatus(class1, class2) {
                $('#newConvo .status-dot i').each(function() {
                    var id = $(this).attr("id");
                    if (id == data.token) {
                        $(this).addClass(class1).removeClass(class2);
                    }
                });
            }
            console.log(e.data);

            var receiver_id = $('#newConvo .card-footer .receiver_id').val();

            var messages = $('#newConvo .direct-chat-messages');
            var data = JSON.parse(e.data);

            if (typeof data.action !== 'undefined' || data.action == 'connect') {


                var allUsers = $('#allUsers').clone();
                allUsers.find('.name').html(data.name);
                allUsers.find('.message').html(data.msg);
                allUsers.find('.uniq').html(data.unique_id);

                allUsers.find('.status-dot i').attr("id", data.unique_id);
                allUsers.find('.direct-chat-img').attr("src", "../" + data.avatar);
                var statusDot = allUsers.find('.status-dot i');
                if (data.status === "Online") {
                    statusDot.addClass("text-success").removeClass("text-danger");
                } else {
                    statusDot.addClass("text-danger").removeClass("text-success");
                }
                list.prepend(allUsers.html());

            }

            if (data.status == "Online") {
                OnlineStatus('text-success', 'text-danger');
            } else if (data.status == "Offline") {
                OnlineStatus('text-danger', 'text-success')
            } else {


                var msg;
                if (data.from == 'Me') {
                    var msg = $('#sent_message').clone(true).removeClass('d-none');
                    indivmess(data.receiverId, 'You:' + data.msg);

                } else {
                    var msg = $('#receive_message').clone(true).removeClass('d-none');
                    indivmess(data.senderId, data.msg)
                    console.log(data.action);
                }
                if (receiver_id == data.receiverId || data.from == 'Me' || receiver_id == data.senderId) {

                    if (isActive == 'Yes') {

                        msg.find('.direct-chat-text').html(data.msg);

                        // Append the cloned message container to the chat messages container
                        messages.append(msg);
                    }
                    $('#newConvo .direct-chat-messages').animate({
                        scrollTop: $('#newConvo .direct-chat-messages').prop('scrollHeight')
                    }, "fast");
                }







            }

        };


        $('#send_chat').submit(function(e) {
            e.preventDefault();

            var message = $('[name="message"]').val();
            if (message == '' || message == null) return false;
            var sender_id = $('[name="sender_id"]').val();
            var receiver_id = $('[name="receiver_id"]').val();
            $('#newConvo .direct-chat-messages').animate({
                scrollTop: $('#newConvo .direct-chat-messages').prop('scrollHeight')
            }, "fast");

            var data = {
                senderId: sender_id,
                receiverId: receiver_id,
                msg: message
            }
            conn.send(JSON.stringify(data));
            $('[name="message"]').val('');

        });




        //Display all Client
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

                            allUsers.find('.status-dot i').attr("id", user.unique_id);
                            allUsers.find('.direct-chat-img').attr("src", "../" + user.avatar);
                            var statusDot = allUsers.find('.status-dot i');
                            if (user.status === "Online") {
                                statusDot.addClass("text-success").removeClass("text-danger");
                            } else {
                                statusDot.addClass("text-danger").removeClass("text-success");
                            }

                            $('#newConvo .users-list').append(allUsers.html());


                        });

                    }

                }
            }
        });



        $(".inputField").focus();

        $("#newConvo .direct - chat - messages").on("mouseenter", function() {
            chatBox.addClass("active");
        });
        $("#newConvo .direct - chat - messages").on("mouseleave", function() {
            chatBox.removeClass("active");
        });

        function changeHeader(element) {

            var receiver_id = $(element).find('.uniq').text();
            $('#newConvo .card-footer .receiver_id').val(receiver_id);


            var clickedName = $(element).find('.name').text();
            /* var isOnline = $(element).find('.status-dot i').hasClass('text-success'); */
            var imageSrc = $(element).find('.direct-chat-img').attr('src');


            /*  $("#newConvo .card-header .status").text(isOnline ? 'Online' : 'Offline'); */
            $("#newConvo .card-header .chatName").text(clickedName);
            $("#newConvo .card-header .direct-chat-img").attr('src', imageSrc);


            // Set clicked unique ID to the unique_id input field

        }
        $('#newConvo').on('click', '.content', function() {

            changeHeader(this);
            $('#newConvo .content').find('.is_active').html('No');
            $(this).find('.is_active').html('Yes');
            isActive = $(this).find('.is_active').html();

            var messages = $('#newConvo .direct-chat-messages');
            var sender_id = $('[name="sender_id"]').val();
            var receiver_id = $('[name="receiver_id"]').val();

            // Save current scroll position and height
            var shouldScrollBottom = (messages.prop('scrollHeight') - messages.scrollTop() === messages.outerHeight());

            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=get_chat_ctmo',
                type: 'POST',
                data: {
                    sender_id: sender_id,
                    receiver_id: receiver_id,
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
                            } else if (message.status == 2) {
                                uchat = $('#receive_message').clone();
                            } else {
                                uchat = $('#bot_chat').clone();
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
            /*  enableTextArea();
             showDirectChatImg(); */

        });

















        /*  $('.type_msg').hide();
         $('.send').hide();
         $('#user-img').hide(); */


        /* function enableTextArea() {
            $('.type_msg').show();
            $('.send').show();
        } */



        /*  function showDirectChatImg() {
             $('#user-img').show();
         } */



        /*  $('[name="name_search"]').keyup(function() {
             var searchText = $(this).val().toLowerCase();


         }); */

        /*  function changeReceiveMessageImage(imageSrc) {
             $('#receive_message .direct-chat-img').attr('src', imageSrc);
         } */

        // Click event handler when a user is clicked in the user list
        /*  $('#newConvo').on('click', '.content', function() {
             var imageSrc = $(this).find('.direct-chat-img').attr('src');
             changeReceiveMessageImage(imageSrc); // Update the user's image in the #receive_message section
             // Other functionalities if needed
         }); */





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