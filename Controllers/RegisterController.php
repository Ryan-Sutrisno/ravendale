<?php

use Josantonius\Session\Facades\Session;
require '../DB/Database.php';
require '../vendor/autoload.php';
require '../classes/Register.php';

class RegisterController extends Register
{
    private $username;
    private $email;
    private $password;
    private $repeatpassword;

    public function __construct($username, $email, $password, $repeatpassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->repeatpassword = $repeatpassword;
    }

    public function registerUser()
    {
        $session = new Session();
        $session->start();

        if ($this->emptyInput() == false) {
            $session->set('error', "Please fill in all fields.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->passwordLength() == false) {
            $session->set('error', "Password must be at least 8 characters.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->invalidEmail() == false) {
            $session->set('error', "Invalid email format.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->passwordMatch() == false) {
            $session->set('error', "Passwords do not match.");
            header("Location: ../views/register.php");
            exit;
        }

        if ($this->checkUsername() == false) {
            $session->set('error', "Username or email already exists.");
            header("Location: ../views/register.php");
            exit;
        }

        // Create user
        $this->setUser($this->username, $this->email, $this->password);
        $session->set('success', "Registration successful! Please log in.");
        header("Location: ../views/login.php");
        exit;
    }

    private function emptyInput()
    {
        return !(empty($this->username) || empty($this->email) || empty($this->password) || empty($this->repeatpassword));
    }

    private function passwordLength()
    {
        return strlen($this->password) >= 8;
    }

    private function invalidEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordMatch()
    {
        return $this->password === $this->repeatpassword;
    }

    private function checkUsername()
    {
        return $this->checkUser($this->username, $this->email);
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

