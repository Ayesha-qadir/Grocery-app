<?php


$conn = mysqli_connect("localhost", "root", "", "shop_db");

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_message = "DELETE FROM `message` WHERE id = '$delete_id'";
    $delete_message_query = mysqli_query($conn, $delete_message);
    header('location:admin_contacts.php');
 
 }
 
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">messages</h1>

   <div class="box-container">

   <?php
      $select_message = "SELECT * FROM `message`";
      $select_message_query = mysqli_query($conn, $select_message);
      $select_message_numbers = mysqli_num_rows($select_message_query);
      if($select_message_numbers > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message_query)){
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_message['user_id']; ?></span> </p>
      <p> name : <span><?= $fetch_message['name']; ?></span> </p>
      <p> number : <span><?= $fetch_message['number']; ?></span> </p>
      <p> email : <span><?= $fetch_message['email']; ?></span> </p>
      <p> message : <span><?= $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages!</p>';
      }
   ?>

   </div>

</section>













<script src="js/script.js"></script>

</body>
</html>