<?php

date_default_timezone_set('America/Chicago');

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.


// This will capture quotes from lead matches and insert them into the database 'quotes'
// If token is set it means its a valid response

if (isset($_GET[token]))
{
		if ($_GET[token] != 'ri80sr14Kf')
		{
		die('INVALIDTOKEN');
		}
		
		//echo 'ok';	
		
		$base = "rtanner2_cpl";
		$user = "rtanner2_38";
		$pass = "BHeFVC7i";
		$mlink = new mysqli("localhost", "$user", "$pass", "$base");
		
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

	
	switch($_GET[action]){
		
	
		case "insertquote":

				$date = date('Y-m-d H:i:s');
				$leadid = $_GET[leadid];
				$yardid = $_GET[yardid];
				$stocknumber = $_GET[stocknumber];
				$year = $_GET[year];
				$model = $_GET[model];
				$options = $_GET[options];
				$rating = $_GET[condition];
				$quote = $_GET[quote];
				//print_r($_GET);
				
				
				$lcinsert = "insert into quotes (date,udate,leadid,yardid,stocknumber,year,model,options,rating,quote) values ('$date',unix_timestamp(),$leadid,$yardid,'$stocknumber','$year','$model','$options','$rating',$quote)";


				$lnresult = mysql_query($lcinsert,$mlink);
				//echo mysql_errno($mlink) . ": " . mysql_error($mlink) . "\n";
				if ($lnresult == true)
				{
					echo "OK";	
				}
				break;
				
	   case "getleads";		
	   
	   		$lastsyncu = $_GET[lastsyncu];
	   		$lcget = "select id,hnumber,udate from requests where udate > '$lastsyncu' order by udate asc";
			//echo $lcget."<br/>";
			$lnresult = mysql_query($lcget,$mlink);
			//echo mysql_errno($mlink) . ": " . mysql_error($mlink) . "\n";
			while ($row = mysql_fetch_array($lnresult))
			{
				echo $row['id']."|".$row['hnumber']."|".$row['udate']."<br>";
			}

			echo 'ITSOK';

	   		break;

	   case "getyardinfo";
	   		$yardid= $_GET[yardid];
	   		$lcget = "select yard,lastsyncu,pricing from yards where yardid = " .$yardid." and active=1 limit 1";
			$stmt = $mlink->prepare($lcget);
			$stmt->execute();
			$stmt->store_result();
	
			if ($stmt->num_rows > 0)
			{
				$row = mysql_fetch_array($lnresult);
				$stmt->bind_result($yard,$lastsyncu,$pricing);
				while ($stmt->fetch()) {
				printf($yard."|".$lastsyncu."|".$pricing."|". strtotime(date('Y-m-d H:i:s')));
				}
				echo 'ITSOK';
			}else
			{
			  echo "NOGOOD";	
			}
			
			$stmt->close();
	   		break;
			   
	   
	   case "verifyclient";		
	   
	   		$yardid= $_GET[yardid];
	   		$lcget = "select * from yards where yardid = $yardid and active=1 limit 1";
			$lnresult = mysql_query($lcget,$mlink);
			if (mysql_num_rows($lnresult) > 0)
			{
				$row = mysql_fetch_array($lnresult);
				echo $row['yard']."<br>";
				echo 'ITSOK';
			}else
			{
			  echo "NOGOOD";	
			}
	   		break;


	   case "error";		
	   
			$from = "admin@carpartslocator.com";
			$headers = "From:" . $from;
			$yardid = $_GET[yardid];
			$message = "Error from PartMatch ".$_GET[message];
			
			//mail("rtanner22@gmail.com","Error from Lead Check YardId: ".$yardid,$message,$headers);
			$lcinsert = "insert into errors (date,yardid,message) values (now(),'$yardid','$message')";
			$lnresult = mysql_query($lcinsert,$mlink);
			if ($lnresult == true)
			{
				echo "OK";	
			}
	
	   		break;


	    case "getlastsync";
		// not used for some reason
		//Put code here to get last sync unix timestamp.
		$yardid = $_GET[yardid];
   		$lcget = "select lastsyncu from yards where yardid = $yardid and active=1 limit 1";
		$lnresult = mysql_query($lcget,$mlink);
		$row = mysql_fetch_array($lnresult);
		$lastsync = $row['lastsyncu'];
		echo $lastsync;
		break;


		// Put code here to log last sync datetime
		case "loglastsync";
				$yardid = $_GET[yardid];
				$nextsync = $_GET[nextsync];
				$d = date("Y-m-d H:i:s",$nextsync);
				//echo $yardid." Date: ". $d." Nextsync: ".$nextsync." OK";	
				//die();
				$lcinsert = "update yards set lastsyncu = '$nextsync',lastsync ='$d' where yardid = $yardid and active = 1 limit 1";
				$lnresult = mysql_query($lcinsert,$mlink);
				if ($lnresult == true)
				{
					echo "OK";	
				}
	
				break;

				} // end of switch
	

}