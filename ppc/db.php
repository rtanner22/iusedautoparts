<?php
$base = "iusedparts";
$user = "iusedparts";
$pass = "5huYvRDH";
$mlink = mysql_connect("192.168.200.100", "$user", "$pass") or  die('NODATA1');
//mysql_query("SET NAMES 'utf8'");
mysql_select_db("$base", $mlink) or die('NODATA2');
?>
