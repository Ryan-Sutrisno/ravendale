<?php

trait RegisterException
{
    private function emptyInput($username, $email, $password, $repeatPassword): bool
    {
        return !(empty($username) || empty($email) || empty($password) || empty($repeatPassword));
    }

    private function passwordLength($password): bool
    {
        return strlen($password) >= 8;
    }

    private function invalidEmail($email): mixed
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordMatch($password, $repeatPassword): bool
    {
        return $password === $repeatPassword;
    }
}