<?php
error_reporting(0);
session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "e9!R7a03raa";
$mdb_database = "rtanner2_cpl";
$mdb_host = "localhost";
$mlink = mysql_connect($mdb_host, $mdb_username, $mdb_password);
mysql_select_db("$mdb_database", $mlink);

$params = json_decode(file_get_contents('php://input'));

$sql = "UPDATE `requests` SET `phone` = '$params->phone', `email` = '$params->email' WHERE `id` = $params->reqid";

$que = mysql_query($sql) or die(mysql_error());
if ($que) {
    /*echo "<script>alert('Thanks!! We will contact you soon.')</script>";*/
    //echo "<script>window.location.href='thanks.php'</script>";
    echo 'true';
}
else {echo 'false';}
?>