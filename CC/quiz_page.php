<?php
    session_start();
    include 'DB_connection.php';
    $topic_selected = $_POST["topic-opted"];
    $language_selected = $_POST["language-opted"];

    $query_string = "SELECT * FROM questions WHERE language = '$language_selected' AND topic = '$topic_selected'";
    $result = $conn->query($query_string);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $no_of_rows = count($rows);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <title>Quiz- Code Club</title>
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

 .navbar_content{
   float:right;
   margin-right: 50%;

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

 button{
   background-color: white;
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
   margin-left: 45%;
   width: 70px;
   height:30px;
 }




   button{
     border:none;
     border-bottom: 2px solid #A9A9A9;
     outline :none;
     height:30px;
     }

    .invisible-button{
        display: none;
    }

    pre{
        font-family: sans-serif;
    }

 </style>
 </head>
 <body>

 <div class="navbar">
   <div class="logo">
         <a>CODE CLUB</a>

   </div>
   <div class="navbar_content">

       <a><?php echo "".$language_selected." - ".$topic_selected; ?></a>
 </div>
 </div>

 <div class="content">
     <form action="result_page_code_club.php" method="post">
         <?php
            for ($i=0; $i < $no_of_rows; $i++) {
                $q_id = $rows[$i]["que_id"];
                echo '<div class="questions">
                  <pre><a>'.$rows[$i]["question"].'</a></pre>
                  <input  class="invisible-button" type="radio" name="'.$q_id.'" value="-1" CHECKED><br>
                  <input type="radio" name="'.$q_id.'" value="1">. '.$rows[$i]["choice_1"].'<br>
                  <input type="radio" name="'.$q_id.'" value="2">. '.$rows[$i]["choice_2"].'<br>
                  <input type="radio" name="'.$q_id.'" value="3">. '.$rows[$i]["choice_3"].'<br>
                  <input type="radio" name="'.$q_id.'" value="4">. '.$rows[$i]["choice_4"].'<br><br><hr><br>
               </div>';
            }
          ?>

          <input class="invisible-button" type="radio" name="lang" value="<?php echo "$language_selected"; ?>" checked>
          <input class="invisible-button" type="radio" name="topicc" value="<?php echo "$topic_selected"; ?>" checked>

         <input type="submit" style="background-color: #1BA94C;color:white;"value="SUBMIT" >
    </form>
 </div>

 </body>
 </html>
