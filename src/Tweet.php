<?php
class Tweet {
    private $id;
    private $userId;
    private $tweet;
    private $creationDate;
    
    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->tweet = '';
        $this->creationDate = '';
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getTweet() {
        return $this->tweet;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setTweet($tweet) {
        $this->tweet = $tweet;
    }

    public function setCreationDate() {
        $this->creationDate = time();
    }
    
    static public function loadTweetById(mysqli $conn, $id) {
        $sql = "SELECT * FROM tweets WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row["id"];
            $loadedTweet->userId = $row["user_id"];
            $loadedTweet->tweet = $row["tweet"];
            $loadedTweet->creationDate = $row["creation_date"];
            
            return $loadedTweet;
        }
        return null;
    }
    
    static public function loadAllTweetsByUserId(mysqli $conn, $userId) {
        $sql = "SELECT tweets.id, user_id, tweet, creation_date, users.username FROM tweets"
                . " LEFT JOIN users ON tweets.user_id = users.id WHERE users.id = '$userId' "
                . "ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row["id"];
                $loadedTweet->userId = $row["user_id"];
                $loadedTweet->tweet = $row["tweet"];
                $loadedTweet->creationDate = $row["creation_date"];
                $loadedTweet->username = $row['username'];
                
                $ret[$loadedTweet->id] = $loadedTweet;
            }
        }
            
        return $ret;
    }
    
    static public function loadAllTweets(mysqli $conn) {
        $sql = "SELECT tweets.id, user_id, tweet, creation_date, users.username FROM tweets"
                . " LEFT JOIN users ON tweets.user_id = users.id ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row["id"];
                $loadedTweet->userId = $row["user_id"];
                $loadedTweet->tweet = $row["tweet"];
                $loadedTweet->creationDate = $row["creation_date"];
                $loadedTweet->username = $row['username'];
                
                $ret[$loadedTweet->id] = $loadedTweet;
            }
        } else {
            echo 'error';
        }
            
        return $ret;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO tweets(user_id, tweet, creation_date) VALUES (?, ?, ?)");
            
            if (!$statement) {
                return false;
            }
            
            $statement->bind_param("iss", $this->userId, $this->tweet, $this->creationDate);
            
            if ($statement->execute()) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
}

?>