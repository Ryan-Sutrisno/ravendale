<?php

use Josantonius\Session\Facades\Session;
require '../vendor/autoload.php';


class RegisterController extends Register
{
    use RegisterException;

    private $username;
    private $email;
    private $password;
    private $repeatPassword;

    public function __construct($username, $email, $password, $repeatPassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->repeatPassword = $repeatPassword;
    }

    public function registerUser()
    {
        $session = new Session();
        $session->start();

        if ($this->emptyInput($this->username, $this->email, $this->password, $this->repeatPassword) == false) {
            Session::set('error', "Please fill in all fields.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->passwordLength($this->password) == false) {
            Session::set('error', "Password must be at least 8 characters.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->invalidEmail($this->email) == false) {
            Session::set('error', "Invalid email format.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->passwordMatch($this->password, $this->repeatPassword) == false) {
            Session::set('error', "Passwords do not match.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->existingUser() == false) {
            Session::set('error', "Username or email already exists.");
            header("Location: ../views/register.php");
            exit;
        }

        $this->createUser($this->username, $this->email, $this->password);
        Session::set('success', "Registration successful! Please log in.");
        header("Location: ../views/login.php");
        exit;
    }

    private function existingUser(): bool
    {
        return $this->getUser($this->username, $this->email);
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    $register = new RegisterController($username, $email, $password, $repeatPassword);
    $register->registerUser();
}

