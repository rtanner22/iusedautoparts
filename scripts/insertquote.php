<?php

date_default_timezone_set('America/Chicago');
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

//echo('test');
//echo $_POST['token'];
//echo "insert data: " . $_POST['sqlinsertdata'];
// This will capture quotes from lead matches and insert them into the database 'quotes'
// If token is set it means its a valid response
//$headers = "From: ronnie@iusedautoparts.com";
//mail("rtanner22@gmail.com","Error from Lead Check YardId","Test Message",$headers);

if (isset($_POST[token]))
{
		if ($_POST['token'] != 'ri80sr14Kf')
		{
		die('INVALIDTOKEN');
		}
		
		//echo 'ok';	
		
		$base = "rtanner2_cpl";
		$user = "rtanner2_38";
		$pass = "e9!R7a03raa";
		$mlink = mysql_connect("localhost", "$user", "$pass") or  die('NODATA1');
		mysql_select_db("$base", $mlink) or die('NODATA2');
		
		$lfound = $_POST['recordsfound'];
		$lupdate = $_POST['lastupdate'];
		$lcinsert = $_POST['sqlinsertdata'];
		$yardid = $_POST['yardid'];
		
		$from = "ronnie@iusedautoparts.com";
		$headers = "From:" . $from;
		$message = "Error from PartMatch ".$lcinsert;
		mail("rtanner22@gmail.com","Insert from yardid: ".$yardid,$message,$headers);
			
			
		$lcinsert = "insert into quotes (date,udate,leadid,yardid,stocknumber,year,model,options,rating,quote) VALUES " . $lcinsert ;
		$lnresult = mysql_query($lcinsert,$mlink);
		if ($lnresult == true)
		{
			echo "OK";	

			if ($lfound == 1)
			{
			$nextsync = $lupdate ;
			$d = date("Y-m-d H:i:s",$nextsync);
			//echo $d;
			$lcinsert2 = "update yards set lastsyncu = '$nextsync',lastsync ='$d' where yardid = $yardid and active = 1 limit 1";
			$lnresult2 = mysql_query($lcinsert2,$mlink);
			}





		}else
		{ 
			echo 'Bad Query: ' . $lcinsert;
		}
		
	




 mysql_close($mlink);
}