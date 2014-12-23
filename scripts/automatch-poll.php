<?php


include_once('Mail.php'); // pear module
//require_once ("mime.php");



// connect to database

$base = "iusedparts";
$user = "iusedparts";
$pass = "5huYvRDH";
$mlink = mysql_connect("192.168.200.100", "$user", "$pass") or  die('NODATA1');
//mysql_query("SET NAMES 'utf8'");
mysql_select_db("$base", $mlink) or die('NODATA2');

// Now check for distinct leads
$lcsql1 = "select distinct leadid from quotes where done = 0";
$result1 = mysql_query($lcsql1,$mlink);
//echo mysql_num_rows($result1)." new leads with quotes..<br>";

while ($row1 = mysql_fetch_array($result1))
{
  $leadid = $row1['leadid'];
  //echo $leadid."<br>";
   $lcsql2 = "select yards.yard,yards.warranty,yards.phone,yards.directory,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =   quotes.leadid where quotes.done = 0 and leadid = ".$leadid;
    //echo $lcsql2."<br>";
    $result2 = mysql_query($lcsql2,$mlink);
    $ctr = 0;
    $filename = "replytemplate.htm";
    $handle = fopen($filename, "r");
    $hmessage = fread($handle, filesize($filename));
    fclose($handle);

    $filename = "replytemplate.txt";
    $handle = fopen($filename, "r");
    $tmessage = fread($handle, filesize($filename));
    fclose($handle);


    $lcdata = "";
    $lctext= "";
  //  echo mysql_num_rows($result2)."..quotes<br>";
    while ($row2 = mysql_fetch_array($result2))
    {
      

      
      // This will be main loop going through quotes with code below.
      
      $ctr = $ctr + 1;
      $id= $row2['id'];
      $quoteleadid = $row2['leadid']; // This is the leadid from the requests table.

      $yardid = $row2['yardid']; // This is the yardid from yards table.
      $stocknumber = $row2['stocknumber'] ; // stocknumber
      $year = $row2['year'];
      $directory= $row2['directory'];
      $make = $row2['make'];  
      $umodel = $row2['umodel'];
      $model = $row2['model'];
      $options = $row2['options'];
      $rating = $row2['rating'];
      $quote = $row2['quote'];
      $part = $row2['part'];
      $yard = $row2['yard'];
      $warranty = $row2['warranty'];
      $hollanderoption = $row2['hollanderoption'];
      $yphone = $row2['phone'];
      $cusemail = $row2['email'];
      
      if ($ctr == 1)
      {
        $partdetails = $year." ".$make. " " . $umodel." " . $part; 
        
      }

  
      // Here are all the fields from quotes table.
      //echo $leadid." ".$yardid." ".$stocknumber." ".$year." ".$model." ".$options." ".$rating." ".$quote."<br>";
      
      // Now we need to gather the yard info, quote info and build an html set of rows for a table to display the data
      $lcdata = $lcdata .'<tr style="margin: 0;padding: 0;font-family:Arial, Helvetica, sans-serif;">
      <td style="margin: 0;padding: 2px;font-family:Arial, Helvetica, sans-serif;background-color: #DDDDDD;font-size: 12px;">'.$year.' '.$model.'</td>'.
/*      <td style="margin: 0;padding: 2px;font-family:Arial, Helvetica, sans-serif;background-color: #DDDDDD;font-size: 12px;">'.$model.'</td>-->*/
       '<td style="margin: 0;padding: 2px;font-family:Arial, Helvetica, sans-serif;background-color: #DDDDDD;font-size: 12px;">'.$options.'</td>

      <td style="margin: 0;padding: 2px;font-family:Arial, Helvetica, sans-serif;background-color: #DDDDDD;font-size: 12px;"><a style="color: #000;margin: 0;padding: 0;font-family:Arial, Helvetica, sans-serif;" target="_blank" href="'.$directory.'">'.$yard.'</a>&nbsp;'.$yphone.'</td>


      <td style="margin: 0;padding: 2px;font-family:Arial, Helvetica, sans-serif;text-decoration: underline;text-align: center;background-color:#CCFF66 ;font-size: 12px;"><a style="color: #000;margin: 0;padding: 0;font-family:Arial, Helvetica, sans-serif;" href="#">$'.$quote.'</a></td></tr>';

/*      <td align="center"><a href="http://www.autopartscheckout.com/order.php?cid=1001&ot=123456&orderid=1089001" target="_blank"><img src="http://www.drivetrainleads.com/admin/images/buynow.png" width="60px" height="60px"/></a></td>*/


     /* Now get the text data  */
     
     $lctext = $lctext . 
     "Vehicle: ".$year." ".$model."\n".
     "Options: ".$options."\n".
     "Vendor: ".$yard." - ".$yphone."\n".
     "-------------------------------------------------------------------------\n";
    

    // Now update that quote for that yard with the id
    /*$sql = "update quotes set done = 1 where id = $id limit 1";
    mysql_query($sql,$mlink);*/
    
    }


    /* Set the text message stuff in hmessage*/
    $tmessage = str_replace('PARTDATA',$lctext,$tmessage);
    $tmessage = str_replace('PARTDETAILS',"Part you requested: ".$partdetails."\n\n"."Part options: ".$hollanderoption,$tmessage);


    /* Set the html message stuff in hmessage*/
    $hmessage = str_replace('PARTDATA',$lcdata,$hmessage);
    $hmessage = str_replace('PARTDETAILS',"<p><strong>Part you requested:</strong>".$partdetails."</p><p><strong>Part options: </strong>".    $hollanderoption."</p>",$hmessage);




//echo $hmessage;

    $to = $cusemail;
    //$to ="57737@SpamScoreChecker.com";
    //$to="scott9950@gmail.com";
    //echo $to."<br>";
    //$to .= 'me@justinforrest.com'. ', '; // note the comma
    $bcc = 'scott9950@gmail.com'. ', '; // note the comma
    $bcc  .= 'rtanner22@gmail.com' ; // note the comma
    //$to .= 'brian@brianhanson.com';

    $subject = "You have received quotes for your ".$partdetails."!";
    $recipients =$to;


$headers["From"] = "iUsedAutoParts <quotes@autorecyclersonline.com>";
$headers["To"] = $to;
$headers["Bcc"] = $bcc;
$headers["Subject"] = $subject ;
$headers["Return-Path"] = "quotes@autorecyclersonline.com";
$headers["Reply-To"] = "quotes@autorecyclersonline.com";
$headers["X-Mailer"] = "PHP Pear";
$headers["Content-type"] = "multipart/alternative;boundary=--089e013d0db00faf7a04f33a2ac7";
$headers["MIME-Version"] = "1.0";


$message = '----089e013d0db00faf7a04f33a2ac7
Content-Type: text/plain; charset=us-ascii
Content-Transfer-Encoding: 7bit


'.$tmessage.'

----089e013d0db00faf7a04f33a2ac7
Content-Type: text/html; charset=us-ascii
Content-Transfer-Encoding: 7bit

'.$hmessage.'

----089e013d0db00faf7a04f33a2ac7--';

    

    echo $hmessage."<br>";
    die();
       //mail with php to test
    //echo "Mail:" . mail($to,$subject,$message,$headers);
    //die();
    

    // SMTP server name, port, user/passwd 
    $smtpinfo["host"] = "relay.jangosmtp.net";
    $smtpinfo["port"] =   "587";
    $smtpinfo["auth"] =   true;
    $smtpinfo["username"] =  "rollytan";
    $smtpinfo["password"] =  "941194HT";
    
    /* Create the mail object using the Mail::factory method */
    $mail_object =& Mail::factory("smtp", $smtpinfo);
    /* Ok send mail */
    echo "About to send to : ".$recipients."<br>";
    
    $mail_object->send($recipients, $headers, $message);
    //die("sent mail");
    if (PEAR::isError($mail)) 
     {
      echo($mail->getMessage() . "<br>");
     } else 
    
     {
      $ctr = $ctr +   1 ;
      echo "<br/>Message successfully sent to ".$to."!<br/>" ;
              
     }
    
}

echo "<br>Done!";


?>    
