<?php

class Register extends Database
{
    protected function setUser($username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connect()->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $hashedPassword);

        if (!$stmt->execute()) {
            $stmt = null;
            header("Location: ../views/register.php");
            exit;
        }

        $stmt = null;
    }

    protected function checkUser($username, $email)
    {
        $stmt = $this->connect()->prepare("SELECT username FROM users WHERE username = ? OR email = ?");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);

        if (!$stmt->execute()) {
            $stmt = null;
            header("Location: ../views/register.php");
            exit;
        }

        return !($stmt->rowCount() > 0);

    }
}