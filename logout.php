<?php

$conn = mysqli_connect("localhost", "root", "", "shop_db");

session_start();
session_unset();
session_destroy();

header('location:login.php');

?>