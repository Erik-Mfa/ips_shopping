<?php
include_once '../../database/conn.php';

function isAdmin(){
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
            return true;
    }else{
            return false;
    }
}

function getProducts() {
      $conn = connect();

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT id, name, price, category FROM products";

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
          echo '<button class="order-btn" onclick="orderProduct(' . $row['id'] . ')">Order</button>';
          echo '</div>';
      }

      mysqli_close($conn);
  }

// Check if the form data is submitted
if (isset($_POST['saveUser'])) {
  $userId = isset($_POST['userId']) ? $_POST['userId'] : null;
  $user = $_POST['user'];
  $userType = $_POST['userType'];
  $password = $_POST['password'];

  saveUser($userId, $user, $userType, $password);
} 

if (isset($_POST['addShop'])) {
    $adress = $_POST['adress'];
    $name = $_POST['name'];

    addShop($adress, $name);
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

?>