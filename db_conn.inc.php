<?php
$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "rcsdb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "connect failed";
}
