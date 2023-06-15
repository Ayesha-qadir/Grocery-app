<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Groco<span>.</span></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="shop.php">shop</a>
         <a href="orders.php">orders</a>
         <a href="about.php">about</a>
         <a href="contact.php">contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>

         <?php

           $count_cart_items = "SELECT * FROM `cart` WHERE user_id =  '$user_id'";
           $cart_items = mysqli_query($conn,  $count_cart_items);
           $number_cart_item = mysqli_num_rows($cart_items);

             $count_wishlist_items = "SELECT * FROM `wishlist` WHERE user_id = '$user_id'";
             $result = mysqli_query($conn,  $count_wishlist_items);
             $number_wishlist_item = mysqli_num_rows($result);
         ?> 

         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $number_wishlist_item ;?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $number_cart_item ;?>)</span></a>
      </div>
      
      <div class="profile">
      <?php
            $select_profile = "SELECT * FROM `users` WHERE id = '$user_id'";
            $profile= mysqli_query($conn, $select_profile );
            $fetch_profile = mysqli_fetch_assoc($profile);
         ?>
         
        
         <a href="user_profile_update.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>
   </div>

</header>


