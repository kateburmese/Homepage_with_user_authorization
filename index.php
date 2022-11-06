<?php

echo('Welcome to Home page.');

session_start();

require 'config.php';

$myfile= fopen("new2file.txt","w");
$txt= "Micky Mouse";
fwrite($myfile,$txt);
$txt= "Minnie Mouse";
fwrite($myfile,$txt);
fclose($myfile);

$myfile= fopen("new2file.txt","a")or die("Unable to open the file");
$txt= "Nan";
fwrite($myfile,$txt);
$txt= "Thu";
fwrite($myfile,$txt);
fclose($myfile);


if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
    echo "
        <script>
            alert('Please Login to continue!');
            window.location.href='login.php';
        </script>
    ";
}
// session_start();
//     if(!isset($_SESSION['user_id'])) {
//     header('location: login.php');
//     exit();
//     }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        $stat= $pdo->prepare("SELECT * FROM post ORDER BY id DESC");
        
        $stat-> execute();

        $result= $stat->fetchAll();
        
        // print '<pre>';
        // var_dump($result);
        // exit();
    ?>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <h1>Post Management</h1>
                <div>
                    <a class="btn btn-success" href="add.php">Create New</a>
                    <a style="float:right"class= "btn btn-primary" href="logout.php">Logout</a>
                </div>
                <thead>
                    <tr>
                        <th width="20%">Title</th>
                        <th width="40%">Description</th>
                        <th width="20%">Created At</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result){
                        foreach ($result as $value) {
                        // print"<pre>";
                        // var_dump($value);exit();
                        
                    ?>
                        <tr>
                            <td><?php echo $value['title']?></td>
                            <td><?php echo $value['description']?></td>
                            <td><?php echo $value['created_at']?></td>
                            <td>
                                <a href="update.php?id=<?php echo $value['id']?>">Edit</a>
                                <a href="delete.php?id=<?php echo $value['id']?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>