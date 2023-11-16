<?php
include_once '../../functions.php';
include_once 'adminFunctions.php';

if (!isAdmin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: ../../login.php');
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("location: ../../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Page</title>
<link rel="stylesheet" href="./styles.css">
</head>
<body>
<div class="navbar">
    <p>Welcome to <br> IPS Online Shopping!</p>
</div>

<div class="product-container">
  <?php getProducts(); ?>
</div>

<div class="admin-container">
    <h2>Admin Panel</h2>
    <!-- Form for adding/editing users -->
    <form action="adminFunctions.php" method="post">
        <label for="userId">User ID (for editing only):</label>
        <input type="text" id="userId" name="userId">

        <label for="user">Username:</label>
        <input type="text" id="user" name="user" required>

        <label for="userType">User Type:</label>
        <input type="text" id="userType" name="userType" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="saveUser">Save User</button>
    </form>

    <form action="adminFunctions.php" method="post">
        <label for="adress">Adress:</label>
        <input type="text" id="adress" name="adress" required>  

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <button type="submit" name="addShop">Add Shop</button>
    </form>

</body>
</html>