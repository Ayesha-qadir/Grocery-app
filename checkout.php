<?php
$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['order'])){

$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$method = $_POST['method'];
$address = 'flat no. '. $_POST['House'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['province'] .' '. $_POST['country'] .' - '. $_POST['pin_code'];
$placed_on = date('d-M-Y');

$cart_total = 0;
$cart_products[] = '';

$cart_query = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
   $query= mysqli_query($conn, $cart_query);
   $cart_query_number = mysqli_num_rows( $query);
   if($cart_query_number > 0){
      while($cart_item = mysqli_fetch_assoc($query)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query ="SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = ' $address' AND total_products = '$total_products' AND total_price = '$cart_total'";
   $order = mysqli_query($conn, $order_query);
   $order_query_number = mysqli_num_rows( $order);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query_number > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id',' $name','$number','$email','$method','$address','$total_products',' $cart_total','$placed_on')";
      $insert = mysqli_query($conn, $insert_order);
      $delete_cart = "DELETE FROM `cart` WHERE user_id = '$user_id'";
      $delete = mysqli_query($conn, $delete_cart);
      $message[] = 'order placed successfully!';
   }
}?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
      $select_cart= mysqli_query($conn, $select_cart_items);
      $select_cart_number = mysqli_num_rows($select_cart);
      if($select_cart_number  > 0){
         while($fetch_cart_items = mysqli_fetch_assoc($select_cart)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">grand total : <span>$<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" required>
            <input type="hidden" name= "user_id" value="<?= $fetch_products['user_id']; ?>">
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="House" placeholder="e.g. House no" class="box" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. faisalabad" class="box" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="province" placeholder="e.g. punjab" class="box" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Pakistan" class="box" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>