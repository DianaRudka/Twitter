<?php
// main page
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
    if ($_POST['newTweet'] != '') {
        $userId = $_SESSION['loggedUserId'];
        $tweet = $_POST['newTweet'];
        $creationDate = time();
        
        $newTweet = new Tweet();
        $newTweet->setUserId($userId);
        $newTweet->setTweet($tweet);
        $newTweet->setCreationDate($creationDate);
        
        if (!$newTweet->saveToDB($conn)) {
            echo 'Somethogn went wrong. Try again';
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
                    <a href="inbox.php">Wiadomości  <?=$msgCount?></a>
                </li>
                <li>
                    <a href="accountAdjustment.php">Ustawienia konta</a>
                </li>
            </ul>
        </div>       
        
        <form method="POST" action="" class="tweet">
            <h2>Tweetnij</h2>
            <textarea id="tweet_text" rows="4" cols="50" maxlength="140" 
                      name="newTweet" placeholder="Napisz co się dzieje. Masz 140 znaków"></textarea><br>
            <br>
            <input type="submit" id="tweet_submit" value="Tweetnij">
        </form>
        <hr>
<?php
$tweetsTable = Tweet::loadAllTweets($conn);
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
?>        
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>