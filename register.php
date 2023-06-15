<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");


if(isset($_POST['submit']) && isset($_FILES['image'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded/' .$image;

    $sql = "SELECT * FROM users WHERE email= '$email'";

    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if($count > 0) {
        $message[] = 'email already exists!';
    } 
    else 
    {
            if($pass != $cpass)
            {
                $message[] = 'confirm password not matched!';
            } 
            else 
            {
                $user_type = $_POST['user_type'];
                $sql = "INSERT INTO `users`(name, email, password, user_type, image)
                 VALUES('$name', '$email', '$pass', 'user','$image')";
                $insert_user = mysqli_query($conn, $sql);
                if($insert_user) {
                    $message[] = 'registered successfully, login now please!';
                } else {
                    $message[] = 'Something Went Wrong';
                }
                if($insert_user){
                    if($image_size > 2000000){
                        $message[] = 'image size is too large';
                    }else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'Registered successfully';
                        header('location:login.php');
                    }
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
    <title>Register</title>
     <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/compnents.css">
</head>
<body>


<?php
        if (isset($message)) {
            foreach($message as $message){
            echo '<div class="message">
            <span>'.$message.'</span>
                      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
        }
    }
    ?>
   <section class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username"  class="box">
      <input type="email" name="email" required placeholder="enter your email"  class="box">
      <input type="password" name="pass" required placeholder="enter your password"   class="box" >
      <input type="password" name="cpass" required placeholder="confirm your password"   class="box" >
      <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account?
      <a href="login.php">login now</a></p>
   </form>
   </section> 
</body>
</html>