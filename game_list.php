<?php
  // game_list.php - shows a list of games

  // INCLUDE CONFIG AND HEADER FILES
  include 'inc/config.php';
  include 'inc/header.php';
?>

<!-- ECHO PAGE ID AS H1 -->
<h1><?=$pageID?></h1>

<?php

  $prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
  $next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

  // SQL QUERY
  $sql = "SELECT * FROM games";

  // DATABASE CONNECTION DETAILS
  $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // STORE QUERY
  //$result = mysqli_query($iConn, $sql);

/*
  // IF THERE ARE ANY RESULTS
  if(mysqli_num_rows($result) > 0) {

    // WHILE RESULTS EXIST...
    while($row = mysqli_fetch_assoc($result)) {

        $id = stripslashes($row['GameID']);
        // SHOW RESULTS IN THIS FORMAT

        echo '<div class="gameBox"><img src="uploads/game' . $id . '.jpg" alt="' . $id . '" class="game" /><p>';
        echo '<b>Game Title:</b> ' . $row['Name'] . '<br />';
        echo '<b>Game Type:</b> ' . $row['Type'] . '<br />';
        echo '<b>Genre:</b> ' . $row['Genre'] . '<br />';
        echo '<b>Minimum Age:</b> ' . $row['Min_Age'] . '<br />';
        echo '<a href="game_view.php?id=' . $row['GameID'] . '">Details</a>';
        echo '</p></div>';
    } // END WHILE

} else {
    // DISPLAY THERE ARE NO RECORDS
    echo '<p>No games found</p>';
}
*/

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager -> loadSQL($sql,$iConn);  #load SQL, pass in existing connection, add offset
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager -> showTotal() == 1){
    $itemz = "game";
  } else {
    $itemz = "games";
  }  //deal with plural
    echo '<p align="center">We have ' . $myPager -> showTotal() . ' ' . $itemz . '!</p>';
	while($row = mysqli_fetch_assoc($result)){ # process each row
         echo '<p align="center">
            <a href="' . VIRTUAL_PATH . 'game_view.php?id=' . (int)$row['GameID'] . '">' . dbOut($row['Name']) . '</a>
            </p>';
	}
	//the showNAV() method defaults to a div, which blows up in our design
    echo $myPager->showNav();//show pager if enough records

    //the version below adds the optional bookends to remove the div design problem
    //echo $myPager->showNAV('<p align="center">','</p>');
}else{#no records
    echo '<p>No games found</p>';
}

 // RELEASE RESULTS
 @mysqli_free_result($result);

 // CLOSE CONNECTION
 @mysqli_close($iConn);

 // INCLUDE FOOTER FILE
 include 'inc/footer.php';

?>
