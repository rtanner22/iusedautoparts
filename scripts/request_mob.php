<?php

session_start();
$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host="192.168.200.100" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

	extract($_POST);
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$source = "";


$hollanderoption = explode(";", $hollanderoption);
$hollanderoption = "[" . implode(",", $hollanderoption) . "]";

	if(isset($_POST['mechanics']))
	{
		$wantsrepair=1;
	}
	else
	{
		$wantsrepair=0;
	}

    $sql = "insert into requests (date,udate,year,make,model,part,hnumber,hollanderoption,phone,zip,email,source,referrer,kw,se,ip,wantsrepair) values('$date',unix_timestamp(),'$year','$make','$model','$partname','$interchange','".mysql_real_escape_string($hollanderoption)."','$phone','$zip','$email','$source','$_SESSION[referrer]','$_SESSION[kw]','$_SESSION[se]','$ip','$wantsrepair')";
	$que=mysql_query($sql) or die(mysql_error());
	if($que)
	{
		$id = mysql_insert_id();
		$sqql = "select * from requests where id={$id}";
		$res = mysql_query($sqql);
		$p = mysql_fetch_array($res);

		echo (int)$id;
	}else{
		echo false;
	}
exit();


register_shutdown_function( "check_for_fatal" );
set_error_handler( "log_error");
set_exception_handler( "log_exception" );
ini_set( "display_errors", "on" );
error_reporting( E_ALL );

function log_exception( Exception $e )
{
    
        print "<div style='text-align: center;'>";
        print "<h2 style='color: rgb(190, 50, 50);'>Exception Occured:</h2>";
        print "<table style='width: 800px; display: inline-block;'>";
        print "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Type</th><td>" . get_class( $e ) . "</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Message</th><td>{$e->getMessage()}</td></tr>";
        print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
        print "</table></div>";
     exit();
}

function check_for_fatal()
{
    $error = error_get_last();
    if ( $error["type"] == E_ERROR )
        log_error( $error["type"], $error["message"], $error["file"], $error["line"] );
}


?>