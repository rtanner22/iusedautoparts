<?php
session_start();
date_default_timezone_set('America/Chicago');
$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host = "192.168.200.100";
$mlink = mysql_connect($mdb_host, $mdb_username, $mdb_password);
mysql_select_db("$mdb_database", $mlink);

extract($_POST);
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');
$source = "";

$interchange = explode("|", $interchange);
$hollanderoption = explode(";", $hollanderoption);
$hollanderoption = "[" . implode(",", $hollanderoption) . "]";

if (isset($_POST['mechanics'])) {
    $wantsrepair = 1;
} else {
    $wantsrepair = 0;
}

$sql = "insert into requests (date,udate,year,make,model,part,hnumber,hollanderoption,phone,zip,email,source,referrer,kw,se,ip,wantsrepair) values('$date',unix_timestamp(),'$year','$make','$model','$partname','$interchange[2]','" . mysql_real_escape_string($hollanderoption) . "','$phone','$zip','$email','$source','$_SESSION[referrer]','$_SESSION[kw]','$_SESSION[se]','$ip','$wantsrepair')";
$que = mysql_query($sql) or die(mysql_error());
if ($que) {
    $requestid = mysql_insert_id();
    try {
        // Insert data to table inventory_r with timestamp
        if (isset($interchange[2])) {
            mysql_query("INSERT INTO inventory_r (`yardid`,`inventoryid`,`requestid`,`inventorynumber`,`quantityavailable`,`stockticketnumber`,`modelyear`,`modelname`,`conditionsandoptions`,`mileage`,`conditioncode`,`partrating`,`wholesaleprice`,`retailprice`,`timestamp`) SELECT yardid,inventoryid,'{$requestid}' AS requestid,inventorynumber,quantityavailable,stockticketnumber,modelyear,modelname,conditionsandoptions,mileage,conditioncode,partrating,wholesaleprice,retailprice,NOW() FROM inventory WHERE inventorynumber = '" . $interchange[2] . "';");
        }
    } catch (Exception $exc) {};

    echo $requestid;
}