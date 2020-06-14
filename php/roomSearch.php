
<?php
//include "checksession.php";
//checkUser('AC_MANAGER');
//loginStatus();
?>

<?php
//Our search/filtering engine
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();

//do some simple validation to check if sq contains a string
$sq = $_GET['sq'];
$searchresult = '';
if (isset($sq) and !empty($sq) and strlen($sq) < 31) {
    $sq = strtolower($sq);
//prepare a query and send it to the server using our search string as a wildcard on surname
    $query = 'SELECT * FROM `room` WHERE roomID NOT IN (SELECT roomID FROM booking WHERE (checkInDate >= [fromdate]) AND (checkOutDate <= [enddate]))';
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount > 0) {
        $rows=[]; //start an empty array
        //append each row in the query result to our empty array until there are no more results
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        //take the array of our 1 or more members and turn it into a JSON text
        $searchresult = json_encode($rows);
        //this line is crucial for the browser to understand what data is being sent
        header('Content-Type: text/json; charset=utf-8');
    } else echo "<tr><td colspan=3><h2>No bookings found!</h2></td></tr>";
} else echo "<tr><td colspan=3> <h2>Invalid search query</h2>";
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo  $searchresult;
?>