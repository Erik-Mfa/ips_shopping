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
    <?php echo $customerId = $_SESSION['user']['user']; ?> <br><br>
    <a href="../../login.php?logout=true">Logout</a>
</div>

<div class="admin-container">
    <form action="adminFunctions.php" method="post">
      <h1>Add Products</h1>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName">

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <label for="vendor">Vendor:</label>
        <input type="number" id="vendor" name="vendor">

        <button type="submit" name="addProduct">Save Product</button>
    </form>
</div>

<div class="product-container">
    <?php getProducts(); ?>
</div>

<div class="admin-container">
    <h2>Admin Panel</h2>
    <!-- Form for adding/editing users -->
    <form action="adminFunctions.php" method="post">
      <h1>User Managment</h1>
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

    <div style="display: flex;">

      <div style="flex: 1; width: 50%; margin-right: 5px">
        <form action="adminFunctions.php" method="post" >
        <h1>Add Shop</h1>
            <label for="adress">Adress:</label>
            <input type="text" id="adress" name="adress" required>  

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <button type="submit" name="addShop">Add Shop</button>
        </form>
      </div>

      <div style="flex: 1; width: 50%; margin-left: 5px">
        <form action="adminFunctions.php" method="post">
        <h1>Add Vendor</h1>
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" id="manufacturer" name="manufacturer" required>  

            <button type="submit" name="addVendor">Add Vendor</button>
        </form>
      </div>

    </div>

</body>
</html>