<?php

$servername = 'localhost';
$username = 'twitter';
$password = 'twitter';
$baseName = 'twitter';


$conn = new mysqli($servername, $username, $password, $baseName);

if ($conn->connect_errno) {
    die('Nieudane połączenie z bazą danych. Błąd: ' . $conn->error . 'Kod błedu:'
            . $conn->errno);
}

?>