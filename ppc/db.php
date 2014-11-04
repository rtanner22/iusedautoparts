<?php
$base = "rtanner2_cpl";
$user = "rtanner2_38";
$pass = "e9!R7a03raa";
$mlink = mysql_connect("localhost", "$user", "$pass") or  die('NODATA1');
//mysql_query("SET NAMES 'utf8'");
mysql_select_db("$base", $mlink) or die('NODATA2');
?>
