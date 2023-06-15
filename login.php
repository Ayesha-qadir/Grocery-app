<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

if(isset($_POST['submit'])){
   
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE email= '$email' AND password='$pass'";

    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc( $result);
    if($count > 0) {
        if($row['user_type'] == 'admin'){
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
   }
   elseif($row['user_type'] == 'user'){
    $_SESSION['user_id'] = $row['id'];
    header('location:home.php');

}else{
    $message[] = 'no user found!';
 }

}else{
 $message[] = 'incorrect email or password!';
}

} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
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
      <h3>Login now</h3>
      <input type="email" name="email" required placeholder="enter your email"  class="box">
      <input type="password" name="pass" required placeholder="enter your password"   class="box" >
      <input type="submit" value="Login now" class="btn" name="submit">
      <p>Don't have an account?
      <a href="register.php">register now</a></p>
   </form>
   </section> 
</body>
</html>