<?php
session_start();

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car parts locator</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />


</head>
<body>

<div class="wrapperheader">
    <div class="inwrap">
        <div class="header-img">
            <img src="img/logo7.png" alt="img">
        </div>
    </div>
</div>


<?php
      if($_GET['mail']=="true") {
    //$admin_email = "dbmathewes@gmail.com";
    $headers = 'From: IUAP Contact Form <noreply@autorecyclersonline.com>';
    $admin_email = "admin@drivetrainleads.com";
    $subject = "Message from autorecyclersonline.com";
    $body = "Name: " . $_POST['contact_name'] . " \n\nEmail: ".$_POST['contact_email']." \n\nMessage: ";
    $body .= $_POST['contact_message'];
      mail($admin_email, $subject, $body,$headers);
      echo "Your message has been sent.";
    }
?>
<div class="wrapperbody" style="display: table;">
  <div class="inwrap">
    <div class="selection-box" style="background-color:#FFF; color:#333; padding:10px;">
      <div class="wrap alt">
        <div class="container wrap-contact">
          <h1>Contact</h1>

          <p>autorecyclersonline.com<br />
          4513 Old Shell Road<br />
          Suite 202<br />
          Mobile, AL 36608</p>

          <p>To send us an email use the form below:</p>

          <form action="?mail=true" method="post">

            <p><input type="text" name="contact_name" value="" placeholder="Your name" /></p>
            <p><input type="text" name="contact_email"  value="" placeholder="Your email" /></p>
            <p><textarea name="contact_message" id="message" placeholder="Message" cols="70" rows="10"></textarea></p>
            <button id="submit-contact" type="submit" class="btn btn-orange btn-sub-cont">Submit</button>
          
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="foot" style="text-align:center;margin-top:40px;"><p style="margin-left:0;"> &copy; Copyright - autorecyclersonline.com</p>
    <p style="position: relative;display: inline-block;text-align: center;margin-left:0;">FAQ | Terms & Conditions | Privacy Policy | <a href="http://www.autorecyclersonline.com/search/contactus.php">Contact | <a href="http://www.autorecyclersonline.com/search/aboutus.php">About</a></p]></div>
</div>

 <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2096092-53']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  


</script>


<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>

<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1070872026/?label=9khiCNzOuggQ2uvQ_gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


</script>


</body>



</html>
