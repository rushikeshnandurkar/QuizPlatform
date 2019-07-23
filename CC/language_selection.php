<?php
    session_start();
    include 'DB_connection.php';
    $query_string = "SELECT DISTINCT language FROM questions";
    $result = $conn->query($query_string);
    $arr_of_langauges = $result->fetch_all(MYSQLI_ASSOC);
    $no_of_rows = count($arr_of_langauges);

    $logged_in_user = $_SESSION["logged_in_user"];
    $query_string = "SELECT * FROM members WHERE member_id = $logged_in_user";
    $result = $conn->query($query_string);
    $scores = $result->fetch_all(MYSQLI_ASSOC);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <title>Language</title>
   <link rel="shortcut icon" href="Logo.png" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <style>
 body {
   font-family: Arial, Helvetica, sans-serif;
   background-color: #ddd;
 }

 .navbar {

   height:80px;
   background-color: #333;
 }

 .navbar a {
   float: left;
   font-size: 16px;
   color: white;
   line-height: 60px;
   text-align: center;
   padding: 14px 16px;
   text-decoration: none;
 }

 h5{
   color: white;
   float:left;
   font-size: 16px;
   text-align: center;
   padding: 14px 16px;
   line-height: 40px;

 }
 .navbar_content{
   float:right;

 }




 .box{
   width:60%;
   padding-left: 40px;
   margin-left: 20%;
   margin-top: 90px;
 }

 .project{
    background-color: #ddd;
    width:60%;
    float: left;
    padding:20px;
 }
 .pro_img{
   float:left;
   width:10%;
 }

 .questions{
   margin-left: 60px;
 }
 .content{
   width:60%;
   margin-left:auto;
   margin-right: auto;
   padding:90px;
   background-color: #ffffff;
 }


 input {
   background-image: none;
   border: 0;
   color: inherit;
   font: inherit;
   margin: 0;
   outline: 0;
   padding: 0;
   transition: background-color 0.3s;
 }

 .login input[type='submit']:focus,
 .login input[type='submit']:hover {
   background-color: var(--loginSubmitHoverBackgroundColor);
 }

 input[type='submit']{
   float:right;
   width: 70px;
   height:30px;
 }
 button{
   background-color: white;
 }





   button{
     border:none;
     border-bottom: 2px solid #A9A9A9;
     outline :none;
     height:30px;
     }

 </style>
 </head>
 <body>

 <div class="navbar">
   <div class="logo">
         <a style="border-right:white 1px solid">CODE CLUB</a>
         <a style="margin-left:20px">Member ID: <?php echo "$logged_in_user"; ?></a>
         <a style="margin-left:20px"> <?php echo "".$scores[0]['first_name']." ".$scores[0]['last_name']; ?></a>
   </div>
   <div class="navbar_content">
   <a>Weekly Score:<?php echo $scores[0]['week_score']; ?></a>
   <a style="margin-right: 60px">Total Score:<?php echo $scores[0]['total_score']; ?></a>
   <a href="logout_code_club.php" style="background-color: white;color:black ">Logout</a>

 </div>
 </div>

 <div class="content">
   <form  action="topic_selection.php" method="post">
   <div class="questions">

       <br>
       <a><h4>Select a language you want to give quiz for:</h4></a>
       <?php
          for ($i=0; $i < $no_of_rows; $i++) {
              echo '<input type="radio" name="language-opted" value="'.$arr_of_langauges[$i]['language'].'"> '.$arr_of_langauges[$i]['language'].'<br><br>';
          }
        ?>

   </div>
     <br>
     <br>


     <input type="submit" style="background-color: #1BA94C;color:white;"value="NEXT" >
   </form>
 </div>



 </body>
 </html>
