<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

if(isset($_POST['update_product'])){

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $details = $_POST['details'];
  
 
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded/'.$image;
    $old_image = $_POST['old_image'];
 
    $update_product = "UPDATE `products` SET name = '$name', category = '$category', details = '$details', price = '$price' WHERE id = '$pid'";
    $update_product_query = mysqli_query($conn, $update_product);
 
    $message[] = 'product updated successfully!';
 
    if(!empty($image)){
       if($image_size > 2000000){
          $message[] = 'image size is too large!';
       }else{
 
          $update_image = "UPDATE `products` SET image = '$image' WHERE id = '$pid'";
          $update_image_query = mysqli_query($conn, $update_image);
 
          if($update_image){
             move_uploaded_file($image_tmp_name, $image_folder);
             unlink('uploaded/'.$old_image);
             $message[] = 'image updated successfully!';
          }
       }
    }
 
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-product">

   <h1 class="title">update product</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_products = "SELECT * FROM `products` WHERE id = '$update_id'";
      $select_products_query =mysqli_query($conn, $select_products);
      $select_products_number = mysqli_num_rows($select_products_query);
      if($select_products_number > 0){
         while($fetch_products = mysqli_fetch_assoc( $select_products_query)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <img src="uploaded/<?= $fetch_products['image']; ?>" alt="">
      <input type="text" name="name" placeholder="enter product name" required class="box" value="<?= $fetch_products['name']; ?>">
      <input type="number" name="price" min="0" placeholder="enter product price" required class="box" value="<?= $fetch_products['price']; ?>">
      <select name="category" class="box" required>
         <option selected><?= $fetch_products['category']; ?></option>
         <option value="vegitables">vegitables</option>
         <option value="fruits">fruits</option>
         <option value="meat">meat</option>
         <option value="fish">fish</option>
      </select>
      <textarea name="details" required placeholder="enter product details" class="box" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <div class="flex-btn">
         <input type="submit" class="btn" value="update product" name="update_product">
         <a href="admin_products.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   ?>

</section>






<script src="js/script.js"></script>

</body>
</html>