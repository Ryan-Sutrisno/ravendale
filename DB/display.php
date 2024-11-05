<?php

require_once './layouts/include.php';

function getCategories() {
    $database = new Database();
    $stmt = $database->connect()->prepare("SELECT * FROM categories ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll();

   }
?>