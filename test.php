<?php

/*Time testing
echo strtotime('2014-02-19 13:13:58');
date_default_timezone_set('America/Chicago');
$d =date('Y-m-d H:i:s');
echo "Now in CST: ". $d."<br>";
echo "NowUnix: ". strtotime($d). "<BR>";

date_default_timezone_set('America/New_York');
$d =date('Y-m-d H:i:s');
echo "Now in EST: ". $d."<br>";
$u = strtotime($d);
echo "NowUnix: ". $u."<br>";
echo "Converted back: " . date("Y-m-d H:i:s",$u)

*/


/*testing holalnder options*/

session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "BHeFVC7i";
$mdb_database = "rtanner2_cpl";
$mdb_host="localhost" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);
echo "Connect ok!<br>";

$sql = "select * from indexlistapp where indexlistid = 91123 order by seqnbr,TREELEVEL";

$result = mysql_query($sql);
echo "Rows: ".mysql_num_rows($result)."<br>";

$html="";

while ($row = mysql_fetch_array($result))
{

$app = $row[Application];
$number = $row[InterchangeNumber];

if ($number != "")
{
	$html .= $app." [".$number."]<br>";
	echo $html."<br>";
	$html = "";
}else
{

	$html =

}







}



?>