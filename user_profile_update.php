<?php


$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

$name = $_POST['name'];
$email = $_POST['email'];

$update_profile ="UPDATE `users` SET name = '$name', email = '$email' WHERE id = '$user_id'";
$update_profile_query = mysqli_query($conn, $update_profile);

$image = $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded/'.$image;
$old_image = $_POST['old_image'];

if(!empty($image)){
   if($image_size > 2000000){
      $message[] = 'image size is too large!';
   }else{
      $update_image = "UPDATE `users` SET image = '$image' WHERE id = '$user_id'";
      $update_image_query = mysqli_query($conn, $update_image);
      if($update_image){
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('uploaded/'.$old_image) ;
         $message[] = 'image updated successfully!';
      };
   };
};

$old_pass = $_POST['old_pass'];
$update_pass = $_POST['update_pass'];
$new_pass = $_POST['new_pass'];
$confirm_pass = $_POST['confirm_pass'];


if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
   if($update_pass != $old_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $confirm_pass){
      $message[] = 'confirm password not matched!';
   }else{
      $update_pass ="UPDATE `users` SET password = '$confirm_pass' WHERE id = '$user_id'";
      $update_pass_query= mysqli_query($conn, $update_pass);
      $message[] = 'password updated successfully!';
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
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">
   <link rel="stylesheet" href="css/compnents.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<section class="update-profile">

   <h1 class="title">update profile</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="name"  placeholder="update username" required class="box">
            <span>email :</span>
            <input type="email" name="email"  placeholder="update email" required class="box">
            <span>update pic :</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update profile" name="update_profile">
         <a href="home.php" class="option-btn">go back</a>
      </div>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
