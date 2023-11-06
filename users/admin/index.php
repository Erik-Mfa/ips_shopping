<?php
session_start();
include_once './database/conn.php';

$conn = connect();

$user = $_POST['user'];

if (!empty($_POST) && empty($_POST['user'])) {
    header("Location: ./login.php"); exit;
}

$sql = "SELECT id, name, adress, phone, level
        FROM customers
        WHERE (name = '".$user ."') LIMIT 1";

$query = mysqli_query($conn, $sql);

  if (mysqli_num_rows($query) != 1) {
    header("Location: ./login.php"); exit;
  } else {
        $resultado = mysqli_fetch_assoc($query);

        $_SESSION['userName'] = $resultado['name'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    
<div>
    <nav>
    <h1>Bem vindo a Ips Shopping Online!</h1>
    </nav>
</div>



</body>
</html>