<?php 

require('config.php');

if(!empty($_POST)){
    // $getsize= getimagesize($_FILES['image']['tmp_name']);
    // print"<pre>";
    // print_r($_FILES);
    // if($getsize){
    //     echo "File is an image - " . $getsize["mime"] . ".";
    // }else{
    //     echo "Sorry";
    // }
    // exit();

    $targetFile= 'images/'.($_FILES['image']['name']);
    $imageFileType= pathinfo($targetFile,PATHINFO_EXTENSION);
    
    print"<pre>";
    // print_r($_FILES);

    if($imageFileType != 'jpg' && $imageFileType != 'png' &&$imageFileType != 'jpeg' &&$imageFileType != 'gif'){
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
    }else{
        move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);

        $title= $_POST['title'];
        $desc= $_POST['description'];
        $crt= $_POST['created_at'];

        // var_dump($title,$desc,$crt);exit();
        $php= "INSERT INTO post(title,description,image,created_at) VALUES (:title, :description,:image, :created_at)";
        $stat= $pdo-> prepare($php);
        $success= $stat->execute(
            array(':title'=>$title,':description'=>$desc,':created_at'=>$crt,
            ':image'=>$_FILES['image']['name'])
        );
        if($success){
            echo "<script>alert('Posted!'), window.location.href='index.php'</script>";
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
    <title>Post Create From</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="card ">
        <div class="card-body">
            
            <h1>Post Creation</h1>
            <form action="add.php" method="post" enctype="multipart/form-data">
                <div class="form-gorup">
                    <label for="title">Title</label>
                    <input class="form-control"type="text" name='title' value='' required >
                </div>
                <div class="form-gorup">
                    <label for="description">Description</label>
                    <!-- <input class="form-control" type="email" name='email' value='' required> -->
                    <textarea name="description" id="" cols="30" rows="6" class="form-control"></textarea>
                </div><br/>
                <div class="form-gorup">
                    <label for="image">Images</label>
                    <input class="form-control"type="file" name='image' value='' required >
                </div><br/>
                <div class="form-gorup">
                    <label for="created_at">Pickup the date-time</label>
                    <input class="form-control" type="date" name='created_at' value='<?php echo date("Y-m-d")?>' >
                </div>
                <div class="form-group">
                    <input type="submit" class='btn btn-primary' value='Post'>
                    <a href="index.php" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>
