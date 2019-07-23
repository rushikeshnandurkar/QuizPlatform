<?php
    session_start();
    include 'DB_connection.php';
    if(isset($_POST["username"])){
        $login_username = $_POST["username"];
        $login_password = $_POST["password"];

        $query_string = "SELECT member_id FROM members WHERE email = '$login_username' AND password = '$login_password' LIMIT 1";
        $result = $conn->query($query_string);

        if ($result->num_rows == 1) {
            $query_string = "SELECT * FROM Members WHERE email = '$login_username' AND password = '$login_password' LIMIT 1";
            $result = $conn->query($query_string);
            if ($result == TRUE) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $login_username = $row[0]['member_id'];
                session_start();
                $_SESSION["logged_in_user"] = $login_username;
                header("location: language_selection.php");
            }
        } else {
            $error_message = "Invalid Credentials.. Login Failed";
            header('Location:index.php');
        }
    }
 ?>
