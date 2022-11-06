<?php 

    require "config.php";

    $stat= $pdo->prepare("DELETE FROM post WHERE id=".$_GET['id']);
    $stat->execute();

    header("Location: index.php");


?>