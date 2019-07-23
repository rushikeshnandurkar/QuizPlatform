<?php
    include 'db_names.php';
    $conn = mysqli_connect($servername, $mysql_username, $mysql_password, $mysql_db_name);

    if ($conn->connect_error) {
        die("Connecton Failed: " . $conn->connect_eror);
    }

 ?>
 
