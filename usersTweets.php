<?php
//show chosen user tweets
include_once 'src/User.php';
include_once 'src/Tweet.php';
include_once 'src/Comment.php';
require_once 'src/connection.php';

session_start();
if (!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $followedUserId = $_GET['followedUserId'];

    $tweetsTable = Tweet::loadAllTweetsByUserId($conn, $followedUserId);
    $username = User::loadUsernameByUserId($conn, $followedUserId);

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
<?php
if ($followedUserId != $_SESSION['loggedUserId']) {
?>
        <form method="POST" action="outbox.php" class="tweet">
            <h2>Wyślij prywatną wiadomość użytkownikowi <?=$username?></h2>
            <textarea id="message_text" rows="4" cols="50" maxlength="140" 
                      name="message" placeholder="Napisz wiadomość"></textarea><br>
                <br>
            <input type="submit" id="message_submit" value="Wyślij">
        </form>
<?php
}
?>
        <hr>
<?php
if ($tweetsTable) {
        foreach ($tweetsTable as $tweet) {
            $commentsNumber = Comment::countCommentsByTweetId($conn, $tweet->getId());
?>
                <table class="tweets">
            <tr>
                <td id="topLeft">
                    <a href="usersTweets.php?followedUserId=<?=$tweet->getUserId();?>"><?=$tweet->username?></a>
                </td>
                <td id="topRight" colspan="2">
                    <?=date('d-m-Y, G:i:s', $tweet->getCreationDate())?>
                </td>
            </tr>
            <tr>
                <td id="center" colspan="3">
                    <?=$tweet->getTweet()?>
                </td>
            </tr>
            <tr>
                <td id="bottomLeft">
                    Komentowano: 
                </td>
                <td id="bottomCenter">
                    <a class="countComment" href='discussion.php?tweetId=<?=$tweet->getId()?>'><?=$commentsNumber?></a> razy
                </td>
                <td id="bottomRight">
                    <a class="button" href='discussion.php?tweetId=<?=$tweet->getId()?>'>Skomentuj</a>
                </td>
            </tr>
        </table><br>
<?php      
        }
    }
}
?>        
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>