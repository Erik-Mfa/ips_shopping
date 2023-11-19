<?php
include_once '../../database/conn.php';

function isAdmin(){
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
            return true;
    }else{
            return false;
    }
}

if (isset($_SESSION['user']['id'])) {
    $customerId = $_SESSION['user']['id'];
    
    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];

        orderProduct($productId, $customerId);
    }

    echo '<script>
        function orderProduct(productId) {
            window.location.href = "index.php?product_id=" + productId;
        }
    </script>';
} else {
    echo 'Error: User ID not specified.';
}

if (isset($_POST['saveUser'])) {
  $userId = isset($_POST['userId']) ? $_POST['userId'] : null;
  $user = $_POST['user'];
  $userType = $_POST['userType'];
  $password = $_POST['password'];

  saveUser($userId, $user, $userType, $password);
} 

if (isset($_POST['addProduct'])) {
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $vendor = $_POST['vendor'];
  
    addProduct($productName, $price, $category, $vendor);
  } 

if (isset($_POST['addShop'])) {
    $adress = $_POST['adress'];
    $name = $_POST['name'];

    addShop($adress, $name);
}

if (isset($_POST['addVendor'])) {
    $vendor = $_POST['manufacturer'];

    addVendor($vendor);
}

function getProducts() {
    $conn = connect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

$sql = "SELECT products.id, products.name, products.price, products.category, vendors.manufacturer_name
            FROM products
            JOIN vendors ON products.vendors_id = vendors.id";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product">';
        echo '<p>ID: ' . $row['id'] . '</p>';
        echo '<p>Name: ' . $row['name'] . '</p>';
        echo '<p>Price: $' . $row['price'] . '</p>';
        echo '<p>Category: ' . $row['category'] . '</p>';
        echo '<p>Vendor: ' . $row['manufacturer_name'] . '</p>';
        echo '<button class="order-btn" onclick="orderProduct(' . $row['id'] . ')">Order</button>';
        echo '<div style="margin-top: 20px; display: flex; justify-content: center">';
            echo '<form method="post">';
            echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="delete_product" style="background-color: red;">Delete Product</button>';
            echo '</form>';
        echo '</div>';
        // Add order butto
        echo '</div>';
    }

    mysqli_close($conn);
}

function deleteProduct($productId) {
    $conn = connect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM products WHERE id = $productId";

    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

// Assuming you have an HTML button to trigger the delete action
if (isset($_POST['delete_product'])) {
    $productIdToDelete = $_POST['product_id']; // Assuming you have a form field with the product id
    deleteProduct($productIdToDelete);
}

function orderProduct($productId, $customerId) {
    $conn = connect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO orders (customers_id, products_id) VALUES ($customerId, $productId)";

    if (mysqli_query($conn, $sql)) {
        echo 'Order created successfully!';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
}


function saveUser($userId, $user, $userType, $password) {
  $conn = connect();

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $hashedPassword = md5($password);

  if ($userId) {
      $sql = "UPDATE customers SET user = '$user', user_type = '$userType', password = '$hashedPassword' 
              WHERE id = $userId";
  } else {
      $sql = "INSERT INTO customers (user, user_type, password, address, phone) 
              VALUES ('$user', '$userType', '$hashedPassword')";
  }

  if (mysqli_query($conn, $sql)) {
      echo 'User saved successfully! <br>';
  } else {
      echo 'Error: ' . mysqli_error($conn);
  }
  mysqli_close($conn);
}

function addShop($adress, $name) {
    $conn = connect();
  
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  
    if ($adress) {
        $sql = "INSERT INTO shops (adress, name) 
                VALUES ('$adress', '$name')";
    } 
  
    if (mysqli_query($conn, $sql)) {
        echo 'Shop added! <br>';
        header('location: index.php');  
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
  }

function addProduct($productName, $price, $category, $vendor) {
    $conn = connect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($productName) {
        $sql = "INSERT INTO products (name, price, category, vendors_id) 
                VALUES ('$productName', '$price', '$category', '$vendor')";
    } 

    if (mysqli_query($conn, $sql)) {
        echo 'Product added! <br>';
        header('location: index.php');  
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
}

function addVendor($vendor) {
    $conn = connect();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($vendor) {
        $sql = "INSERT INTO vendors (manufacturer_name) 
                VALUES ('$vendor')";
    } 

    if (mysqli_query($conn, $sql)) {
        echo 'Vendor added! <br>';
        header('location: index.php');  
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
}

?>