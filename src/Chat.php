<?php
// chat.php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require_once dirname(__DIR__) . "/classes/Chatdata.php";


class Chat implements MessageComponentInterface
{
    protected $clients;


    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);

        $chat_data = new \Chatdata;

        $chat_data->setToken($queryArray['token']);
        $chat_data->setConnId($conn->resourceId);
        $chat_data->update_conn_id();
        $chat_data->setStatus('Online');
        $chat_data->update_status();

        $data['token'] = $chat_data->getToken();
        $data['status'] = 'Online';
        foreach ($this->clients as $client) {

            $client->send(json_encode($data));
        }



        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        $data = json_decode($msg, true);

        $chat_data = new \Chatdata;

        $chat_data->setSenderID($data['senderId']);

        $sender_data = $chat_data->get_sender_data();

        $chat_data->setReceiverID($data['receiverId']);

        $receiver_data = $chat_data->get_receiver_data();

        $chat_data->setMessage($data['msg']);

        $chat_data->setOnlineStatus('Yes');

        $chat_message_id = $chat_data->save_chat();

        $receiver_connection_id = $receiver_data['connection_id'];

        $sender_type = $sender_data['type'];




        if (isset($data['action']) && $data['action'] == 'connect') {
            $data['name'] = ucwords($sender_data['firstname'] . ' ' . $sender_data['lastname']);
            $data['unique_id'] = $sender_data['unique_id'];
            $data['avatar'] = $sender_data['avatar'];
            $data['status'] = $sender_data['status'];
        }

        foreach ($this->clients as $client) {
            if ($from == $client) {
                $data['from'] = 'Me';
            } else {
                $data['from'] = 'Other';
            }


            if ($client->resourceId == $receiver_connection_id || $from == $client) {

                $client->send(json_encode($data));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);
        $chat_data = new \Chatdata;
        $chat_data->setToken($queryArray['token']);
        $chat_data->setStatus('Offline');
        $chat_data->update_status();
        $data['token'] =  $chat_data->getToken();
        $data['status'] = 'Offline';
        foreach ($this->clients as $client) {

            $client->send(json_encode($data));
        }


        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
