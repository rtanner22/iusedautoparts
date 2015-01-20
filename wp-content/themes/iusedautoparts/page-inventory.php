<?php
session_start();
/*
  Template Name: Page Inventory
 */
date_default_timezone_set('America/Chicago');

if (file_exists('testing/inc/rb.phar')) {
    require 'testing/inc/rb.phar';
}
ini_set('error_reporting', 'on');
ini_set("allow_url_fopen", true);

R::setup('mysql:host=192.168.200.100;dbname=iusedparts', 'iusedparts', '5huYvRDH');

//function min_mod () {
//  $args = func_get_args();
//  if (!count($args[0])) return false;
//  else {
//    $minVal = 1;
//    foreach ($args[0] as $value) {
//        if($value === 0){$minVal = 0;}
//        else if ($value < $minVal) {
//            $minVal = floatval($value);
//        }
//        else {
//            $minVal = 0;
//        }
//    }
//  }
//  return $minVal;
//}
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
if(isset($_SESSION['email_data'])) {
    $email = $_SESSION['email_data'];
} else {
    $email = $result1[0]['email'];
}
############################ Paging variables ########################
include("testing/inc/paging_admin.php");

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
yards.*,inventory.*
FROM inventory
INNER JOIN yards on yards.yardid = inventory.yardid
WHERE inventory.inventorynumber = '" . $hnumber ."'
GROUP by yards.yard
ORDER by retailprice DESC LIMIT $offset,$rowsPerPage;";

