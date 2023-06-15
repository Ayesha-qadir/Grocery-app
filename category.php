<?php


$conn = mysqli_connect("localhost", "root", "", "shop_db");

if(isset($_POST['add_to_wishlist'])){
   $user_id = $_POST['user_id'];
   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_POST['image'];
   

   $check_wishlist_numbers = "SELECT * FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'";
   $wishlist_result = mysqli_query($conn,   $check_wishlist_numbers);
   $count_wishlist = mysqli_num_rows(  $wishlist_result);   

   if( $count_wishlist > 0){
      $message[] = 'already added to wishlist!';
   }
   else{
      $insert_wishlist = "INSERT INTO `wishlist`( user_id, pid, name, price, image) VALUES('$user_id','$pid','$name','$price','$image')";
      $insert_result = mysqli_query($conn, $insert_wishlist );
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){
   $user_id = $_POST['user_id'];
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

<section class="products">

   <h1 class="title">products categories</h1>

   <div class="box-container">

   <?php
      $category_name = $_GET['category'];
      $select_products = "SELECT * FROM `products` WHERE category = '$category_name'";
      $products= mysqli_query($conn, $select_products );
      $products_numbers = mysqli_num_rows( $products);
      if($products_numbers > 0){
         while($fetch_products = mysqli_fetch_assoc($products)){
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name= "user_id" value="<?= $fetch_products['user_id']; ?>"> 
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="quantity" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>

   <?php
         }
      }else{
         echo '<p class="empty">no products available!</p>';
      }
   ?>

</div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>