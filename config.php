<?php

$host = "localhost"; /* Host name */
$user = "local"; /* User */
$password = "local1234"; /* Password */
$dbname = "sandiegobloodbank"; /* Database name */

$con = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


/**
 * CREATE USER 'local'@'localhost' IDENTIFIED VIA mysql_native_password USING '***';GRANT ALL PRIVILEGES ON *.* TO 'local'@'localhost' 
 * REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `local\_%`.* TO 'local'@'localhost';
 */