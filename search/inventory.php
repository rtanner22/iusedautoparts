<?php
session_start();

//register_shutdown_function( "check_for_fatal" );
//set_error_handler( "log_error" );
//set_exception_handler( "log_exception" );
ini_set( "display_errors", "off" );
error_reporting( 0 );


require_once __DIR__.'/../testing/inc/rb.phar';

ini_set("allow_url_fopen", true);
R::setup('mysql:host=192.168.200.100;dbname=iusedparts', 'iusedparts', '5huYvRDH');

if (!isset($_REQUEST['order_by'])) {
    $order_by = "quote";
} else {
    $order_by = $_REQUEST['order_by'];
}
$result1 = R::getAll("select * from requests where id = '" . (int)$_REQUEST["response"] . "' ");
$zipcode = $result1[0]['zip'];
$result = R::getAll("select yards.yard,yards.warranty,yards.phone,yards.directory,yards.zip,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =     quotes.leadid where quotes.done = 0 and leadid = '" . (int)$_REQUEST["response"] . "' order by " . $order_by . " desc ");

########################### Paging variables ########################
require_once __DIR__.'/../testing/inc/paging_admin.php';
$rowsPerPage = 20;

//$_SESSION['rowsPerPage']=$rowsPerPage;
$_SESSION['page_r'] = isset($_REQUEST['pg'])?$_REQUEST['pg']:null;
$pageNum = 1;
if (isset($_GET['pg'])) {
    $pageNum = $_GET['pg'];
}
$offset = (int)abs(($pageNum - 1) * $rowsPerPage);
$pg = $pageNum;

$page_row = count($result);
$numofpages = ceil($page_row / $rowsPerPage);
$selfurl = "?"; //paging URL
//============================================================================

