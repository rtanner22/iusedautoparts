<?php
error_reporting(0);
session_start();

date_default_timezone_set('America/Chicago');

$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host = "192.168.200.100";
$mlink = mysql_connect($mdb_host, $mdb_username, $mdb_password);
mysql_select_db("$mdb_database", $mlink);

$params = json_decode(file_get_contents('php://input'));
include (__DIR__).'/email_valid.php';
if(!check_email($params->email)) {
    echo 'false';
    return;
}

$sql = "UPDATE `requests` SET `phone` = '$params->phone', `email` = '$params->email' WHERE `id` = $params->reqid";

$que = mysql_query($sql) or die(mysql_error());
if ($que) {
    $_SESSION['email_data'] = $params->email;
    /*echo "<script>alert('Thanks!! We will contact you soon.')</script>";*/
    //echo "<script>window.location.href='thanks.php'</script>";
    echo 'true';
}
else {echo 'false';}