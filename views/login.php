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
    <title>Document</title>
</head>

<body>
    <h1>Login</h1>
<?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="../Controllers/LoginController.php" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>