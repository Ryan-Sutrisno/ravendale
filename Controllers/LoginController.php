<?php

use Josantonius\Session\Facades\Session;
require '../vendor/autoload.php';


class LoginController extends Login
{
    use LoginException;

    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function loginUser()
    {
        Session::start();
        if ($this->emptyInput() == false) {
            Session::set('error', 'please fill in all the fields');
            header("Location: ../views/login.php");
            exit;
        }

        if ($this->nonExistentUser($this->email) == true) {
            Session::set('error', "User does not exist");
            header("Location: ../views/login.php");
            exit;
        }

        $this->authenticateUser($this->email, $this->password);
        Session::set('success', 'Logged in succesfully');
        header("Location: ../index.php");
        exit;
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = new LoginController($email, $password);
    $login->loginUser();
}
