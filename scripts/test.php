 <?php



echo 'About to run shell..<br>';
$url = 'http://www.carpartslocator.com/scripts/test2.php';
echo shell_exec("wget '$url'");
echo 'Shell done..<br>';
die();



/* ---------------------------------------------- */
/* ------------ BEGIN PHP SNIPPET ----------------*/
/* ---------------------------------------------- */

include_once('Mail.php'); // pear module

/*$headers = "FROM: admin@carpartslocator.com\n";
$headers .= "Reply-To: admin@carpartslocator.com\n";
$headers.="MIME-Version:1.0\n";
$headers .= "Content-Type: multipart/alternative; boundary=089e013d0db00faf7a04f33a2ac7\n";
*/
$to = "rtanner22@gmail.com";
$recipients = "rtanner22@gmail.com";


// Now begin your message, starting with the delimiter we specified in the boundary
// Notice that two extra dashes (–) are added to the delimiters when
// They are actually being used.
$message = '----089e013d0db00faf7a04f33a2ac7
Content-Type: text/plain; charset=UTF-8; format=flowed; delsp=yes


Your plaintext email content here.

----089e013d0db00faf7a04f33a2ac7
Content-Type: text/html; charset=UTF-8
Content-Transfer-Encoding: quoted-printable

<html>
<head>
</head>
<body>
<div style="FONT-SIZE: 14pt; FONT-FAMILY: Arial">This is some sample HTML</div>
</body>
</html>


----089e013d0db00faf7a04f33a2ac7--';

echo $message;


// Now send the mail.
// The additional header, "-f invites@yourbigevents.com" is
// only required by certain server configurations.
//echo mail("98254@SpamScoreChecker.com", "2002 Winter Games InvitationX", $message ,$headers,"-f admin@carpartslocator.com");
//echo mail("rtanner22@gmail.com", "2002 Winter Games InvitationX", $message ,$headers,"-f admin@carpartslocator.com");


$subject = "test email messages";
$headers["From"] = "admin@carpartslocator.com";
$headers["To"] = $to;
$headers["Subject"] = $subject ;
$headers["Return-Path"] = "admin@carpartslocator.com";
$headers["Reply-To"] = "admin@carpartslocator.com";
$headers["X-Mailer"] = "PHP Pear";
$headers["Content-type"] = "multipart/alternative;boundary=--089e013d0db00faf7a04f33a2ac7";
$headers["MIME-Version"] = "1.0";


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
		  $ctr = $ctr +	 1 ;
		  echo "<br/>Message successfully sent to ".$to."!<br/>" ;
						  
		 }









?>