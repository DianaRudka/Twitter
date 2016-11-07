<?php
//users inbox
include_once 'src/Message.php';
include_once 'src/User.php';
require_once 'src/connection.php';

session_start();
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}

$userId = $_SESSION['loggedUserId'];
$msg = 0;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET)) {
        if (isset($_GET['read']) && isset($_GET['id'])) {
            Message::readMessage($conn, $_GET['id']);
            $msg = $_GET['id'];
        }
        if (isset($_GET['id'])) {
            $msg = $_GET['id'];
        }  
    } 
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
                    <a href="inbox.php">Wiadomości</a>
                </li>
                <li>
                    <a href="accountAdjustment.php">Ustawienia konta</a>
                </li>
            </ul>
        </div>
        <hr>
        <div class="messages_menu" cellspacing='10'>
            <ul>
                <li>
                    <a href="inbox.php">Skrzynka odbiorcza</a>
                </li>
                <li>
                    <a href="outbox.php">Wiadomości wysłane</a>
                </li>
            </ul>
        </div>
<?php
if ($inbox = Message::loadReceivedMessages($conn, $userId)) {
    foreach ($inbox as $message) {
        $username = User::loadUsernameByUserId($conn, $message->getSenderId());

?>
        <table class="messages">
            <tr>
                <td>
                    Wiadomość od: <a href="usersTweets.php?followedUserId=<?=$message->getSenderId();?>"><?=$username?></a>
                </td>
                <td>
                    <?=date('d-m-Y, G:i:s', $message->getCreationDate())?>
                </td>
            </tr>
            <tr>
                <td id="message_text" colspan="2">
<?php
        if ($message->getMsgStatus() == 1) {
            echo "<strong><a href='inbox.php?read=0&id=" . $message->getId() . "'>" . substr($message->getMessage(), 0, 30) . "</a></strong>";
        } else {
            if ($msg == $message->getId()) {
                echo $message->getMessage();
            } else {
                echo "<a href='inbox.php?id=" . $message->getId() . "'>" . substr($message->getMessage(), 0, 30) . "</a>";
            }
        }
?>
                </td>
            </tr>
        </table><br>
<?php      
    }
}

?>        
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>
