<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['send'])){
   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $msg = $_POST['msg'];

    $select_message = "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'";
    $result = mysqli_query($conn,  $select_message);
    $count = mysqli_num_rows($result);

    if($count > 0) {
        $message[] = 'email already exists!';
    } else{
            $sql ="INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id','$name','$email','$number','$msg')";
            $insert_user = mysqli_query($conn, $sql);
            $message[] = 'sent message successfully!';
    

} 
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <h1 class="title">get in touch</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="enter your name">
      <input type="email" name="email" class="box" required placeholder="enter your email">
      <input type="number" name="number" min="0" class="box" required placeholder="enter your number">
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" class="btn" name="send">
   </form>

</section>
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>