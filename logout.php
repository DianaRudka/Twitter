<?php
// logout page
session_start();

if ($_SESSION['loggedUserId']) {
    unset($_SESSION['loggedUserId']);
}
header('Location: index.php');
?>