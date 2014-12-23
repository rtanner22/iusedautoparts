<?php

date_default_timezone_set('America/Chicago');

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.


// This will capture quotes from lead matches and insert them into the database 'quotes'
// If token is set it means its a valid response

if (isset($_REQUEST[token]))
{
    if ($_REQUEST[token] != 'ri80sr14Kf' && $_POST['token'] !='ri80sr14Kf')
    {
    die('INVALIDTOKEN');
    }
    
    //echo 'ok';  
    
    $base = "iusedparts";
    $user = "iusedparts";
    $pass = "5huYvRDH";
    $mlink = mysql_connect("192.168.200.100", "$user", "$pass") or  die('NODATA1');
    mysql_select_db("$base", $mlink) or die('NODATA2');
    
  
  switch($_REQUEST[action]){
    
  
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




     case "getleads":  

      
      // first we want to get the lastsyncu from  
      $lastsyncu = $_GET[lastsyncu];
            $yardid = $_GET['yardid'];
      
      //echo "Lastsync: ". $lastsyncu."<br>";
      //echo "Yardid: ". $yardid."<br>";

      if ($yardid=="" && $lastsyncu == "")
      {die("No YardID or lastsync Supplied to Get Leads");
      }

      // get latest sync
      if ($lastsyncu == "" && $yardid !="")
      {
        //echo 'yardid good<br>';
        $lcget = "select yard,lastsyncu,pricing from yards where yardid = '$yardid' and active=1 limit 1";
        $lnresult = mysql_query($lcget,$mlink);
        if (mysql_num_rows($lnresult) > 0)
        {
          $row = mysql_fetch_array($lnresult);
          $lastsyncu = $row['lastsyncu'];
        }else
        {
         die("No yards with yardid ".$yardid."-ITSOK");                
        }

      }



         $lcget = "select id,hnumber,udate from requests where udate > '$lastsyncu' and hnumber != '' order by udate asc";
      $lnresult = mysql_query($lcget,$mlink);

      while ($row = mysql_fetch_array($lnresult))
      {

        echo $row['id']."|".$row['hnumber']."|".$row['udate']."<br>";
      }

      echo 'ITSOK';





         break;

     case "getyardinfo":
         
      $yardid= $_GET[yardid];
         $lcget = "select yard,lastsyncu,pricing from yards where yardid = '$yardid' and active=1 limit 1";
      $lnresult = mysql_query($lcget,$mlink);
      if (mysql_num_rows($lnresult) > 0)
      {
        $row = mysql_fetch_array($lnresult);
        $yard = $row['yard'];
        $lastsync = $row['lastsyncu'];
                                $pricing = $row['pricing'];
        $dt =strtotime(date('Y-m-d H:i:s'));
        echo $yard."|".$lastsync."|".$pricing ."|". $dt."ITSOK";

      }else
      {
        echo "NOGOOD";  
      }
         break;
         
     
     case "verifyclient":  
     
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


     case "error":    
     
      $from = "admin@autorecyclersonline.com";
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


     case "logit":    
      
      $yardid = $_REQUEST['yardid'];
      $logmessage = $_REQUEST['message'];
      $logmessage = addslashes($logmessage);
      $lcinsert = "insert into errors (date,yardid,message) values (now(),'$yardid','$logmessage')";
      //echo $lcinsert;
      $lnresult = mysql_query($lcinsert,$mlink);
      if ($lnresult == true)
      {
        echo "OK";  
      }else{
       //echo mysql_errno($mlink) . " " . mysql_error($mlink);
      }
  
         break;


      case "getlastsync":
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
    case "loglastsync":
        $yardid = $_GET[yardid];
        $nextsync = $_GET[nextsync];
        $d = date("Y-m-d H:i:s",$nextsync);
        $lcinsert = "update yards set lastsyncu = '$nextsync',lastsync ='$d' where yardid = $yardid and active = 1 limit 1";
        $lnresult = mysql_query($lcinsert,$mlink);
        if ($lnresult == true)
        {
          echo "OK";  
        }
  
        break;

        } // end of switch
  


 mysql_close($mlink);
}
