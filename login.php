<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <?php 
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['user']);
      }
    ?>
</head>
<body>

<div>
    <h1>Login</h1>
    <form method="post" action="login.php">
    <?php echo display_error(); ?>

        <div class="input-container">
            <label for="user" class="placeholder">User</label>
            <input type="text" name="user">
        </div>

        <div class="input-container">
            <label for="password" class="placeholder">Password</label>
            <input type="text" name="password">
        </div>

        <div class="input-container">
            <button type="submit" name="login_btn" class="submit">Login</button>
        </div>
    </form>
    <a href="./register.php">Don't have an account? <br> Create one </a>    
</div>


</body>



</html>