<?php
  // game_view.php - shows details of a single game

  // INCLUDE CONFIG AND HEADER FILE
  include 'inc/config.php';
  include 'inc/header.php';

  // IF ID IS SET
  if(isset($_GET['id'])){
    //STORE ID IN VAR, CAST AS AN INTEGER (SECURE)
    $id = (int)$_GET['id'];

  // IF ID IS NOT SET
  } else {
    // SEND USER BACK TO LIST PAGE
    header('Location:game_list.php');
}

  // SQL QUERY
  $sql = "SELECT * FROM games WHERE GameID = $id";

  // DATABASE CONNECTION
  $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // STORE RESULTS IN VAR
  $result = mysqli_query($iConn, $sql);

  // IF ANY RECORDS EXIST...
  if(mysqli_num_rows($result) > 0) {
    // WHILE RECORDS EXIST...
    while($row = mysqli_fetch_assoc($result)) {
        // STORE DATA AS THESE VARS
        $GameName = stripslashes($row['Name']);
        $MinPlayers = stripslashes($row['Min_Players']);
        $MaxPlayers = stripslashes($row['Max_Players']);
        $AvgGameTime = stripslashes($row['Average_Game_Time']);
        $Type = stripslashes($row['Type']);
        $Genre = stripslashes($row['Genre']);
        $MinAge = stripslashes($row['Min_Age']);
        $pageID = $GameName;

        // SET FEEDBACK VAR TO EMPTY STRING B/C NO FEEDBACK NEEDED
        $Feedback = '';
    } // END WHILE

  // IF NO RECORDS...
} else {
    // SET FEEDBACK VAR TO SHOW NO RESULTS EXIST
    $Feedback = '<p>This game does not exist</p>';
}


?>

<!-- SHOW PAGE ID AS H1 -->
<h1><?=$pageID?></h1>

<?php

  // IF FEEDBACK SET TO EMPTY STRING (SUCCESSFUL DB CNXN)...
  if($Feedback == '') {
    // SHOW RESULTS IN THIS FORMAT
    echo '<img src="uploads/game' . $id . '.jpg" />';
    echo '<p>';
    echo '<b>Minimum Players:</b> ' . $MinPlayers . '<br /> ';
    echo '<b>Maximum Players:</b> ' . $MaxPlayers . '<br /> ';
    echo '<b>Average Game Time:</b> ' . $AvgGameTime . ' minutes<br /> ';
    echo '<b>Game Type:</b> ' . $Type . '<br />';
    echo '<b>Genre:</b> ' . $Genre . '<br />';
    echo '<b>Minimum Age:</b> ' . $MinAge;
    echo '</p>';

  // IF FEEDBACK NOT EMPTY STRING (UNSUCCESSFUL DB CNXN)...
  } else {
    // DISPLAY FEEDBACK VAR
    echo $Feedback;
  }

  // ADD LINK TO GO BACK TO LIST PAGE
  echo '<p><a href="game_list.php">Go Back</a></p>';

  // RELEASE RESULT VAR
  @mysqli_free_result($result);

  // CLOSE CONNECTION
  @mysqli_close($iConn);

  // INCLUDE FOOTER FILE
  include 'inc/footer.php';

  ?>
