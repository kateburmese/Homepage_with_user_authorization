<?php 

session_start();

require 'config.php';



if(!empty($_POST)){
    $email= $_POST['email'];
    $password= $_POST['password'];

    $sql= 'SELECT * FROM users WHERE email= :email';
    $stmt= $pdo->prepare($sql);

    $stmt->bindValue(':email',$email);

    $stmt-> execute();

    $user= $stmt->fetch(PDO::FETCH_ASSOC);
    // print'<pre>';
    // print_r($user);

    if(empty($user)){
        echo '<script>alert("User is not exit. Tryagain!")</script>';
    }else{
        $validPassword= password_verify($password,$user['pwd']);

        if($validPassword){
            $_SESSION['user_id']= $user['id'];
            $_SESSION['logged_in']= time();

            header("Location: index.php");
            exit();
        }else{
            echo("<script>alert('Password is incorrect. Tryagain!')</script>");
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
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h1>Login </h1>
            <form action="login.php" method='post'>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" value="" required>
                </div>
                <div class="form-group">
                    <input type="submit" name= "login" value="Login" class="btn btn-primary from-control">
                    <a href="register.php">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>