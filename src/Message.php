<?php
class Message {
    private $id;
    private $creationDate;
    private $senderId;
    private $receiverId;
    private $message;
    private $msgStatus;
    private $replayTo;


    public function __construct() {
        $this->id = -1;
        $this->creationDate = '';
        $this->senderId = '';
        $this->receiverId = '';
        $this->message = '';
        $this->msgStatus = 1;
        $this->replayTo = '';
        
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
    
    function getReplayTo() {
        return $this->replayTo;
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
    
    function setReplayTo($replayTo) {
        $this->replayTo = $replayTo;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO messages(creation_date, sender_id, "
                    . "receiver_id, message, msg_status, replay_to) VALUES (?, ?, ?, ?, ?, ?)");
            
            if (!$statement) {
                return false;
            }
            
            $statement->bind_param("iiisii", $this->creationDate, $this->senderId, 
                    $this->receiverId, $this->message, $this->msgStatus, $this->replayTo);
            
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
                $receivedMessages->replayTo = $row['replay_to'];
                
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
                $receivedMessages->replayTo = $row['replay_to'];
                
                $ret[$receivedMessages->id] = $receivedMessages;
            }
        }
            
        return $ret;
    }
    
    static public function loadMessageByMessageId(mysqli $conn, $msgId) {
        $sql = "SELECT * FROM messages WHERE id LIKE $msgId";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $receivedMessage = new Message();
            $receivedMessage->id = $row["id"];
            $receivedMessage->senderId = $row["sender_id"];
            $receivedMessage->receiverId = $row["receiver_id"];
            $receivedMessage->creationDate = $row["creation_date"];
            $receivedMessage->message = $row['message'];
            $receivedMessage->msgStatus = $row['msg_status'];
            $receivedMessage->replayTo = $row['replay_to'];
        }
            
        return $receivedMessage;
    }
    
    static public function countReceivedUnreadMessages(mysqli $conn, $userId) {
        $sql = "SELECT * FROM messages WHERE receiver_id = $userId AND msg_status = 1";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows != 0) {
            return $result->num_rows;
        } 
        return 0;
    }


}

