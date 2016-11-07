<?php

//CREATE TABLE users (
//id int AUTO_INCREMENT,
//username varchar(255),
//hashedPassword varchar(60) NOT NULL,
//email varchar(255) UNIQUE NOT NULL,
//PRIMARY KEY(id)
//)
        
class User {
    private $id;
    private $username;
    private $hashedPassword;
    private $email;
    
    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->hashedPassword = "";
        $this->email = "";
    }
    
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    public function setHashsedPassword($hashedPassword) {
        $newHashedPassword = password_hash($hashedPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
        return $this;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getUsernam() {
        return $this->username;
    }
    
    public function getHashedPassword() {
        return $this->hashedPassword;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO users(username, hashedPassword, email) VALUES (?, ?, ?)");
            
            if (!$statement) {
                return false;
            }
            
            $statement->bind_param("sss", $this->username, $this->hashedPassword, $this->email);
            
            if ($statement->execute()) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE users SET username = '$this->username', hashedPassword = '$this->hashedPassword', "
                    . "email = '$this->email' WHERE id = '$this->id'";
            
            $result = $conn->query($sql);
            
            if ($result) {
                return true;
            }
            return false;
        }
    }
    
    static public function loadUserById(mysqli $conn, $id) {
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedUser = new User();
            $loadedUser->id = $row["id"];
            $loadedUser->email = $row["email"];
            $loadedUser->username = $row["username"];
            $loadedUser->hashedPassword = $row["hashedPassword"];
            
            return $loadedUser;
        }
        return null;
    }
    
    static public function loadUserByEmail(mysqli $conn, $email) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedUser = new User();
            $loadedUser->id = $row["id"];
            $loadedUser->email = $row["email"];
            $loadedUser->username = $row["username"];
            $loadedUser->hashedPassword = $row["hashedPassword"];
            return $loadedUser;
        }
        return false;
    }
    
    static public function loadAllUsers(mysqli $conn) {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row["id"];
                $loadedUser->email = $row["email"];
                $loadedUser->username = $row["username"];
                $loadedUser->hashedPassword = $row["hashedPassword"];
                
                $ret[$loadedUser->id] = $loadedUser;
            }
        }
            
        return $ret;
    }
    
    static public function loadAllUsersByUsername(mysqli $conn, $username) {
        $sql = "SELECT * FROM users WHERE username LIKE '$username'";
        $result = $conn->query($sql);
        $ret = [];
        
        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row["id"];
                $loadedUser->email = $row["email"];
                $loadedUser->username = $row["username"];
                $loadedUser->hashedPassword = $row["hashedPassword"];
                
                $ret[$loadedUser->id] = $loadedUser;
            }
        } else {
            return false;
        }
            
        return $ret;
    }
    
    static public function loadUserIdByEmail(mysqli $conn, $email, $password) {    //login
        $sql = "SELECT id, hashedPassword, username FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['hashedPassword'])) {
                $loginTable['id'] = intval($row['id']);
                $loginTable['username'] = $row['username'];
                return $loginTable;
            } else {
                echo 'Nieprawidłowe hasło<br>';
                return false;
            }  
        }
        echo 'Nie ma takiego użytkownika<br>';
        return false;
    }
    
    static public function loadUsernameByUserId(mysqli $conn, $userId) {
        $sql = "SELECT id, username FROM users WHERE id = '$userId'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            return $username;
        }
    }

    public function delete(mysqli $conn) {
        if ($this->id == -1) {
            return true;
        }
        
        $sql = "DELETE FROM users WHERE id = $this->id";
        $result = $conn->query($sql);
        
        if ($result) {
            $this->id = -1;
            return true;
        }
        return false;
    }
}

?>

