<?php

class Database
{
    public function connect(): PDO
    {
        try {
            $pdo = new PDO(DSN, USER, PASS);
            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $pdo;
    }

    public function seedTable($table, $columns, $data)
    {
        try {
            $columnNames = implode(", ", $columns);
            $placeholders = implode(", ", array_map(function ($col) {
                return ":$col";
            }, $columns));

            $stmt = $this->connect()->prepare("INSERT INTO $table ($columnNames) VALUES ($placeholders)");

            foreach ($data as $row) {
                $stmt->execute(array_combine(array_map(function ($col) {
                    return ":$col";
                }, $columns), $row));
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
