<?php 
    require('config.php');

    if(!empty($_POST)){
        $title= $_POST['title'];
        $desc= $_POST['description'];
        $crt= $_POST['created_at'];
        $id= $_GET['id'];
        
        $imgname= $_FILES['image']['name'];

        if($imgname){
            $targetFile= 'images/'.$imgname;
            $imageFileTyp= pathinfo($targetFile,PATHINFO_EXTENSION);
        
            if($imageFileTyp != 'jpg' && $imageFileTyp != 'png' &&$imageFileTyp != 'jpeg' &&$imageFileTyp != 'gif'){
                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
            }else{
                move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
        
                // var_dump($title,$desc,$crt);exit();
                $stat= $pdo->prepare("UPDATE post set title= '$title', description='$desc',image= '$imgname', created_at='$crt'
                                WHERE id= '$id'");
                // print_r($stat);exit();
                $success= $stat->execute();
                
            }
        }else{
            $stat= $pdo->prepare("UPDATE post set title= '$title', description='$desc', created_at='$crt'
                                WHERE id= '$id'");
                // print_r($stat);exit();
            $success= $stat->execute();
            
        }
        if($success){
            echo "<script>alert('Record is updated'),window.location.href='index.php'</script>";
        }else{
            echo "Try again";
        }
        


        
        
      
    }

    $stat= $pdo->prepare("SELECT * FROM post where id=".$_GET["id"]);

    $stat-> execute();

    $result= $stat->fetchAll();

    // print"<pre>";
    // var_dump($result);
    // exit();



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
            
            <h1>Post Edition</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- <input type="hidden" name="id" value="<?php echo $result[0]['id']?>" class="" > -->
                <div class="form-gorup">
                    <label for="title">Title</label>
                    <input class="form-control"type="text" name='title' value='<?php echo $result[0]['title']?>' required >
                </div>
                <div class="form-gorup">
                    <label for="description">Description</label>
                    <!-- <input class="form-control" type="email" name='email' value='' required> -->
                    <textarea name="description" id="" cols="30" rows="6" class="form-control"><?php echo $result[0]['description']?></textarea>
                </div><br>
                <div class="form-gorup">
                    <label for="image">Images</label><br/>
                    <img src="images/<?php echo $result[0]['image']?>" alt="" width="100" height="100"><br/><br/>
                    <input class="form-control"type="file" name='image' value=''  >
                </div><br/>
                <div class="form-gorup">
                    <label for="created_at">Pickup the date-time</label>
                    <input class="form-control" type="date" name='created_at' value='<?php echo $result[0]['created_at']?>' >
                </div>
                <div class="form-group">
                    <input type="submit" class='btn btn-primary' value='Update'>
                    <a href="index.php" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>