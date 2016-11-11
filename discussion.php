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
    if ($_POST['newComment'] != '') {
        $userId = $_SESSION['loggedUserId'];
        $tweetId = $_GET['tweetId'];
        $commentary = $_POST['newComment'];
        $commentDate = time();
        
        $newComment = new Comment();
        $newComment->setUserId($userId);
        $newComment->setTweetId($tweetId);
        $newComment->setCommentDate($commentDate);
        $newComment->setCommentary($commentary);
        
        if ($newComment->saveToDB($conn)) {
            
        } else {
            echo 'Somethogn went wrong. Try again';
        }
    }
    
}
$tweetToComment = Tweet::loadTweetById($conn, $_GET['tweetId']);
$username = User::loadUsernameByUserId($conn, $tweetToComment->getUserId());

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
        <table class="tweets">
            <tr>
                <td>
                    <a href="usersTweets.php?followedUserId=<?=$tweetToComment->getUserId()?>">
                        <?=$username?>
                    </a>
                </td>
                <td>
                    <?=date('d-m-Y, G:i:s', $tweetToComment->getCreationDate())?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?=$tweetToComment->getTweet()?><br>
<!--                    <a class="button" href='discussion.php'>Skomentuj</a>-->
                </td>
            </tr>
        </table>
        <br>
        <form method="POST" action="" class="comment">
            <h2>Skomentuj tweeta</h2>
            <textarea id="comment_text" rows="4" cols="50" maxlength="60" 
                      name="newComment" placeholder="Twój komentarz. Masz 60 znaków"></textarea><br>
            <br>
            <input type="submit" id="comment_submit" value="Komentuj">
        </form>
        <hr>
<?php
$commentsTable = Comment::loadAllCommentsByPostId($conn, $_GET['tweetId']);
if ($commentsTable) {
    foreach ($commentsTable as $comment) {
?>
        <table class="comment">
            <tr>
                <td>
                    <a href="userTweets.php?followedUserId=<?=$comment->getUserId();?>"><?=$comment->username?></a>
                </td>
                <td>
                    <?=date('d-m-Y, G:i:s', $comment->getCommentDate())?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?=$comment->getCommentary()?><br><br>
<!--                    <a class="button" href='discussion.php'>Skomentuj</a>-->
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
