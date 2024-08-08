<?php
require_once dirname(__DIR__) . "/classes/DBConnection.php";

class ChatData extends DBConnection
{

    private $token;
    private $conId;
    private $status;
    private $senderID;
    private $receiverID;
    private $message;
    private $onlineStatus;

    public function __construct()
    {
        parent::__construct();
    }

    function setToken($token)
    {
        $this->token = $token;
    }

    function getToken()
    {
        return $this->token;
    }
    
    function setConnId($conId)
    {
        $this->conId = $conId;
    }

    function getConnId()
    {
        return $this->conId;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function getStatus()
    {
        return $this->status;
    }

    function setSenderID($senderID)
    {
        $this->senderID = $senderID;
    }

    function getSenderID()
    {
        return $this->senderID;
    }

    function setReceiverID($receiverID)
    {
        $this->receiverID = $receiverID;
    }

    function getReceiverID()
    {
        return $this->receiverID;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->message;
    }

    function setOnlineStatus($onlineStatus)
    {
        $this->onlineStatus = $onlineStatus;
    }

    function getOnlineStatus()
    {
        return $this->onlineStatus;
    }


    function update_conn_id()
    {
        $qry = "UPDATE users SET connection_id=? WHERE unique_id = ?";


        $statement = $this->conn->prepare($qry);

        $statement->bind_param('ii', $this->conId, $this->token);

        $statement->execute();
        
        /*  for Get
       
        $query = "SELECT * FROM users WHERE id=? ";

        $statement = $this->conn->prepare($query);

        $statement->bind_param('i',$this->token);
        $statement->execute();

        $result = $statement->get_result();
        $token = $result->fetch_assoc();

        return $token; */
    }

    function update_status()
    {
        $qry = "UPDATE users SET status=? WHERE unique_id = ?";


        $statement = $this->conn->prepare($qry);

        $statement->bind_param('si', $this->status,$this->token);

        $statement->execute();
        
        /*  for Get
       
        $query = "SELECT * FROM users WHERE id=? ";

        $statement = $this->conn->prepare($query);

        $statement->bind_param('i',$this->token);
        $statement->execute();

        $result = $statement->get_result();
        $token = $result->fetch_assoc();

        return $token; */
    }

    function save_chat(){

        $qry = "INSERT INTO chat_message (sender_id,receiver_id,msg,status) VALUES (?,?,?,?)";
        $statement = $this->conn->prepare($qry);
        $statement->bind_param('iiss', $this->senderID, $this->receiverID, $this->message, $this->onlineStatus);
        $statement->execute();
        return $this->conn->insert_id;
    }

    function get_sender_data(){

        $qry = "SELECT * FROM users WHERE unique_id=?";

        $statement = $this->conn->prepare($qry);

        $statement->bind_param('i', $this->senderID);

        $statement->execute();

        $result = $statement->get_result();
        $sender_data = $result->fetch_assoc();

        return $sender_data;
    }

    function get_receiver_data(){

        $qry = "SELECT * FROM users WHERE unique_id=?";

        $statement = $this->conn->prepare($qry);

        $statement->bind_param('i', $this->receiverID);

        $statement->execute();

        $result = $statement->get_result();
        $receiver = $result->fetch_assoc();

        return $receiver;
    }
}
