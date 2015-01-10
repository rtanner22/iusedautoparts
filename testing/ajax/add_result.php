<?php 
register_shutdown_function( "check_for_fatal");
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );
ini_set( "display_errors", "on" );
error_reporting( E_ERROR );
ini_set('error_reporting', 'on');
ini_set("allow_url_fopen", true);
?>

<?php
if(isset($_POST['addres'])){
    if (file_exists('../inc/rb.phar')) {
        require '../inc/rb.phar';
    }
    
    function getLnt($zip) {

        $result1 = R::getAll("select lat, lng from zipcodes2 where Zipcode = '$zip' ");
        $result['lat'] = $result1[0]['lat'];
        $result['lng'] = $result1[0]['lng'];
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
    
    
    R::setup('mysql:host=192.168.200.100;dbname=iusedparts', 'iusedparts', '5huYvRDH');
    
    $result1 = R::getAll("select * from requests where id = '" . $_REQUEST['reqid'] . "' ");
    $zipcode = $result1[0]['zip'];
    $hnumber = $result1[0]['hnumber'];
    
    $lcsql ="SELECT COUNT(*) from inventory inner join yards on yards.yardid = inventory.yardid where inventory.inventorynumber = '" . $hnumber ."' order by retailprice desc " ;
    $result = R::getAll($lcsql);
    $page_row = $result[0]['COUNT(*)'];
    include("../inc/paging_admin.php");
    $rowsPerPage = 10;
    $pageNum = 1;
    if (isset($_GET['pg'])) {
        $pageNum = $_GET['pg'];
    }
    $offset = ($pageNum - 1) * $rowsPerPage;
    $pg = $pageNum;

    $numofpages = ceil($page_row / $rowsPerPage);
    
    $yai = $_POST['yardid'];
    $pagesql = "select 
    yards.yardid,yards.yard,yards.warranty,yards.address,yards.city,yards.state,yards.phone,yards.directory,yards.zip,inventory.*
    from inventory 
    inner join yards on yards.yardid = inventory.yardid 
    where inventory.inventorynumber = '" . $hnumber ."' AND yards.yardid = '".$yai."'
    order by retailprice ASC LIMIT $offset,$rowsPerPage ";
    
    $result = R::getAll($pagesql);
?>

<table class="table table-condensed">
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
<?php
foreach ($result as $row) {
    $distance = getDistance($zipcode, "$row[zip]", "M");
    $distance = sprintf("%1.1f", $distance);
    $quote = (float)$row['retailprice'];
    $mileage = $row['mileage'];
    if ($mileage > 0){
        $mileage = "(Mileage: " . number_format($mileage,0,'.',',').")";
    }
    else{
        $mileage="";
    }
    if ($quote == 0)    { $quote='Call';  }   else { $quote = '$'.(float)$row['retailprice'];}
?>
    
<tr>
    <td><?php echo $row['modelyear']; ?> <?php echo $row['modelname']; ?></td>
    <td><?php  echo "<br>". $row['conditionsandoptions'] . "<br>". $mileage ; ?></td>
    <td><?php echo $row['stockticketnumber']; ?></td>
    <td><?php echo $row['conditioncode']."-".$row['partrating']; ?></td>
    <td class="green"><p class="text-tb"><?php echo $quote ; ?></p></td>
    <td>
        <?php
            if ($row['directory'] != "") {
                echo "<a href='$row[directory]' target=_BLANK>";
            }
        ?>
        <?php echo "<font class=\"namevendor\"  color=\"#55565B\">".$row['yard']." <span></span></font>"; ?>
        <?php
            if ($row['directory'] != "") {
                echo "</a>";
            }
        ?>
        <br>
        <?php echo $row['address']; ?>, <?php echo $row['city']; ?>
        , <?php echo $row['state']; ?> <?php echo $row['zip']; ?>
        <br>
        <font color="red"><?php echo $row['phone']; ?></font>&nbsp;&nbsp;

    </td>
    <td><?php echo $distance; ?></td>
</tr>
<?php } ?>
</table>
<?php 
} else {return false;}
?>



<?php


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
?>