<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $details = $_POST['details'];

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded/'.$image;

    $select_products = "SELECT * FROM `products` WHERE name = '$name'";
    $products= mysqli_query($conn, $select_products );
     $count_products= mysqli_num_rows( $products);
    if( $count_products > 0){
       $message[] = 'product name already exist!';
    }

    else{

        $insert_products = "INSERT INTO `products`(name, category, details, price, image) VALUES('$name','$category','$details','$price','$image')";
        $insert = mysqli_query($conn, $insert_products );

        if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'new product added!';
            }
   
         }
} 
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = "SELECT image FROM `products` WHERE id = '$delete_id'";
    $select_delete= mysqli_query($conn,  $select_delete_image )  or die('Query Failed');;
    $fetch_delete_image = mysqli_fetch_assoc($select_delete);
    unlink('uploaded/'.$fetch_delete_image['image']);
    $delete_products = "DELETE FROM `products` WHERE id = '$delete_id'";
    $deleted_products= mysqli_query($conn,  $delete_products)  or die('Query Failed');;
    $delete_wishlist = "DELETE FROM `wishlist` WHERE pid = '$delete_id'";
    $deleted_wishlist= mysqli_query($conn, $delete_wishlist);
    $delete_cart = "DELETE FROM `cart` WHERE pid = '$delete_id'";
    $deleted_cart= mysqli_query($conn, $delete_cart);
    header('location:admin_products.php');
 
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/compnents.css">
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="title">add new product</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="enter product name">
         <select name="category" class="box" required>
            <option value="" selected disabled>select category</option>
               <option value="vegitables">vegitables</option>
               <option value="fruits">fruits</option>
               <option value="meat">meat</option>
               <option value="fish">fish</option>
         </select>
         </div>
         <div class="inputBox">
         <input type="number" min="0" name="price" class="box" required placeholder="enter product price">
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="add product" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="title">products added</h1>

   <div class="box-container">

   <?php
      $show_products = "SELECT * FROM `products`";
      $show= mysqli_query($conn,   $show_products );
     $count= mysqli_num_rows($show);
      if( $count > 0){
         while($fetch_products = mysqli_fetch_assoc( $show)){  
   ?>
   <div class="box">
      <div class="price">$<?= $fetch_products['price']; ?>/-</div>
      <img src="uploaded/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="cat"><?= $fetch_products['category']; ?></div>
      <div class="details"><?= $fetch_products['details']; ?></div>
      <div class="flex-btn">
         <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">now products added yet!</p>';
   }
   ?>

   </div>

</section>











<script src="js/script.js"></script>

</body>
</html>