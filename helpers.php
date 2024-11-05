<?php

function dd(mixed $data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}

function authCheck()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: views/login.php");
        exit;
    }
}
