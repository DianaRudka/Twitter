<?php
//account configuration
include_once 'src/Message.php';
include_once 'src/Comment.php';
include_once 'src/User.php';
include_once 'src/Tweet.php';
require_once 'src/connection.php';

session_start();
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}

$msgCount = Message::countReceivedUnreadMessages($conn, $_SESSION['loggedUserId']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userId = $_SESSION['loggedUserId'];
    $oldUser = User::loadUserById($conn, $userId);
    
    if (isset($_POST['username']) && $_POST['username'] != '') {
        $username = $conn->real_escape_string($_POST['username']);
        if (!User::loadAllUsersByUsername($conn, $username)) {
            $oldUser->setUsername($username); 
            $_SESSION['loggedUserName'] = $oldUser->getUsernam();
        } else {
            echo "Taki login jest już zarezerwowany. Użyj innego.";
        }
    }
    
    if (isset($_POST['email']) && $_POST['email'] != '') {
        $email = $conn->real_escape_string($_POST['email']);
        if (!User::loadUserByEmail($conn, $email)) {
            $oldUser->setEmail($email);
        } else {
            echo "Taki email jest już w bazie. Użyj innego.";
        }   
    }

    if (isset($_POST['password']) && isset($_POST['confirmationPassword']) &&
            $_POST['password'] != '' && $_POST['confirmationPassword'] != '') {
        if ($_POST['password'] == $_POST['confirmationPassword']) {
            if (strlen($_POST['password']) > 4) {
                $password =  $conn->real_escape_string($_POST['password']);
                $oldUser->setHashsedPassword($hashedPassword);
            } else {
                echo "Hasło za krótkie";
            }
        } else {
            echo "Hasła różnią się";
        }
    }  

    $oldUser->saveToDB($conn);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Twitter</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/app_index.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="main_menu" cellspacing='10'>
            <ul>
                <li>
                    Jesteś zalogowany jako: 
                    <?=$_SESSION['loggedUserName'];
                    ?><br>
                    <a href="logout.php">Wyloguj się</a>
                </li>
                <li>
                    <a href="index.php">Strona główna</a>
                </li>
                <li>
                    <a href="inbox.php">Wiadomości  <?=$msgCount?></a>
                </li>
                <li>
                    <a href="accountAdjustment.php">Ustawienia konta</a>
                </li>
            </ul>
        </div>
        <hr>    
        <form method="POST" action="" class="register">
            <h2>Zmień ustawienia konta</h2>
            <label>Login<br>
            <input type="text" id="username" name="username" placeholder="Imię i nazwisko"><br>
            </label>
            <label>E-mail<br>
            <input type="email" id="email" name="email" placeholder="E-mail"><br>
            </label>
            <label>Hasło<br>
            <input type="password" id="password" name="password" placeholder="Hasło"><br>
            </label>
            <label>Powtórz hasło<br>
            <input type="password" id="confirmationPassword" name="confirmationPassword" placeholder="Powtórz hasło"><br>
            </label>
            <br>
            <input type="submit" id="button" value="Zapisz zmiany">
    </form>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>

