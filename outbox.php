<?php
//users inbox
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

$userId = $_SESSION['loggedUserId'];
$msg = 0;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET) && isset($_GET['id'])) {
        $msg = $_GET['id'];
    } 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $creationDate = time();
    $senderId = $_SESSION['loggedUserId'];
    $receiverId = $_POST['followedUserId'];
    $message = $_POST['message'];
    
    $newMessage = new Message();
    $newMessage->setMessage($message);
    $newMessage->setReceiverId($receiverId);
    $newMessage->setSenderId($senderId);
    $newMessage->setCreationDate($creationDate);
    $newMessage->setReplayTo(0);
    
    if (!$newMessage->saveToDB($conn)) {
        echo 'Somethogn went wrong. Try again';
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
                    <a href="inbox.php">Wiadomości  <?=$msgCount?></a>
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
                    <strong><a href="inbox.php">Skrzynka odbiorcza</a></strong>
                </li>
                <li>
                    <a href="outbox.php">Wiadomości wysłane</a>
                </li>
            </ul>
        </div>
<?php
if ($inbox = Message::loadSendMessages($conn, $userId)) {
    foreach ($inbox as $message) {
        $username = User::loadUsernameByUserId($conn, $message->getReceiverId());

?>
        <table class="messages">
            <tr>
                <td>
                    Wiadomość wysłana do: <a href="usersTweets.php?followedUserId=<?=$message->getReceiverId();?>"><?=$username?></a>
                </td>
                <td>
                    <?=date('d-m-Y, G:i:s', $message->getCreationDate())?>
                </td>
            </tr>
            <tr>
                <td id="message_text" colspan="2">
<?php
        if ($msg == $message->getId()) {
            echo $message->getMessage();
        } else {
            echo "<a href='outbox.php?id=" . $message->getId() . "'>" . substr($message->getMessage(), 0, 30) . "</a>";
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


