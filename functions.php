<?php 
include_once 'database/conn.php';
session_start();

$conn = connect();
$user = "";
$errors   = array(); 

if (isset($_POST['register_btn'])) {
        register();
}

if (isset($_POST['login_btn'])) {
        login();
}

function register(){
        // call these variables with the global keyword to make them available in function
        global $conn, $errors, $user;

        $user    =  e($_POST['user']);
        $password  =  e($_POST['password']);
        
        if (empty($user)) { 
                array_push($errors, "user is required"); 
        }
        elseif (empty($password)) { 
                array_push($errors, "Password is required"); 
        }

        // register user if there are no errors in the form
        if (count($errors) == 0) {
                $password = md5($password);

                if (isset($_POST['user_type'])) {
                        $user_type = e($_POST['user_type']);
                        $query = "INSERT INTO customers (user, user_type, password) 
                                          VALUES('$user', '$user_type', '$password')";
                        mysqli_query($conn, $query);
                        $_SESSION['success']  = "New user successfully created!!";
                        header('location: login.php');
                }else{
                        $query = "INSERT INTO customers (user, user_type, password) 
                                          VALUES('$user', 'user', '$password')";
                        mysqli_query($conn, $query);

                        // get id of the created user
                        $logged_in_user_id = mysqli_insert_id($conn);

                        $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
                        $_SESSION['success']  = "You are now logged in";
                        header('location: login.php');                          
                }
        }
}

function login(){
        global $conn, $user, $errors;

        // grap form values
        $user = e($_POST['user']);
        $password = e($_POST['password']);

        //VERIFY
        if (empty($user)) {
                array_push($errors, "user is required");
        }
        if (empty($password)) {
                array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
                $password = md5($password);

                $query = "SELECT * FROM customers WHERE user='$user' AND password='$password' LIMIT 1";
                $results = mysqli_query($conn, $query);

                if (mysqli_num_rows($results) == 1) { 
                        //ADMIN LOGIN
                        $logged_in_user = mysqli_fetch_assoc($results);
                        if ($logged_in_user['user_type'] == 'admin') {

                                $_SESSION['user'] = $logged_in_user;
                                $_SESSION['success']  = "You are now logged in";
                                header('location: views/admin/index.php');               
                        }else{
                                //CUSTOMER LOGIN
                                $_SESSION['user'] = $logged_in_user;
                                $_SESSION['success']  = "You are now logged in";

                                header('location: views/customer/index.php');
                        }
                }else {
                        array_push($errors, "Wrong user/password combination");
                }
        }
}

function getUserById($id){
        global $conn;
        $query = "SELECT * FROM customers WHERE id=" . $id;
        $result = mysqli_query($conn, $query);

        $user = mysqli_fetch_assoc($result);
        return $user;
}

function e($val){
        global $conn;
        return mysqli_real_escape_string($conn, trim($val));
}

function display_error() {
        global $errors;

        if (count($errors) > 0){
                echo '<div class="error">';
                        foreach ($errors as $error){
                                echo $error .'<br>';
                        }
                echo '</div>';
        }
}       


