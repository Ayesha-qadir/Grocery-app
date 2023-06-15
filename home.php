<?php


$conn = mysqli_connect("localhost", "root", "", "shop_db");
session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['add_to_wishlist'])){
  
   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_POST['image'];

   $check_wishlist_numbers = "SELECT * FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'";
   $wishlist_result = mysqli_query($conn, $check_wishlist_numbers);
   $count_wishlist = mysqli_num_rows($wishlist_result);   

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
   <title>home</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>
<body>

<?php include 'components/user_header.php'; ?> 
<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>don't panic, go organice</span>
         <h3>Reach For A Healthier You With Organic Foods</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus culpa officia quasi, accusantium explicabo?</p>
         <a href="about.php" class="btn">about us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fruits</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fruits" class="btn">fruits</a>
      </div>

      <div class="box">
         <img src="images/cat-2.png" alt="">
         <h3>meat</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=meat" class="btn">meat</a>
      </div>

      <div class="box">
         <img src="images/cat-3.png" alt="">
         <h3>vegitables</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=vegitables" class="btn">vegitables</a>
      </div>

      <div class="box">
         <img src="images/cat-4.png" alt="">
         <h3>fish</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fish" class="btn">fish</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
       $sql = "SELECT * FROM `products` LIMIT 6";

       $result = mysqli_query($conn, $sql);
       $count = mysqli_num_rows($result);
   
       if($count > 0) {
         while ($row = mysqli_fetch_assoc($result))  {
    
      ?> 
      
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $row['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $row['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded/<?= $row['image']; ?>" alt="">
      <div class="name"><?= $row['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $row['id']; ?>">
      <input type="hidden" name="name" value="<?= $row['name']; ?>">
      <input type="hidden" name="price" value="<?= $row['price']; ?>">
      <input type="hidden" name="image" value="<?= $row['image']; ?>">
      <input type="number" min="1" value="1" name="quantity" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>