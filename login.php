<?php
require_once 'src/User.php';
require_once 'src/connection.php';
// login page
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET)) {
        if ($_GET['status'] == 'new') {
            echo "Rejestracja powiodła się";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    

    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    
    if ($loginTable = User::loadUserIdByEmail($conn, $email, $password)) {
       $_SESSION['loggedUserId'] = $loginTable['id'];
       $_SESSION['loggedUserName'] = $loginTable['username'];
       header('Location: index.php');
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
        <script src="js/app.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <form method="POST" action="" class="login">
            <h2>Logowanie</h2>
            <input type="email" id="email" name="email" placeholder="E-mail"><br>
            <input type="password" id="password" name="password" placeholder="Hasło">
            <input type="submit" id="button" value="Zaloguj się">
            <div>
                <label class="register">
                Pierwszy raz na Tweeterze?
                <a id="register" href="newUser.php">Zarejestruj się</a>
                </label>
            </div>
        </form>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>