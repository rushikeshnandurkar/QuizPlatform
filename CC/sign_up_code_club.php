<?php
    session_start();
    include 'DB_connection.php';

    if(isset($_POST['first_name'])){
        $new_password = $_POST["password"];  // verify post name::::::
        $new_firstname = $_POST["first_name"];   // verify this also::::::
        $new_lastname = $_POST["last_name"]; // also this:::::::
        $new_year = $_POST["year"];  // this too::::::::
        $new_email = $_POST["email"];
        $new_total_score = 0;
        $new_week_score = 0;
        $error_existing = "";

        //echo "$new_password $new_firstname $new_lastname $new_year";

        // checking id first and last naems already exist

        $query_string = "SELECT first_name, last_name FROM Members WHERE first_name = '$new_firstname' and last_name = '$new_lastname'";
        $result = $conn->query($query_string);
        $row_cnt = $result->num_rows;
        if ($row_cnt > 0) {
            $error_existing = "User Already Exists";
            header("location: abc.htm");
        } else {
            // preparing a query to insert data in db
            $query_string = "INSERT INTO members (first_name, last_name, year, total_score, week_score, email, password)
            VALUES('$new_firstname', '$new_lastname', '$new_year', $new_total_score, $new_week_score, '$new_email', '$new_password')";

            if ($conn->query($query_string) == TRUE) {
                $query_string = "SELECT * FROM Members WHERE first_name = '$new_firstname' AND last_name = '$new_lastname' LIMIT 1";
                $result = $conn->query($query_string);
                if ($result == TRUE) {
                    $row = $result->fetch_all(MYSQLI_ASSOC);
                    $login_username = $row[0]['member_id'];
                    //echo $login_username;
                    $url_to_land = "language_selection.php";
                    $_SESSION["logged_in_user"] = $login_username;
                    header("Location: $url_to_land");
                }else {
                    echo "Something Went Wrong";
                }
            } else {
                echo("Somethng Went Wrong.. Try agian later.");
                echo $conn->error;
            }
        }


    }
 ?>
