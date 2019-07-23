<?php
    session_start();
    include 'DB_connection.php';
    $language_selected = $_POST["lang"];
    $topic_selected = $_POST["topicc"];
    $query_string = "SELECT * FROM questions WHERE language = '$language_selected' AND topic = '$topic_selected'";
    $result = $conn->query($query_string);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $no_of_rows = count($rows);

    $logged_in_user = $_SESSION["logged_in_user"];
    $query_string = "SELECT * FROM members WHERE member_id = $logged_in_user";
    $result = $conn->query($query_string);
    $user_info = $result->fetch_all(MYSQLI_ASSOC);
    $updated_total_score = $user_info[0]["total_score"];
    $updated_week_score = $user_info[0]["week_score"];

    $query_string = "SELECT * FROM score_board WHERE member_id = $logged_in_user AND language = '$language_selected' AND topic = '$topic_selected'";
    $result = $conn->query($query_string);
    if($result == TRUE){
        $from_score_board = $result->fetch_all(MYSQLI_ASSOC);
    }

    $this_quiz_score = 0;
    $this_quiz_total_score = 0;
    $number_of_correct_questions = 0;
    $que_attempted = 0;

    for ($i=0; $i < $no_of_rows; $i++) {
        $qid = $rows[$i]["que_id"];
        $passed_ans = $_POST[$qid];
        $correct_option = $rows[$i]["correct_option"];
        $que_marks = $rows[$i]["que_score"];

        if ($passed_ans == $correct_option){
            $this_quiz_score += $que_marks;
            $number_of_correct_questions += 1;
        }

        $que_attempted += 1;

        if ($passed_ans == -1){
            $que_attempted -= 1;
        }

        $this_quiz_total_score += $que_marks;
    }

    if (count($from_score_board) == 0){
        $updated_total_score += $this_quiz_score;
        $updated_week_score += $this_quiz_score;

        $query_string = "UPDATE Members SET total_score = $updated_total_score, week_score = $updated_week_score
        WHERE member_id = $logged_in_user";
        if ($conn->query($query_string)){
            $query_string = "INSERT INTO score_board(member_id, language, topic, score)
            VALUES($logged_in_user, '$language_selected', '$topic_selected', $this_quiz_score) ";
            if($conn->query($query_string)){
                //echo "Added";
            }
        }
    }


 ?>

 <!DOCTYPE html>
<html>
<head>
  <title>Result !</title>
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

.questions,.table{
  margin-left: 60px;
}

.table{
  width:80%;
  background-color: #ddd;
  margin-bottom: 30px;
}

table,td,th{
  border:black 2px solid;
  border-collapse: collapse;

}

.table th,td{
  text-align: center;
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
  margin-left: 45%  ;
  width: 10 0px;
  height:30px;
}




  button{
    border:none;
    border-bottom: 2px solid #A9A9A9;
    outline :none;
    height:30px;
    }

    .correct-op {
        background-color: #b2eaf4;
        padding: 10px;
        width: 80%;
    }

</style>
</head>
<body>

<div class="navbar">
  <div class="logo">
        <a>CODE CLUB</a>
  </div>
  <div class="navbar_content">

      <a><?php echo "<b>Result: </b>".$language_selected." - ".$topic_selected; ?></a>
</div>
</div>

<div class="content">

  <div class="table">
     <table style="width:100%">
      <tr>
        <th>Total Questions</th>
        <th>Questions Attempted</th>
        <th>Total marks</th>
        <th>Obtained marks</th>
      </tr>
      <tr>
        <td><?php echo $no_of_rows; ?></td>
        <td><?php echo $que_attempted; ?></td>
        <td><?php echo $this_quiz_total_score; ?></td>
        <td><?php echo $this_quiz_score; ?></td>
      </tr>

    </table>
  </div>
  <form action="language_selection.php">
      <?php
        for ($i=0; $i < $no_of_rows; $i++) {
            $qid = $rows[$i]["que_id"];
            $passed_ans = $_POST[$qid];
            $correct_option = $rows[$i]["correct_option"];
            $que_marks = $rows[$i]["que_score"];

            if ($passed_ans == 1){
                echo '<div class="questions">
                <a>'.$rows[$i]["question"].'</a>
                <br>
                <input type="radio" value="" checked>1. '.$rows[$i]["choice_1"].'<br>
                <a>2. '.$rows[$i]["choice_2"].'</a><br>
                <a>3. '.$rows[$i]["choice_3"].'</a><br>
                <a>4. '.$rows[$i]["choice_4"].'</a><br>

                <br>

                <div class = "correct-op">
                <a>Correct Answer is Option <b>'.$correct_option.'</b></a>
                </div>
                </div>';
            } elseif ($passed_ans == 2) {
                echo '<div class="questions">
                <a>'.$rows[$i]["question"].'</a>
                <br>
                <a>1. '.$rows[$i]["choice_1"].'</a><br>
                <input type="radio" value="" style="background-color:#bdf4f9" checked>2. '.$rows[$i]["choice_2"].'<br>
                <a>3. '.$rows[$i]["choice_3"].'</a><br>
                <a>4. '.$rows[$i]["choice_4"].'</a><br>

                <br>
                <div class = "correct-op">
                <a>Correct Answer is Option <b>'.$correct_option.'</b></a>
                </div>
                </div>';
            } elseif ($passed_ans == 3) {
                echo '<div class="questions">
                <a>'.$rows[$i]["question"].'</a>
                <br>
                <a>1. '.$rows[$i]["choice_1"].'</a><br>
                <a>2. '.$rows[$i]["choice_2"].'</a><br>
                <input type="radio" value="" checked>3. '.$rows[$i]["choice_3"].'<br>
                <a>4. '.$rows[$i]["choice_4"].'</a><br>

                <br>

                <div class = "correct-op">
                <a>Correct Answer is Option <b>'.$correct_option.'</b></a>
                </div>
                </div>';
            } elseif ($passed_ans == 4) {
                echo '<div class="questions">
                <a>'.$rows[$i]["question"].'</a>
                <br>
                <a>1. '.$rows[$i]["choice_1"].'</a><br>
                <a>2. '.$rows[$i]["choice_2"].'</a><br>
                <a>3. '.$rows[$i]["choice_3"].'</a><br>
                <input type="radio" value="" checked>4. '.$rows[$i]["choice_4"].'<br>

                <br>

                <div class = "correct-op">
                <a>Correct Answer is Option <b>'.$correct_option.'</b></a>
                </div>
                </div>';
            }
            echo "<br><br><br><hr><br>";
        }
       ?>
     <input type="submit" style="background-color: #1BA94C;color:white;"value="Finish Test" >
  </form>

    <br>
    <br>
</div>

</body>
</html>
