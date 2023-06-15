<?php


$conn = mysqli_connect("localhost", "root", "", "shop_db");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/compnents.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
      <?php 
         $total_pending = 0;
         $select_pending = "SELECT * FROM `orders` WHERE payment_status = 'pending'";
         $pending=mysqli_query($conn,   $select_pending);
         while($fetch_completed = mysqli_fetch_assoc($pending)){
            $total_pending += $fetch_completed['total_price'];
         };
      ?>  
      <h3>$<?= $total_pending; ?>/-</h3>
      <p>total pendings</p>
      <a href="admin_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php 
         $total_completed = 0;
         $select_completed = "SELECT * FROM `orders` WHERE payment_status = 'completed'";
         $completed=mysqli_query($conn,  $select_completed);
         while($fetch_completed = mysqli_fetch_assoc($completed)){
            $total_completed += $fetch_completed['total_price'];
         };
      ?>
      <h3>$<?= $total_completed; ?>/-</h3>
      <p>completed orders</p>
      <a href="admin_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php
         $select_orders = "SELECT * FROM `orders`";
         $orders=mysqli_query($conn,  $select_orders);
         $number_of_orders = mysqli_num_rows( $orders);
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>orders placed</p>
      <a href="admin_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php
         $select_products = "SELECT * FROM `products`";
         $products=mysqli_query($conn,  $select_products );
         $number_of_products = mysqli_num_rows( $products);
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>products added</p>
      <a href="admin_products.php" class="btn">see products</a>
      </div>

      <div class="box">
      <?php
         $select_accounts = "SELECT * FROM `users`";
         $accounts= mysqli_query($conn,  $select_accounts );
         $number_of_accounts = mysqli_num_rows( $accounts);
      ?>
      <h3><?= $number_of_accounts; ?></h3>
      <p>total accounts</p>
      <a href="admin_users.php" class="btn">see accounts</a>
      </div>

      <div class="box">
      <?php
         $select_users ="SELECT * FROM `users` WHERE user_type = 'user'";
         $users=mysqli_query($conn,  $select_users );
         $number_of_users = mysqli_num_rows($users);
      ?>
      <h3><?= $number_of_users; ?></h3>
      <p>total users</p>
      <a href="admin_users.php" class="btn">see accounts</a>
      </div>

      <div class="box">
      <?php
         $select_messages = "SELECT * FROM `message`";
         $messages= mysqli_query($conn, $select_messages );
         $number_of_messages = mysqli_num_rows($messages);
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>total messages</p>
      <a href="admin_contacts.php" class="btn">see messages</a>
      </div>

   </div>

</section>

<script src="js/script.js"></script>