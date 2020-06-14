<!DOCTYPE HTML>

<html><head><title>Login</title> </head>

 <body>
<?php
//this line is for debugging purposes so that we can see the actual POST data
echo "<pre>"; var_dump($_POST); echo "</pre>";

include "checksession.php";
loginStatus(); //show the current login status
echo "<pre>"; var_dump($_SESSION); echo "</pre>";

//simple logout
if (isset($_POST['logout'])) logout();

if (isset($_POST['login']) and !empty($_POST['login']) and ($_POST['login'] == 'Login')) {
    include "config.php"; //load in any variables
    $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();

    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['customerID']) and !empty($_POST['customerID']) and $_POST['customerID']) {
       $un = htmlspecialchars(stripslashes(trim($_POST['customerID'])));
       $customerID = (strlen($un)>32)?substr($un,1,32):$un; //check length and clip if too big
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid customerID '; //append error message
       $customerID = '';
    }
//password
       $password = trim($_POST['password']);

    if ($error == 0) {
        $query = 'SELECT customerID, password FROM `customer` WHERE customerID = '.$customerID;
        $result = mysqli_query($DBC,$query);
        if (mysqli_num_rows($result) == 1) { //found the user
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            mysqli_close($DBC); //close the connection once done
            {
            if ($password === $row['password']) //using plaintext for demonstration only!
              login($row['customerID'],$customerID);
            }
            echo "<h2>Login fail</h2>".PHP_EOL;
            } else {
                echo "<h2>$msg</h2>".PHP_EOL;
            }
        }
    }
?>
<h1>Login</h1>
<form method="POST" action="LogIn.php">
  <p>
    <label for="customerID">Customer ID: </label>
    <input type="int" id="customerID" name="customerID" maxlength="3">
  </p>
  <p>
    <label for="password">Password: </label>
    <input type="password" id="password" name="password" maxlength="40">
  </p>
   <input type="submit" name="login" value="Login">
   <input type="submit" name="logout" value="Logout">
 </form>
</body>
</html>