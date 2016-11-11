<?php
//replay message page
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
    $msgId = $_POST['rplMsgId'];
    $replayMsg = Message::loadMessageByMessageId($conn, $msgId);

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
<?php
if ($replayMsg) {
    $username = User::loadUsernameByUserId($conn, $replayMsg->getSenderId());
}
?>
        <form method="POST" action="inbox.php" class="tweet">
            <h2>Odpowiedz:</h2>
            <textarea id="message_text" rows="6" cols="70"
                      name="message" placeholder="Napisz wiadomość">
W dniu <?=date('d-m-Y, G:i:s', $replayMsg->getCreationDate())?> użytkownik <?=$username?> napisał:
<?=$replayMsg->getMessage()?></textarea>
            <br><br>
            <input type="submit" id="message_submit" value="Wyślij">
            <input name="rplMsgId" value="<?=$msgId?>" type="hidden">
            <input name="rplMsgSenderId" value="<?=$replayMsg->getSenderId()?>" type="hidden">
        </form>
<?php
}
?> 
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>