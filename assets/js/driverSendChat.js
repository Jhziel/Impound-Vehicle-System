$(document).ready(function(){
     var shouldDisplayBotResponse = checkers; // Flag to control bot response display

        $('[name="message"]').keypress(function(e) {
            if (e.which === 13 && e.originalEvent.shiftKey == false) {
                $('#send_chat').submit();
                return false;
            }
        });

        function displayChatMessages() {
            var incoming_id = uniqueids;
            var unique_id = 843919718;
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
                        var html = ''; // Initialize the HTML variable to store the chat content

                        for (var i = 0; i < resp.length; i++) {
                            var message = resp[i];
                            var uchat;

                            if (message.status == 1) {
                                uchat = $('#user_chat').clone();
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



        if (shouldDisplayBotResponse == 2) {
            setInterval(() => {
                displayChatMessages();

            }, 500);

        }

        function getAllMessages() {
            var messages = [];
            $('#newConvo .direct-chat-messages').find('.direct-chat-text').each(function() {
                messages.push($(this).text());
            });
            return messages;
        }
        $('#send_chat').submit(function(e) {
            e.preventDefault();
            var message = $('[name="message"]').val();
            if (message == '' || message == null) return false;
            var uchat = $('#user_chat').clone();
            uchat.find('.direct-chat-text').html(message);
            $('#newConvo .direct-chat-messages').append(uchat.html());
            $('[name="message"]').val('');
            $("#newConvo .card-body").animate({
                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
            }, "fast");

            if (shouldDisplayBotResponse == 2) {
                $.ajax({
                    url: _base_url_ + 'classes/Master.php?f=insert_driver_chat',
                    type: 'POST',
                    data: {
                        message: message,

                    },
                    success: function(resp) {
                        if (resp == 1) {
                            var message = $('[name="message"]').val();
                            if (message == '' || message == null) return false;
                            $('[name="message"]').val('');

                        }

                    }
                });

            }
            if (shouldDisplayBotResponse == 2) return; // Skip bot response if flag is false

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
                success: function(resp) {
                    if (resp) {
                        resp = JSON.parse(resp);
                        if (resp.status == 'success' && shouldDisplayBotResponse == 1) {
                            var followUp = $('#followUp').clone().removeClass('d-none');
                            var bot_chat = $('#bot_chat').clone();
                            bot_chat.find('.direct-chat-text').html(resp.message).append(followUp);
                            $('#newConvo .direct-chat-messages').append(bot_chat.html());
                            $("#newConvo .card-body").animate({
                                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
                            }, "fast");
                        } else if (resp.status == 'fail') {
                            var allMessages = getAllMessages();
                            console.log(allMessages);
                            var lastBotMessage = "I will connect you to our Staff";
                            var bot_chat = $('#bot_chat').clone();
                            bot_chat.find('.direct-chat-text').html(lastBotMessage);
                            $('#newConvo .direct-chat-messages').append(bot_chat.html());
                            $("#newConvo .card-body").animate({
                                scrollTop: $("#newConvo .card-body").prop('scrollHeight')
                            }, "fast");


                            setInterval(() => {
                                displayChatMessages();

                            }, 500);
                        }
                    }
                }
            });
        });
})