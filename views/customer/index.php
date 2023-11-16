<?php
include_once '../../functions.php';
include_once '../../database/conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../styles.css">
<title>Main Page</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .navbar {
            background-color: #333;
            padding: 10px;
            text-align: center;
            color: #fff;
        }

    .product-container {
        width: 80%;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .product {
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    p {
        margin: 0;
        padding: 5px 0;
    }
    .order-btn {
        top: 10px;
        right: 10px;
        background-color: green;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

</style>
</head>

<body>
<div class="navbar">
    <p>Welcome to <br> IPS Online Shopping!</p>
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


</body>
</html>