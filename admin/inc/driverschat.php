<?php if ($_settings->userdata('type') == 3) :
    $unique_id = $_settings->userdata('unique_id');
    $qry = $conn->query("SELECT * from `bot_status` where unique_id = '{$unique_id}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
?>


    <div class="chat-btn">
        <button class="btn btn-success btn-lg rounded-pill" id="openChatBtn">Chat</button>
    </div>
    <div class="card  w-25   direct-chat direct-chat-primary" style="z-index: 4; " id="newConvo">
        <div>
            <div class="card h-100 mb-0">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-8 align-items-center">
                            <div>
                                <img class="direct-chat-img  border-1 border-primary mr-2" id="user-img" src="/../traffic_offense/uploads/334969234_1397681864313344_3395914132033480923_n-removebg-preview.png" alt="" />
                                <h3 class="mb-0 mt-3">Chat</h3>

                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn btn-tool " id="minimize">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <!-- Direct-chat-messages section -->
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg mr-4">
                            <img class="direct-chat-img border-1 border-primary" src="/../traffic_offense/uploads/pngtree-chatbot-icon-chat-bot-robot-png-image_4841963.png" alt="message user image">
                            <div class="direct-chat-text ">
                                <p class="mb-2"> Welcome to CTMO! Do you have any question?</p>
                                <?php
                                // Code to fetch and display top 3 frequent questions
                                $questions = $conn->query("SELECT * FROM `questions` where id in (SELECT question_id from frequent_asks) ");
                                $list = array();
                                while ($row = $questions->fetch_assoc()) {
                                    $count = $conn->query("SELECT * FROM frequent_asks where question_id = {$row['id']} ")->num_rows;
                                    $list[$count] = array("count" => $count, "question" => $row['question']);
                                }
                                krsort($list);

                                // Extract top 3 frequent questions
                                $label = array();
                                $i = 3;
                                foreach ($list as $k => $v) {
                                    $i--;
                                    $label[] = $list[$k]['question'];
                                    if ($i == 0)
                                        break;
                                }

                                // Loop through the top 3 frequent questions and display them as clickable links
                                foreach ($label as $index => $question) {
                                ?>
                                    <!-- Clickable Message (Frequent Question) -->
                                    <div class=" faq btn-sm btn-block border bg-white text-center">
                                        <?php echo $question; ?>
                                    </div>
                                    <br>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="end-convo"></div>
                    <!-- /.direct-chat-pane -->
                </div>
                <div class="card-footer">
                    <form id="send_chat" method="post">
                        <div class="input-group">
                            <textarea type="text" name="message" placeholder="Type Message ..." class="form-control" required=""></textarea>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php endif ?>



<div class="d-none" id="followUp">
    <hr id="sep">
    <p id="ask">Are you satisfied with this answer?</p>
    <div class="d-flex justify-content-center test">
        <div class="btn btn-success mr-1" id="satisfied_yes">yes</div>
        <div class="btn btn-danger" id="satisfied_no">no</div>
    </div>
    <div class="d-none" id="followUp_faq">
        <hr>
        <p>Do you want to see again the FAQ?</p>
        <div class="d-flex justify-content-center test">
            <div class="btn btn-success mr-1" id="faq_yes">yes</div>
            <div class="btn btn-danger" id="faq_no">no</div>
        </div>
    </div>
    <div class="d-none" id="followUp_staff">
        <hr>
        <p>Do you want to talk to one of our staff members?</p>
        <div class="d-flex justify-content-center test">
            <div class="btn btn-success mr-1" id="staff_yes">yes</div>
            <div class="btn btn-danger" id="staff_no">no</div>
        </div>
    </div>

    <div id="faq_follow" class="d-none mt-2">
        <?php
        // Code to fetch and display top 3 frequent questions
        $questions = $conn->query("SELECT * FROM `questions` where id in (SELECT question_id from frequent_asks) ");
        $list = array();
        while ($row = $questions->fetch_assoc()) {
            $count = $conn->query("SELECT * FROM frequent_asks where question_id = {$row['id']} ")->num_rows;
            $list[$count] = array("count" => $count, "question" => $row['question']);
        }
        krsort($list);

        // Extract top 3 frequent questions
        $label = array();
        $i = 3;
        foreach ($list as $k => $v) {
            $i--;
            $label[] = $list[$k]['question'];
            if ($i == 0)
                break;
        }

        // Loop through the top 3 frequent questions and display them as clickable links
        foreach ($label as $index => $question) {
        ?>
            <!-- Clickable Message (Frequent Question) -->
            <div class=" faq btn-sm btn-block border bg-white text-center">
                <?php echo $question; ?>
            </div>
            <br>
        <?php
        }
        ?>
    </div>
</div>

<div class="d-none" id="sent_message">
    <div class="direct-chat-msg right  ml-4">
        <img class="direct-chat-img border-1 border-primary" src="<?php echo validate_image($_settings->info('user_avatar')) ?>" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text"></div>
        <!-- /.direct-chat-text -->
    </div>
</div>
<div class="d-none" id="bot_chat">
    <div class="direct-chat-msg mr-4">
        <img class="direct-chat-img border-1 border-primary" src="/../traffic_offense/uploads/pngtree-chatbot-icon-chat-bot-robot-png-image_4841963.png" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text ">

        </div>
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


<script src="<?php echo base_url ?>assets/js/chatFaq.js"></script>

<script>
    $(document).ready(function() {

        var display_convo = <?php echo $checker; ?>; // Flag to control bot response display
        var bot_respone = true; // Flag to control bot response display


        $('[name="message"]').keypress(function(e) {
            if (e.which === 13 && e.originalEvent.shiftKey == false) {
                $('#send_chat').submit();
                return false;
            }
        });

        if (!bot_respone || display_convo == 2) {
            displayChatMessages()
        }

        var conn = new WebSocket('ws://localhost:8080?token=<?php echo $_settings->userdata('unique_id'); ?>');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {

            console.log(e.data);
            console.log(display_convo);

            var messages = $('#newConvo .direct-chat-messages');
            var data = JSON.parse(e.data);

            if (data.action == 'connect') {

            } else {

                var msg;
                if (data.from == 'Me') {
                    var msg = $('#sent_message').clone(true).removeClass('d-none');

                } else if (data.from == 'Other') {
                    var msg = $('#receive_message').clone(true).removeClass('d-none');

                }

                if (msg) {
                    msg.find('.direct-chat-text').html(data.msg);
                }

                // Append the cloned message container to the chat messages container
                messages.append(msg);
            }

            $('#newConvo .direct-chat-messages').animate({
                scrollTop: $('#newConvo .direct-chat-messages').prop('scrollHeight')
            }, "fast");
        }




        $('#send_chat').submit(function(e) {
            var sender_id = <?php echo $_settings->userdata('unique_id'); ?>;
            var receiver_id = 843919718;
            e.preventDefault();
            var message = $('[name="message"]').val();
            if (message == '' || message == null) return false;

            if (!bot_respone || display_convo == 2) {

                var data = {
                    senderId: sender_id,
                    receiverId: receiver_id,
                    msg: message
                }
                conn.send(JSON.stringify(data));
                $('[name="message"]').val('');

            }

            if (!bot_respone || display_convo == 2) return; // Skip bot response if flag is false
            var uchat = $('#sent_message').clone();
            uchat.find('.direct-chat-text').html(message);
            $('#newConvo .direct-chat-messages').append(uchat.html());
            $('[name="message"]').val('');
            $("#newConvo .card-body").animate({
                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
            }, "fast");



            $.ajax({
                url: _base_url_ + "classes/Master.php?f=get_response",
                method: 'POST',
                data: {
                    message: message
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                },
                dataType: "json",
                success: function(resp) {
                    if (resp) {
                        if (resp.status == 'success' && bot_respone) {
                            var followUp = $('#followUp').clone().removeClass('d-none');
                            var bot_chat = $('#bot_chat').clone();
                            bot_chat.find('.direct-chat-text').html(resp.message).append(followUp);
                            $('#newConvo .direct-chat-messages').append(bot_chat.html());
                            $("#newConvo .card-body").animate({
                                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
                            }, "fast");
                        } else if (resp.status == 'fail') {
                            bot_respone = false;
                            var lastBotMessage = "I will connect you to our Staff";
                            var bot_chat = $('#bot_chat').clone();
                            bot_chat.find('.direct-chat-text').html(lastBotMessage);
                            $('#newConvo .direct-chat-messages').append(bot_chat.html());
                            $("#newConvo .card-body").animate({
                                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
                            }, "fast");

                            var data = {
                                senderId: sender_id,
                                receiverId: receiver_id,
                                msg: message,
                                action: 'connect'
                            }
                            conn.send(JSON.stringify(data));

                        }
                    }
                }
            });
        });

        /* function getAllMessages() {
            var messages = [];
            $('#newConvo .direct-chat-messages').find('.direct-chat-text').each(function() {
                messages.push($(this).text());
            });
            return messages;
        } */


        function displayChatMessages() {
            var sender_id = <?php echo $_settings->userdata('unique_id'); ?>;
            var receiver_id = 843919718;
            var messages = $('#newConvo .direct-chat-messages');

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
                        var html = ''; // Initialize the HTML variable to store the chat content

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
        }
        $("#newConvo").on("click", "#staff_yes", function() {
            var sender_id = <?php echo $_settings->userdata('unique_id'); ?>;
            var receiver_id = 843919718;
            var message = $('[name="message"]').val();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=connect_staff",
                type: "POST",
                dataType: "json",
                success: function(resp) {
                    if (resp) {
                        if (resp.status == "success") {
                            bot_respone = false;
                            var lastBotMessage = "I will connect you to our Staff";
                            var bot_chat = $("#bot_chat").clone();
                            bot_chat.find(".direct-chat-text").html(lastBotMessage);
                            $("#newConvo .direct-chat-messages").append(bot_chat.html());
                            $("#newConvo .card-body").animate({
                                    scrollTop: $("#newConvo .card-body").prop("scrollHeight"),
                                },
                                "fast"
                            );

                            var data = {
                                senderId: sender_id,
                                receiverId: receiver_id,
                                msg: message,
                                action: "connect",
                            };
                            conn.send(JSON.stringify(data));
                        }
                    }
                },
            });
        });


        $('.type_msg').prop('disabled', false);

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