<?php
include_once '../header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>

<body>
    <?php

    $sql = "SELECT DISTINCT e.noemp FROM emp 
INNER JOIN emp e2 on e.noemp = e2.sup;";
    $sups = maQuery($sql, 'select');
    $sups_1d = [];
    foreach ($sups as $sup) {
        $sups_1d[] = $sup['noemp'];
    }
    if (!in_array($_GET['noemp'], $sups_1d)) {
        $noemp = $_GET['noemp'];
        $sql = "DELETE FROM emp WHERE noemp = '$noemp';";
        maQuery($sql, 'nop');
        header("Location: ../tableau-connecte.php?suppression=succes");
    }


    ?>
</body>

</html>