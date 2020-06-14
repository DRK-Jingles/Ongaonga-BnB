<?php
//MySQL credentails
define("DBUSER","root");
define("DBPASSWORD","root");
define("DBDATABASE","ongaongadb");
//simple variable debug function
//usage: pr($avariable);
if (!function_exists('pr')) {
  function pr($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
  }
}
?>
