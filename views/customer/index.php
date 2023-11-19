<?php
include_once '../../functions.php';
include_once '../../database/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Main Page</title>
<link rel="stylesheet" href="./styles.css">
</head>

<body>
<div class="navbar">
    <p>Welcome to <br> IPS Online Shopping!</p>
    <?php echo $customerId = $_SESSION['user']['user']; ?> <br><br>
    <a href="../../login.php?logout=true">Logout</a>
</div>

<div class="product-container">
    <?php

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

    getProducts();
    ?>
</div>


<?php
// Function to handle product ordering
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
    
    // Check if the 'product_id' parameter is set in the URL
    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];

        orderProduct($productId, $customerId);
    }

    // Your existing HTML and JavaScript code...

    // JavaScript function to handle product ordering
    echo '<script>
        function orderProduct(productId) {
            window.location.href = "index.php?product_id=" + productId;
        }
    </script>';
} else {
    
    echo 'Error: User ID not specified.';
}
?>

</body>
</html>