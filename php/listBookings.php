<?php
//include "checksession.php";
//checkUser('AC_MANAGER');
//loginStatus();
?>
<!DOCTYPE HTML>
<html><head><title>Browse members</title> </head>
<body>
<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit;
}

$query = 'SELECT bookingID,roomID,customerID FROM `booking` ORDER BY bookingID';
$result = mysqli_query($DBC,$query);

$rowcount = mysqli_num_rows($result);
?>
<h1>Booking list</h1>
<h2>Booking count <?php echo $rowcount; ?></h2>
<h2><a href='registerBooking.php'>[Create new Booking]</a></h2>
<table border="1">
<thead><tr><th>Booking ID</th><th>Room ID</th><th>Customer ID</th><th>Actions</th></tr></thead>
<?php

//makes sure we have members
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
	  $id = $row['bookingID'];
	  echo '<tr><td>'.$row['bookingID'].'</td><td>'.$row['roomID'].'</td><td>'.$row['customerID'].'</td>';
      echo     '<td><a href="viewBooking.php?id='.$id.'">[view]</a>';
      echo     '<a href="editBooking.php?id='.$id.'">[edit]</a>';
      echo     '<a href="editBookingReview.php?id='.$id.'">[edit review]</a>';
	  echo     '<a href="deleteBooking.php?id='.$id.'">[delete]</a></td>';
      echo '</tr>'.PHP_EOL;
   }
} else echo "<h2>No bookings found!</h2>"; //suitable feedback

mysqli_free_result($result);
mysqli_close($DBC);
?>
</table>
</body>
</html>