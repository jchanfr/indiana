<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

if (1==0) {
  define('DB_SERVER', 'indianapbpmetric.mysql.db');
  define('DB_USERNAME', 'indianapbpmetric');
  define('DB_PASSWORD', 'Indiana01');
  define('DB_NAME', 'indianapbpmetric');
}
else {
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'indiana');

};

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
