<?php
error_reporting(0);
session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "e9!R7a03raa";
$mdb_database = "rtanner2_cpl";
$mdb_host="localhost" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

	extract($_POST);
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$source = "";

$interchange = explode("|", $interchange);
$hollanderoption = explode(";", $hollanderoption);
$hollanderoption = "[" . implode(",", $hollanderoption) . "]";
	//print_r($_POST);

	if(isset($_POST['mechanics']))
	{
		$wantsrepair=1;
	}
	else
	{
		$wantsrepair=0;
	}

    $sql = "insert into requests (date,udate,year,make,model,part,hnumber,hollanderoption,phone,zip,email,source,referrer,kw,se,ip,wantsrepair) values('$date',unix_timestamp(),'$year','$make','$model','$partname','$interchange[2]','".mysql_real_escape_string($hollanderoption)."','$phone','$zip','$email','$source','$_SESSION[referrer]','$_SESSION[kw]','$_SESSION[se]','$ip','$wantsrepair')";
	$que=mysql_query($sql) or die(mysql_error());
	if($que)
	{
		/*echo "<script>alert('Thanks!! We will contact you soon.')</script>";*/
		//echo "<script>window.location.href='thanks.php'</script>";
		echo mysql_insert_id();
	}
?>