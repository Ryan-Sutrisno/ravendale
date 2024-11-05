<?php

class Database
{
    public function connect(): PDO
    {
        $host = 'localhost';
        $dbname = 'ravendale';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
           );

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $pdo;
    }
}