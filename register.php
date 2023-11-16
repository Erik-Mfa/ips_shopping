<?php 
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
<title>Register</title>
</head>
<body>

<div>
    <h1>Register new user</h1>
    <form action="./register.php" method="post">
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
            <input type="submit" value="Register" class="submit" name="register_btn">
        </div>
    </form>
</div>
</body>
</html>