$result = R::getAll($pagesql);
$page_row = R::getCell('SELECT FOUND_ROWS();');
$pg = $pageNum;
$numofpages = ceil($page_row / $rowsPerPage);
?>
<?php get_header(); ?>
<?php get_template_part('banner', 'inventory'); ?>
<style>.hide {
display: none;
}</style>
<script type="text/javascript">
//    $.loader({
//        className: 'blue-with-image-12',
//        content: 'Please wait while page loading...'
//    });
//    $(document).ready(function() {
//        $.loader('close');
//    });
</script>
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
<section id="content">
    <div class="wrap alt">
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
                                    <th>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRequestSaveAll">Save All</button>
                                    </th>
                                    <th>
                                        Mail
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
        if ($quote == 0) { $quote='Call';} else { $quote = '$'.(float)$row['retailprice'];}
        ?>
                    <tr>
                        <td>
                            <?php if($row['c_count'] > 1){ ?>
                                <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                            <?php }else{ ?>
                                <?php echo $row['modelyear']; ?> <?php echo $row['modelname']; ?>
                            <?php } ?>
                        </td>
                        <td><?php  echo $mainresult[0]['part'] ."<br>". $row['conditionsandoptions'] . "<br>". $mileage ; ?></td>
                        <td>
                            <?php if($row['c_count'] > 1) { ?>
                                <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                            <?php } else { ?>
                                <?php echo $row['stockticketnumber']; ?>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['conditioncode']."-".$row['partrating']; ?></td>
                        <td class="green">
                            <?php if($row['c_count'] > 1) { ?>


                                    <?php if(min_mod(explode(',',$row['c_price'])) != null ){ ?>
                                    <p class="vehiclee">From</p>
                                    <p class="text-tb">
                                        $<?= min_mod(explode(',',$row['c_price'])); ?>
                                    </p>
                                    <?php }else{ echo '<p></p><p class="text-tb">Call</p>';} ?>

                                <p class="vehicle" data-request="<?= htmlspecialchars(json_encode($_REQUEST));?>" data-id="<?= $row['yardid'] ?>">View All</p>
                            <?php } else { ?>
                                <p class="text-tb"><?php echo $quote ; ?></p>
                            <?php } ?>
                        </td>
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
                                echo '<a href="' . $row[facebook] . '" target="_blank"><img src="/images/facebook.png"></a>';
                            }
                            ?>
                        </td>
                        <td><?php echo $distance; ?></td>
                        <td class="text-center"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRequestSave" data-yardid="<?= $row['yardid'] ?>">Save</button></td>
                        <?php if($row['contactemail']): ?>
                        <td class="text-center"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRequestSend" data-yardid="<?= $row['yardid'] ?>"><img style="width: 20px;" src="/images/email.png"></button></td>
                        <?php endif; ?>
                    </tr>
    <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
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

                            <!-- Large modal -->
                            <div class="modal fade" tabindex="-1" role="dialog" id="modalRequestSave" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class = "modal-body">
                                            <h1 class="submitted hidden">Thanks!! We will contact you soon.<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h1>
                                            <form class="css-form" action="/scripts/request_save.php" method="POST" onsubmit="return false;">
                                                <h2>Please provide your email address to receive dealer information.</h2>
                                                <input type="hidden" name="reqid" value="<?= $_REQUEST['reqid'] ?>" />
                                                <input type="hidden" name="hnumber" value="<?= $hnumber ?>" />
                                                <input type="hidden" name="yardid" value="" />

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <input type="email" class="form-control input-lg" name="email" placeholder="Enter a valid email address" required />
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-center" style="text-align:center;">
                                                        <button class="btn btn-orange" style="display: inline-block !important;">
                                                            Submit <i class="fa fa-arrow-right"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="row mtop10 text-center"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Large modal -->
                            <div class="modal fade" tabindex="-1" role="dialog" id="modalRequestSend" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class = "modal-body">
                                            <h1 class="submitted hidden">Thanks!! We will contact you soon.<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h1>
                                            <form class="css-form" action="/scripts/request_send.php" method="POST" onsubmit="return false;">
                                                <h2>Please provide information to send to dealer.</h2>
                                                <input type="hidden" name="reqid" value="<?= $_REQUEST['reqid'] ?>" />
                                                <input type="hidden" name="yardid" value="" />

                                                <div class="row">
                                                    <div class="form-group col-xs-12">
                                                        <select class="form-control input-lg" name="type" tabindex="1">
                                                            <option value="1">General question about this item</option>
                                                            <option value="2">Need a shipping quote</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <textarea class="form-control input-lg" name="text" rows="6" tabindex="2" required></textarea>
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <input type="email" class="form-control input-lg" name="email" placeholder="Enter a valid email address" tabindex="3" required />
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <input type="tel" class="form-control input-lg" name="phone" placeholder="Enter a valid phone number" tabindex="4" />
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-center" style="text-align:center;">
                                                        <button class="btn btn-orange" style="display: inline-block !important;" tabindex="5">
                                                            Submit <i class="fa fa-arrow-right"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="row mtop10 text-center"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Large modal -->
                            <div class="modal fade" tabindex="-1" role="dialog" id="modalRequestSaveAll" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class = "modal-body">
                                            <h1 class="submitted hidden">Thanks!! We will contact you soon.<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h1>
                                            <form class="css-form" action="/scripts/request_save.php" method="POST" onsubmit="return false;">
                                                <h2>Please provide your email address to receive link to this page.</h2>
                                                <input type="hidden" name="reqid" value="<?= $_REQUEST['reqid'] ?>" />
                                                <input type="hidden" name="hnumber" value="<?= $hnumber ?>" />

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <input type="email" class="form-control input-lg" name="email" placeholder="Enter a valid email address" required />
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-center" style="text-align:center;">
                                                        <button class="btn btn-orange" style="display: inline-block !important;">
                                                            Submit <i class="fa fa-arrow-right"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="row mtop10 text-center"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php } else { ?>
                            
                            <p>Currently the part you requested is out of stock. If it becomes available we will let you know!</p>
                            <p style="padding-bottom:463px;display: table">To search for another part, just use the form above</p>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if((!isset($_GET['reqid']) && empty($email)) || empty($email)): ?>
                        <button style="display: none;" id ="triggerModal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function (event) {
                                var button = document.getElementById("triggerModal");
                                button.click();
                                
                            });
                            $(document).ready(function() {
                                $('.bs-example-modal-lg').on('show.bs.modal', function (event) {
                                    $(document.body).addClass('modalBlur');
                                });
                                $('.bs-example-modal-lg').on('hidden.bs.modal', function (event) {
                                    $(document.body).removeClass('modalBlur');
                                });
                            });
                        </script>
                        <!-- Large modal -->
                        <div class="modal fade bs-example-modal-lg no-results" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div ng-app="App">
                                  <div class = "modal-body" ng-controller="Controller">
                                    <!--<h1 ng-show="submitted"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h1>-->
                                    
                                    <ng-form  ng-show="!submitted" class="css-form" name="user_form">
                                        <h2 style="padding-bottom: 10px;">Almost finished! Please provide your email address to receive your quote.</h2>
                                        <input hidden ng-model="req.id" ng-init="req.id=<?php echo $_REQUEST['reqid']; ?>">
                                        <input hidden ng-model="req.refresh" ng-init="req.refresh=<?= (($result && empty($email)) ? 1 : 0) ?>">

                                        <div class="row" style="padding: 10px;">
                                            <input type="email" class="form-control input-lg" value="<?php echo $email; ?>" ng-model="req.email" placeholder="Enter a valid email address" id="email_isset" required />
                                            <p ng-show="error" class="error_email_valid">Invalid email address.</p>
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
<?php endif; ?>
<?php get_footer(); ?>