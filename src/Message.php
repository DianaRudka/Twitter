<?php
class Message {
    private $id;
    private $creationDate;
    private $senderId;
    private $receiverId;
    private $message;
    private $msgStatus;
    
    public function __construct() {
        $this->id = -1;
        $this->creationDate = '';
        $this->senderId = '';
        $this->receiverId = '';
        $this->message = '';
        $this->msgStatus = 1;
        
    }
    
    function getId() {
        return $this->id;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getMessage() {
        return $this->message;
    }

    function getMsgStatus() {
        return $this->msgStatus;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setMsgStatus($msgStatus) {
        $this->msgStatus = $msgStatus;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO messages(creation_date, sender_id, "
                    . "receiver_id, message, msg_status) VALUES (?, ?, ?, ?)");
            
            if (!$statement) {
                return false;
            }
            
            $statement->bind_param("iiisi", $this->creationDate, $this->senderId, 
                    $this->receiverId, $this->message, $this->msgStatus);
            
            if ($statement->execute()) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
    
    static public function readMessage(mysqli $conn, $id) {
        
        $sql = "UPDATE messages SET msg_status = 0 WHERE id = $id";
        $result = $conn->query($sql);
        if ($result) {
            return true;
        }
        return false;
       
    }


    static public function loadReceivedMessages(mysqli $conn, $userId) {
        $sql = "SELECT * FROM messages WHERE receiver_id LIKE $userId ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $receivedMessages = new Message();
                $receivedMessages->id = $row["id"];
                $receivedMessages->senderId = $row["sender_id"];
                $receivedMessages->receiverId = $row["receiver_id"];
                $receivedMessages->creationDate = $row["creation_date"];
                $receivedMessages->message = $row['message'];
                $receivedMessages->msgStatus = $row['msg_status'];
                
                $ret[$receivedMessages->id] = $receivedMessages;
            }
        }
            
        return $ret;
    }
    
    static public function loadSendMessages(mysqli $conn, $userId) {
        $sql = "SELECT * FROM messages WHERE sender_id LIKE $userId ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $receivedMessages = new Message();
                $receivedMessages->id = $row["id"];
                $receivedMessages->senderId = $row["sender_id"];
                $receivedMessages->receiverId = $row["receiver_id"];
                $receivedMessages->creationDate = $row["creation_date"];
                $receivedMessages->message = $row['message'];
                $receivedMessages->msgStatus = $row['msg_status'];
                
                $ret[$receivedMessages->id] = $receivedMessages;
            }
        }
            
        return $ret;
    }


}

