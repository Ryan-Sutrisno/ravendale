<?php
require "./layouts/include.php";
require './DB/display.php';

$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        foreach ($categories as $categorie):
        $name = $categorie["name"];
        $description = $categorie["description"];
        ?>
    <h1> <?= $name ?> </h1>
    <h1> <?= $description ?> </h1>

    <?php endforeach; ?>

</body>
</html>