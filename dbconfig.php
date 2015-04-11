<?php
define("DB_SERVER", "local.host.com");
define("DB_USERNAME", "root");    // DB username
define("DB_PSSWORD", "123456");    // DB password
define("DB_DATABASE", "fhb");      // DB name
//$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$link = mysqli_connect("local.host.com", "root", "123456","fhb") or die("Error " . mysqli_error($link));
//$database = mysqli_select_db(DB_DATABASE) or die( "Unable to select database");
?>
