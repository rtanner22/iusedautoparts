<?php
session_start();
error_reporting( 0 );

require_once __DIR__.'/../testing/inc/rb.phar';

var_dump($_REQUEST);die;
R::setup('mysql:host=192.168.200.100;dbname=iusedparts', 'iusedparts', '5huYvRDH');

function min_mod () {
  $args = func_get_args();

  if (!count($args[0])) return false;
  else {
    $min = false;
    foreach ($args[0] AS $value) {
      if (is_numeric($value) && $value != 0 ) {
        $curval = floatval($value);
        if ($curval < $min || $min === false) $min = $curval;
      }
    }
  }

  return $min;
}

function getLnt($zip) {

    $result1 = R::getAll("select lat, lng from zipcodes2 where Zipcode = '$zip' ");
    $result['lat'] = $result1[0][lat];
    $result['lng'] = $result1[0][lng];
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

$result1 = R::getAll("select * from requests where id = '" . $_REQUEST['reqid'] . "' ");
$zipcode = $result1[0]['zip'];
$hnumber = $result1[0]['hnumber'];

############################ Paging variables ########################
include(__DIR__.'/../testing/inc/paging_admin.php');

$rowsPerPage = 10;
$pageNum = 1;
if (isset($_GET['pg'])) {
    $pageNum = (int)$_GET['pg'];
    $pageNum = ($pageNum <= 0) ? 1 : $pageNum;
}
$offset = ($pageNum - 1) * $rowsPerPage;

$pagesql = "SELECT SQL_CALC_FOUND_ROWS
COUNT(DISTINCT inventory.inventoryid) as c_count,
GROUP_CONCAT(DISTINCT inventory.retailprice ORDER BY inventory.retailprice ASC SEPARATOR ',') AS c_price,
yards.yardid,yards.yard,yards.warranty,yards.address,yards.city,yards.state,yards.phone,yards.directory,yards.zip,inventory.*
FROM inventory
INNER JOIN yards on yards.yardid = inventory.yardid
WHERE inventory.inventorynumber = '" . $hnumber ."'
GROUP by yards.yard
ORDER by retailprice DESC LIMIT $offset,$rowsPerPage;";

$result = R::getAll($pagesql);
var_dump($result);die;
$page_row = R::getCell('SELECT FOUND_ROWS();');
$pg = $pageNum;
$numofpages = ceil($page_row / $rowsPerPage);
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

<div class="wrapperbody">
<div class="modal fade" id="data">
  <div class="modal-dialog" style="min-width: 900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">All Results for <span></span></h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php if ($result) { ?>
                            <h1>You're in luck! </h1><h2>Select a recycler, call the number in <font color="red">red</font> and ask for your discounted offline price...<?php //echo $_REQUEST['reqid'];  ?></h2>
                            <!--<p>Click on a heading to re-sort the results.</p>-->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Donor Vehicle</th>

                                        <th width="60px">Part/Options</th>
                                        <th>Stock #</th>
                                        <th>Grade</th>
                                        <th class="green">Price</th>
                                        <th>Dealer Info</th>
                                        <th>Distance<br/>
                                            (Miles)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table-hide">
        <?php
        foreach ($result as $row) {
            $distance = getDistance($zipcode, "$row[zip]", "M");
            $distance = sprintf("%1.1f", $distance);
            $quote = (float)$row[retailprice];
            $mileage = $row['mileage'];
            if ($mileage > 0)
            {
            $mileage = "(Mileage: " . number_format($mileage,0,'.',',').")";
            }else{$mileage="";}
            //number_format($quote,2,'.',',');
            if ($quote == 0)    { $quote='Call';  }   else { $quote = '$'.(float)$row['retailprice'];}
            //echo $row[zip];
            ?>
                        <tr>
                            <td>
                                <?php if($row[c_count] > 1){ ?>
                                    <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                                <?php }else{ ?>
                                    <?php echo $row[modelyear]; ?> <?php echo $row[modelname]; ?>
                                <?php } ?>
                            </td>
                            <td><?php  echo $mainresult[0][part] ."<br>". $row[conditionsandoptions] . "<br>". $mileage ; ?></td>
                            <td>
                                <?php if($row[c_count] > 1){ ?>
                                    <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                                <?php }else{ ?>
                                    <?php echo $row[stockticketnumber]; ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $row[conditioncode]."-".$row[partrating]; ?></td>
                            <td class="green">
                                <?php if($row[c_count] > 1){ ?>


                                        <?php if(min_mod(explode(',',$row[c_price])) != null ){ ?>
                                        <p class="vehiclee">From</p>
                                        <p class="text-tb">
                                            $<?= min_mod(explode(',',$row[c_price])); ?>
                                        </p>
                                        <?php }else{ echo '<p></p><p class="text-tb">Call</p>';} ?>

                                    <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                                <?php }else{ ?>
                                    <p class="text-tb"><?php echo $quote ; ?></p>
                                <?php } ?>
                            </td>
                            <td>
            <?php
            if ($row[directory] != "") {
                echo "<a href='$row[directory]' target=_BLANK>";
            }
            ?>
                                                <?php echo "<font color=\"#55565B\">".$row[yard]."</font>"; ?>
                                                <?php
                                                if ($row[directory] != "") {
                                                    echo "</a>";
                                                }
                                                ?><br>
                                                <?php echo $row[address]; ?>, <?php echo $row[city]; ?>
                                                , <?php echo $row[state]; ?> <?php echo $row[zip]; ?>
                                                <br><font color="red"><?php echo $row[phone]; ?></font>&nbsp;&nbsp;
                                                <?php
                                                if ($row[facebook] != "") {
                                                    echo '<a href="' . $row[facebook] . '" target="_blank"><img src="http://www.autorecyclersonline.com/images/facebook.png"></a>';
                                                }
                                                ?>

                                            </td>
                                            <td><?php echo $distance; ?></td>
                                        </tr>

        <?php } ?>
                                </tbody>
                            </table>
                            <div class="row">
                          <!--   <div style="text-align:right;">
                                <span id="btn-show">Show more</span>
                                <span id="btn-hide" style="display:none;">Hide result</span>
                            </div> -->
                                <div class="col-lg-4"><a
                                        href="?pg=<?php echo $pg - 1; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>"
                                        class="btn btn-orange btn-sm" <?php
                                        if ($pageNum == 1) {
                                            echo "style='display:none'";
                                        }
                                        ?>><i
                                            class="fa fa-arrow-left"></i> PREVIOUS PAGE</a></div>
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        <ul class="pagination">
                                            <li>
                                                <a href="?pg=<?php echo $pg - 1; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>" <?php
                                            if ($pageNum == 1) {
                                                echo "style='display:none'";
                                            }
                                            ?>>&laquo;</a>
                                            </li>
                                                <?php
                                                   for ($i = 1; $i <= $numofpages; $i++) {
                                                       ?>
                                                <li>
                                                    <a href="?pg=<?php echo $i; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>" <?php
                                                       if ($numofpages == 1) {
                                                           echo "style='display:none'";
                                                       }
                                                       ?> ><?php echo $i; ?></a>
                                                </li>
        <?php } ?>
                                            <li>
                                                <a href="?pg=<?php echo $pg + 1; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>" <?php
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
                                            href="?pg=<?php echo $pg + 1; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>"
                                            class="btn btn-orange btn-sm"> NEXT PAGE <i class="fa fa-arrow-right"></i></a></div>
                                </div>
    <?php } else { ?>
                                <h1><a href="/">Back to Main Page</a></h1>
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
                                            <h1 ng-show="submitted">Thanks!! We will contact you soon.<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h1>
                                            <ng-form  ng-show="!submitted" class="css-form" name="user_form">
                                                <!--<h1>Almost finished! Please provide your email address to receive your quote.</h1>-->
                                                <h2>Almost finished! Please provide your email address to receive your quote.</h2>
                                                <input hidden ng-model="req.id" ng-init="req.id=<?php echo $_REQUEST['reqid']; ?>">

                                                <div class="row">
    <!--                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <label>Phone</label>
                                                        <input type="tel" class="form-control input-lg"
                                                               ng-model="req.phone" required=""
                                                               placeholder="Enter a phone number"/>
                                                    </div>-->
                                                    <div class="col-xs-12">
                                                        <!--<label>E-mail</label>-->
                                                        <input type="email" class="form-control input-lg" ng-model="req.email"
                                                               placeholder="Enter a valid email address" required=""/>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-center" style="text-align:center;">
                                                            <div ng-show="user_form.$valid" ng-click="submit()" class="btn btn-orange" style="display: inline-block !important;">
                                                                Submit <i class="fa fa-arrow-right"></i>
                                                            </div>
                                                    </div>


                                                </div>
                                                <div class="row mtop10 text-center">
    <!--                                                <div ng-show="user_form.$valid" ng-click="submit()" class="btn btn-orange">
                                                        Submit <i class="fa fa-arrow-right"></i>
                                                    </div>-->
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
        </div>
    </section>
</div>
<div class="foot" style="text-align:center;margin-top:40px;"><p style="margin-left:0;"> &copy; Copyright - autorecyclersonline.com</p>
    <p style="position: relative;display: inline-block;text-align: center;margin-left:0;">FAQ | Terms & Conditions | Privacy Policy | <a href="/search/contactus.php">Contact | <a href="/search/aboutus.php">About</a></p>
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