<?php
include_once '../../functions.php';
include_once '../../database/conn.php';

$conn = connect();

function isAdmin()
{
        if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
                return true;
        }else{
                return false;
        }
}

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
    <title>Main Page</title>
</head>
<body>
  
<?php echo display_error(); ?>
    
<div>
    <nav>
        <h1>Bem vindo a Ips Shopping Online!</h1>
    </nav>
</div>



</body>
</html>