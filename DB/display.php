<?php

class Display extends Database
{
    public function getCategories()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM categories ORDER BY id");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
