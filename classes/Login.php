<?php

use Josantonius\Session\Facades\Session;

class Login extends Database
{
    public function authenticateUser($email, $password)
    {
        $stmt = $this->connect()->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
        $stmt->bindParam(1, $email);
        
        if (!$stmt->execute()) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            Session::set('accountnotfound', "Account not found");
            exit;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($password, $user['password'])) {
            Session::set("wrongpassword", "Wrong password!");
            exit;
        }

        $this->initializeSession($user);
        $stmt = null;
    }

    private function initializeSession($user)
    {
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('email', $user['email']);
    }
}
