<?php
class Comment {
    private $id;
    private $userId;
    private $tweetId;
    private $commentDate;
    private $commentary;
    
    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->tweetId = '';
        $this->commentDate = '';
        $this->commentary = '';
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetId() {
        return $this->tweetId;
    }

    public function getCommentDate() {
        return $this->commentDate;
    }

    public function getCommentary() {
        return $this->commentary;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    public function setCommentDate($commentDate) {
        $this->commentDate = $commentDate;
    }

    public function setCommentary($commentary) {
        $this->commentary = $commentary;
    }
    
    public function loadCommentById(mysqli $conn, $id) {
        $sql = "SELECT * FROM comments WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedComment = new Comment();
            $loadedComment->id = $row["id"];
            $loadedComment->userId = $row["user_id"];
            $loadedComment->tweetId = $row["tweet_id"];
            $loadedComment->commentDate = $row["comment_date"];
            $loadedComment->commentary = $row["commentary"];
            
            return $loadedComment;
        }
        return null;
    }
    
    static public function loadAllCommentsByPostId(mysqli $conn, $tweetId) {
        $sql = "SELECT * FROM comments WHERE tweet_id = '$tweetId' ORDER BY comment_date DESC";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row["id"];
                $loadedComment->userId = $row["user_id"];
                $loadedComment->tweetId = $row["tweet_id"];
                $loadedComment->commentDate = $row["comment_date"];
                $loadedComment->commentary = $row['commentary'];
                $loadedComment->username = User::loadUsernameByUserId($conn, $loadedComment->userId);
                
                $ret[$loadedComment->id] = $loadedComment;
            }
        }
            
        return $ret;
    }
    static public function countCommentsByTweetId(mysqli $conn, $tweetId) {
        $sql = "SELECT * FROM comments WHERE tweet_id = $tweetId";
        $result = $conn->query($sql);
        
        if ($result != false) {
            $count = $result->num_rows;
        }
        return $count;
    }

    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO comments(user_id, tweet_id, "
                    . "comment_date, commentary) VALUES (?, ?, ?, ?)");
            
            if (!$statement) {
                return false;
            }
            
            $statement->bind_param("iiis", $this->userId, $this->tweetId, 
                    $this->commentDate, $this->commentary);
            
            if ($statement->execute()) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
}
?>