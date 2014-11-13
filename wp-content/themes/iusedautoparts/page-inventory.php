<?php
/*
  Template Name: Page Inventory
 */
if (file_exists('testing/inc/rb.phar')) {
    require 'testing/inc/rb.phar';
}
ini_set('error_reporting', 'on');
ini_set("allow_url_fopen", true);
//echo ini_get("allow_url_fopen");

R::setup('mysql:host=qs3505.pair.com;dbname=rtanner2_cpl', 'rtanner2_38', 'e9!R7a03raa');

function getLnt($zip) {

    $result1 = R::getAll("select lat, lng from zipcodes2 where Zipcode = '$zip' ");
    $result['lat'] = $result1[0][lat];
    $result['lng'] = $result1[0][lng];
    //die($result['lng']);
//$result['lat'] = 0.0;
//$result['lng'] = 0.0;
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

if (!isset($_REQUEST['order_by'])) {
    $order_by = "quote";
} else {
    $order_by = $_REQUEST['order_by'];
}
$result1 = R::getAll("select * from requests where id = '" . $_REQUEST['reqid'] . "' ");
$zipcode = $result1[0][zip];
$result = R::getAll("select yards.yard,yards.warranty,yards.phone,yards.directory,yards.zip,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =     quotes.leadid where quotes.done = 0 and leadid = '" . $_REQUEST['reqid'] . "' order by " . $order_by . " desc ");

############################ Paging variables ########################
include("testing/inc/paging_admin.php");
$rowsPerPage = 20;

//$_SESSION['rowsPerPage']=$rowsPerPage;
$_SESSION['page_r'] = $_REQUEST['pg'];
$pageNum = 1;
if (isset($_GET['pg'])) {
    $pageNum = $_GET['pg'];
}
$offset = ($pageNum - 1) * $rowsPerPage;
$pg = $pageNum;

$page_row = count($result);
$numofpages = ceil($page_row / $rowsPerPage);
$selfurl = "?"; //paging URL
//============================================================================

$result = R::getAll("select yards.yard,yards.warranty,yards.address,yards.city,yards.state,yards.zip,yards.phone,yards.directory,yards.zip,yards.facebook,requests.email,requests.year,requests.make,requests.model as umodel,requests.part,requests.hollanderoption,quotes.* from quotes inner join yards on yards.yardid = quotes.yardid inner join requests on requests.id =     quotes.leadid where quotes.done = 0 and leadid = '" . $_REQUEST['reqid'] . "'  order by " . $order_by . " desc  LIMIT $offset, $rowsPerPage ");
?>

<?php get_header(); ?>
<?php get_template_part('banner', 'inventory'); ?>
<section id="content">
    <div class="wrap alt">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php if ($result) { ?>
                        <h1>Here's what we've found based on your search...<?php //echo $_REQUEST['reqid'];  ?></h1>
                        <!--<p>Click on a heading to re-sort the results.</p>-->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Donor Vehicle</th>
                                    <th>Part/Options</th>
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
        //echo $row[zip];
        ?>
                                    <tr>
                                        <td><?php echo $row[year]; ?> <?php echo $row[model]; ?></td>
                                        <td><?php echo $row[part]; ?><br><?php echo $row[options]; ?></td>
                                        <td><?php echo $row[stocknumber]; ?></td>
                                        <td><?php echo $row[rating]; ?></td>
                                        <td class="green">$<?php echo $row[quote]; ?></td>
                                        <td>
        <?php
        if ($row[directory] != "") {
            echo "<a href='$row[directory]' target=_BLANK>";
        }
        ?>
                                            <?php echo $row[yard]; ?>
                                            <?php
                                            if ($row[directory] != "") {
                                                echo "</a>";
                                            }
                                            ?><br>
                                            <?php echo $row[address]; ?>, <?php echo $row[city]; ?>
                                            , <?php echo $row[state]; ?> <?php echo $row[zip]; ?>
                                            <br><?php echo $row[phone]; ?>&nbsp;&nbsp;
                                            <?php
                                            if ($row[facebook] != "") {
                                                echo '<a href="' . $row[facebook] . '" target="_blank"><img src="http://www.iusedautoparts.com/images/facebook.png"></a>';
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
                                    href="?pg=<?php echo $pg - 1; ?>&reqid=<?php echo $_REQUEST['reqid']; ?>"
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
                                                    <h1>Sorry, no results a found for your query.</h1>
                                                    <p>Please, provide your contact information and we will contact you as soon as the part you are looking for is available.</p>
                                                    <input hidden ng-model="req.id" ng-init="req.id =<?php echo $_REQUEST['reqid']; ?>">
                                                    <div class="row">
                                                        <!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                            <label>Phone</label>
                                                            <input type="tel" class="form-control input-lg"
                                                                   ng-model="req.phone" required=""
                                                                   placeholder="Enter a phone number"/>
                                                                                                        </div>-->
                                                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                                            <label>E-mail</label>
                                                            <input type="email" class="form-control input-lg" ng-model="req.email"
                                                                   placeholder="Enter a valid email address" required=""/>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                            <div ng-show="user_form.$valid" ng-click="submit()" class="btn btn-orange btn-contactlater">
                                                                Submit <i class="fa fa-arrow-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ng-form>
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
<?php get_footer(); ?>