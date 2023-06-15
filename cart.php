<?php
$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

$user_id = $_SESSION['user_id'];

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_cart_item = "DELETE FROM `cart` WHERE id = '$delete_id'";
   $delete_cart= mysqli_query($conn, $delete_cart_item);
   header('location:wishlist.php');

}

if(isset($_GET['delete_all'])){

   $delete_cart_item = "DELETE FROM `cart` WHERE user_id = '$user_id'";
   $delete_wishlist= mysqli_query($conn, $delete_cart_item);
   header('location:wishlist.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $quantity = $_POST['quantity'];
   $update_qty = "UPDATE `cart` SET quantity = '$quantity' WHERE id = '$cart_id'";
   $update_quantity= mysqli_query($conn, $update_qty );
   $message[] = 'cart quantity updated';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">
   <?php
      $grand_total = 0;
      $select_cart = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
      $cart = mysqli_query($conn ,$select_cart );
      $select_cart_number = mysqli_num_rows($cart );
      if( $select_cart_number > 0){
         while($fetch_cart = mysqli_fetch_assoc($cart)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="view_page.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">$<?= $fetch_cart['price']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <div class="flex-btn">
      <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="quantity">
      <input type="submit" value="update" name="update_qty" class="option-btn">
      </div>
      <div class="sub-total"> sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
   </form>
   <?php
      $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
</div>

   <div class="cart-total">
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>