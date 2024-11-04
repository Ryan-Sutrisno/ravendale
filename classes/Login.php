<?php

use Josantonius\Session\Facades\Session;

session_start();

class Login extends Database
{
    protected function getUser($email, $password)
    {
        $session = new Session();
        $stmt = $this->connect()->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bindParam(1, $email);

        if (!$stmt->execute()) {
            $stmt = null;
            header("Location: ../views/login.php?error=sqlerror");
            exit;
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            $session->set('accountnotfound', "Account not found!");
        }
    }
}