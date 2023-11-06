<?php  
    include_once 'config.php';

    function connect()
    {
        return mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
    }
?>