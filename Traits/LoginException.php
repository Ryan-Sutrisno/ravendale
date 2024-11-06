<?php

trait LoginException
{
    private function emptyInput(): bool
    {
        return !(empty($this->email) || empty($this->password));
    }

    private function nonExistentUser($email): bool
    {
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true;
        }

        return false;
    }
}