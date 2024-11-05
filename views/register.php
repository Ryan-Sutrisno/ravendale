<?php
require '../vendor/autoload.php';
use Josantonius\Session\Facades\Session;
session_start();

$error = Session::get('error');
$success = Session::get('success');
Session::pull('error');
Session::pull('success');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="../Controllers/RegisterController.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="repeatPassword">Repeat Password</label>
        <input type="password" name="repeatPassword" id="repeatPassword">
        
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
