<?php
//registration page
include_once 'src/User.php';
require_once 'src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (strlen($_POST['password']) > 4) {
    
        $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : null;
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
        $password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : null;
        $confirmationPassword = isset($_POST['confirmationPassword']) ? 
                $conn->real_escape_string($_POST['confirmationPassword']) : null;

        $oldUser = User::loadUserByEmail($conn, $email);
        if ($password == $confirmationPassword && $username && $email && !$oldUser) {
            $newUser = new User();
            $newUser->setEmail($email);
            $newUser->setUsername($username);
            $newUser->setHashsedPassword($password);
            if($newUser->saveToDB($conn)) {
                header('Location: login.php?status=new');
            } else {
                echo 'Rejestracja nie powiodła się';
            }
        } else {
            if ($oldUser) {
                echo 'Użytkownik z takim adresem email jest już zarestrowny<br>';
            } else {
                echo 'Niepoprawne dane logowania<br>';
            }
        }
    } else {
        echo 'Za krótkie hasło<br>';
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
    <form method="POST" action="" class="register">
        <h2>Załóż konto</h2>
        <label>Login*<br>
        <input type="text" id="username" name="username" placeholder="Imię i nazwisko"><br>
        </label>
        <label>E-mail*<br>
        <input type="email" id="email" name="email" placeholder="E-mail"><br>
        </label>
        <label>Hasło*<br>
        <input type="password" id="password" name="password" placeholder="Hasło"><br>
        </label>
        <label>Powtórz hasło*<br>
        <input type="password" id="confirmationPassword" name="confirmationPassword" placeholder="Powtórz hasło"><br>
        </label>
        <br>
        <input type="submit" id="button" value="Zarejestruj się">
        <br>
        *- pozycje obowiązkowe<br><br>
        <div>
            <label class="login">
            Masz już konto?
            <a id="login" href="login.php">Zaloguj się</a>
            </label>
        </div>
    </form>
</body>
</html>

<?php
$conn->close();
$conn = null;
?>