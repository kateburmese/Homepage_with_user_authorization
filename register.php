<?php

    require 'config.php';

    
    if(!empty($_POST)){
        $username= $_POST['username'];
        $email= $_POST['email'];
        $password= $_POST['password'];

        if($username == '' || $email == '' || $password==''){
            echo '<script>alert("Form is not completed.")</script>';
        }else{
            //query prepare
            $abc= "SELECT COUNT(email) AS num FROM users WHERE email= :email";
            $def= $pdo->prepare($abc);

            //bind statement
            $def->bindValue(':email',$email);
            //execute statement
            $def->execute();

            $row= $def->fetch(PDO::FETCH_ASSOC);  //rs - array(1) { ["num"]=> string(1) "0" }
            // var_dump($row);

            if($row['num'] > 0){
                echo "<script>alert('This user is already exits.')</script>";
            
            }else{
                $passwordHash= password_hash($password,PASSWORD_BCRYPT);
                $qry= "INSERT INTO users(name,email,pwd) VALUES (:username,:email,:password)";
                $stat= $pdo->prepare($qry);

                $stat->bindValue(':username',$username);
                $stat->bindValue(':email',$email);
                $stat->bindValue(':password',$passwordHash);

                $result= $stat->execute();
                

                if($result){
                    echo "Thanks for your registration!"."<a href='login.php'>Login</a>";
                }else{
                    echo "Try Again";
                }
            }
            
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register From</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="card">
        <div class="card-body">
            
            <h1>Register</h1>
            <form action="register.php" method="post">
                <div class="form-gorup">
                    <label for="username">Name</label>
                    <input class="form-control"type="text" name='username' value='' required >
                </div>
                <div class="form-gorup">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name='email' value='' required>
                </div>
                <div class="form-gorup">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name='password' value='' required>
                </div>
                <div class="form-group">
                    <input type="submit" class='btn btn-primary' value='Register'>
                    <a href="login.php">Login</a>
                </div>
            </form>
        </div>
    </div>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script> -->
</body>
</html>