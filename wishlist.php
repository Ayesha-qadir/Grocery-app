<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){

};

if(isset($_POST['add_to_cart'])){
   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_POST['image'];   
   $quantity = $_POST['quantity'];
   
   $check_cart_numbers = "SELECT * FROM `cart` WHERE name = '$name' AND user_id = '$user_id'";
   $cart_numbers=mysqli_query($conn, $check_cart_numbers );
   $count_cart = mysqli_num_rows($cart_numbers);
   if( $count_cart > 0){
      $message[] = 'already added to cart!';
   }
    else{
      $check_wishlist ="SELECT * FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'";
      $wishlist_numbers= mysqli_query($conn, $check_wishlist);
      $check_wishlist_numbers= mysqli_num_rows( $wishlist_numbers);

      if( $check_wishlist_numbers > 0){
         $delete_wishlist = "DELETE FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'";
         $delete= mysqli_query($conn, $delete_wishlist);
      }

      $insert_cart = "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id','$pid','$name','$price','$quantity','$image')";
      $cart= mysqli_query($conn,  $insert_cart );
      $message[] = 'added to cart!';
   }

}
if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_wishlist_item = "DELETE FROM `wishlist` WHERE id = '$delete_id'";
   $delete_wishlist= mysqli_query($conn, $delete_wishlist_item);
   header('location:wishlist.php');

}

if(isset($_GET['delete_all'])){

   $delete_wishlist_item = "DELETE FROM `wishlist` WHERE user_id = '$user_id'";
   $delete_wishlist= mysqli_query($conn, $delete_wishlist_item);
   header('location:wishlist.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="wishlist">

   <h1 class="title">products added</h1>

   <div class="box-container">
   <?php
      $grand_total = 0;
      $select_wishlist = "SELECT * FROM `wishlist` WHERE user_id = '$user_id'";
      $wishlist = mysqli_query($conn , $select_wishlist );
      $select_wishlist_number = mysqli_num_rows($wishlist);
      if($select_wishlist_number > 0){
         while($fetch_wishlist = mysqli_fetch_assoc($wishlist)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="wishlist.php?delete=<?= $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
      <a href="view_page.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
      <input type="number" min="1" value="1" class="qty" name="quantity">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   </form>
   <?php
      $grand_total += $fetch_wishlist['price'];
      }
   }else{
      echo '<p class="empty">your wishlist is empty</p>';
   }
   ?>

   </div>

   <div class="wishlist-total">
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?> ">delete all</a>
   </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>