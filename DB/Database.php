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
    /**
     * Seeds the given table in the database based on the table name, columns that you want to seed and the seed data.
     * @param mixed $table
     * @param mixed $columns
     * @param mixed $data
     */
    protected function seedTable(mixed $table, mixed $columns, mixed $data)
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

    /**
     * Drops the given table data but keeps the columns intact.
     * @param mixed $table
     */
    protected function dropTable(mixed $table)
    {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM $table");
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