$queryString = "select yards.yard,yards.warranty,yards.address,yards.city,yards.state,yards.zip,yards.phone,yards.directory,yards.zip,yards.facebook,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =     quotes.leadid where quotes.done = 0 and leadid = '" . (int)$_REQUEST["response"] . "'  order by " . $order_by . " desc  LIMIT ".(int)abs($offset).", ". (int)abs($rowsPerPage)." ";
$limit = 10;
while( !$result && $limit>0 ){
    $result = R::getAll($queryString);
    $limit--;
    usleep(rand(500000,1000000));
}
// Final request
usleep(500000);
$queryString = "select yards.yard,yards.warranty,yards.address,yards.city,yards.state,yards.zip,yards.phone,yards.directory,yards.zip,yards.facebook,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =     quotes.leadid where quotes.done = 0 and leadid = '" . (int)$_REQUEST["response"] . "'  order by " . $order_by . " desc  LIMIT ".(int)abs($offset).", ". (int)abs($rowsPerPage)." ";
$result = R::getAll($queryString);

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
<div class="wrapperbody" style="display:table;">
  <div class="inwrap">







  
    
  
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php if ($result) { ?>
                        <h1>Your in luck! </h1><h2>Select a recycler, call the number in <font color="red">red</font> and ask for your discounted offline price...</h2>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Donor Vehicle</th>
                                    <th width="40px">Part/Options</th>
                                    <th>Stock #</th>
                                    <th>Grade</th>
                                    <th class="green">Price</th>
                                    <th>Dealer Info</th>
                                    <th>Distance<br/>
                                        (Miles)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    foreach ($result as $row) {
        $distance = getDistance($zipcode, "$row[zip]", "M");
        $distance = sprintf("%1.1f", $distance);
    $quote = $row['quote'];
    if ($quote == 0)
    { $quote='Call';
    }
        ?>
                                    <tr>
                                        <td><?php echo $row['year']; ?> <?php echo $row['model']; ?></td>
                                        <td><?php echo $row['part']; ?><br><?php echo $row['options']; ?></td>
                                        <td><?php echo $row['stocknumber']; ?></td>
                                        <td><?php echo $row['rating']; ?></td>
                                        <td class="green">$<?php echo $quote ; ?></td>
                                        <td>
        <?php
        if ($row['directory'] != "") {
            echo "<a href='$row[directory]' target=_BLANK>";
        }
        ?>
                                            <?php echo "<font color=\"#55565B\">".$row['yard']."</font>"; ?>
                                            <?php
                                            if ($row['directory'] != "") {
                                                echo "</a>";
                                            }
                                            ?><br>
                                            <?php echo $row['address']; ?>, <?php echo $row['city']; ?>
                                            , <?php echo $row['state']; ?> <?php echo $row['zip']; ?>
                                            <br><font color="red"><?php echo $row['phone']; ?></font>&nbsp;&nbsp;
                                            <?php
                                            if ($row['facebook'] != "") {
                                                echo '<a href="' . $row['facebook'] . '" target="_blank"><img src="/images/facebook.png"></a>';
                                            }
                                            ?>

                                        </td>
                                        <td><?php echo $distance; ?></td>
                                    </tr>

    <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-4"><a
                                    href="?pg=<?php echo $pg - 1; ?>&reqid=<?php echo $_REQUEST['response']; ?>"
                                    class="btn btn-orange btn-sm" <?php
                                    if ($pageNum == 1) {
                                        echo "style='display:none'";
                                    }
                                    ?>><i
                                        class="fa fa-arrow-left"></i> PREVIOUS PAGE</a></div>
                            <div class="col-lg-4">
                                <div class="text-center">
                                    <p>Results Page <?php echo $pageNum; ?> of <?php echo $numofpages; ?>
                                        (<?php echo $page_row; ?> results)</p>
                                    <ul class="pagination" style="list-style-type: none;">
                                        <li>
                                            <a href="?pg=<?php echo $pg - 1; ?>&reqid=<?php echo $_REQUEST['response']; ?>" <?php
                                        if ($pageNum == 1) {
                                            echo "style='display:none'";
                                        }
                                        ?>>&laquo;</a>
                                        </li>
                                            <?php
                                               for ($i = 1; $i <= $numofpages; $i++) {
                                                   ?>
                                            <li>
                                                <a href="?pg=<?php echo $i; ?>&reqid=<?php echo $_REQUEST['response']; ?>" <?php
                                                   if ($numofpages == 1) {
                                                       echo "style='display:none'";
                                                   }
                                                   ?> ><?php echo $i; ?></a>
                                            </li>
    <?php } ?>
                                        <li>
                                            <a href="?pg=<?php echo $pg + 1; ?>&reqid=<?php echo $_REQUEST['response']; ?>" <?php
                            if ($numofpages == $pageNum) {
                                echo "style='display:none'";
                            }
                            ?>>&raquo;</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4" <?php
                            if ($numofpages == $pageNum) {
                                echo "style='display:none'";
                            }
                            ?> >
                                <div class="text-right"><a
                                        href="?pg=<?php echo $pg + 1; ?>&reqid=<?php echo $_REQUEST['response']; ?>"
                                        class="btn btn-orange btn-sm"> NEXT PAGE <i class="fa fa-arrow-right"></i></a></div>
                            </div>
<?php } else { ?>
                            
                            <button  style = "display: none;"id ="triggerModal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>
                            <script>
                                document.addEventListener("DOMContentLoaded", function (event) {
                                    var button = document.getElementById("triggerModal");
                                    button.click();
                                });
                            </script>
                            <!-- Large modal -->
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div ng-app="App">
                                      <div class = "modal-body" ng-controller="Controller">
                                        <h1 ng-show="submitted">Thanks!! We will contact you soon.</h1>
                                        <h1 ng-show="error">Error email address</h1>
                                        <ng-form  ng-show="!submitted" class="css-form" name="user_form">
                                            <h2>Almost finished! Please provide your email address to receive your quote.</h2>
                                            <input type="hidden" ng-model="req.id" ng-init="req.id=<?= isset($_REQUEST['response']) ? $_REQUEST['response'] : '0'; ?>">

                                            <div class="row">

                                                <div class="col-xs-12" style="text-align:center;">
                                                    <input type="email" class="form-control input-lg" ng-model="req.email"
                                                           placeholder="Enter a valid email address" id="email_valid_text" required=""/>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-center" style="text-align:center;">
                                                        <div ng-show="user_form.$valid" ng-click="submit()" id="email_valid" class="btn btn-orange" style="display: inline-block !important;cursor:pointer;">
                                                            Submit <i class="fa fa-arrow-right"></i>
                                                        </div>
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="row mtop10 text-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php } ?>
                    </div>
                </div>
            </div>










</div>
<div class="foot" style="text-align:center;margin-top:40px;"><p style="margin-left:0;"> &copy; Copyright - autorecyclersonline.com</p>
    <p style="position: relative;display: inline-block;text-align: center;margin-left:0;">FAQ | Terms & Conditions | Privacy Policy | <a href="/search/contactus.php">Contact | <a href="/search/aboutus.php">About</a></p]></div>
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




<?php


function getLnt($zip) {

    $result1 = R::getAll("select lat, lng from zipcodes2 where Zipcode = '$zip' ");
    $result['lat'] = $result1[0]['lat'];
    $result['lng'] = $result1[0]['lng'];
    return $result;
}

function getDistance($zip1, $zip2, $unit) {

    $first_lat = getLnt($zip1);
    $next_lat = getLnt($zip2);
    $lat1 = $first_lat['lat'];
    $lon1 = $first_lat['lng'];
    $lat2 = $next_lat['lat'];
    $lon2 = $next_lat['lng'];
    //return $first_lat;
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K") {
        return ($miles * 1.609344) . " " . $unit;
    } else if ($unit == "N") {
        return ($miles * 0.8684) . " " . $unit;
    } else {
        return $miles . " " . $unit;
    }
}

/**
* Error handler, passes flow over the exception logger with new ErrorException.
*/
function log_error( $num, $str, $file, $line, $context = null )
{
    log_exception( new ErrorException( $str, 0, $num, $file, $line ) );
}

/**
* Uncaught exception handler.
*/
function log_exception( Exception $e )
{
    print "Type: " . get_class( $e ) . "\n";
    print "Message: {$e->getMessage()}\n";
    print "File: {$e->getFile()}\n";
    print "Line: {$e->getLine()}\n";
    exit();
}

/**
* Checks for a fatal error, work around for set_error_handler not working on fatal errors.
*/
function check_for_fatal()
{
    $error = error_get_last();
    if ( $error["type"] == E_ERROR )
        log_error( $error["type"], $error["message"], $error["file"], $error["line"] );
}
