<?php
session_start();
error_reporting(0);

$response = array(
    'result' => false,
);

$reqid = filter_input(INPUT_POST, 'reqid', FILTER_VALIDATE_INT);
$yardid = filter_input(INPUT_POST, 'yardid', FILTER_VALIDATE_INT);
$hnumber = filter_input(INPUT_POST, 'hnumber', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if(!$reqid || !$hnumber) {
    echo json_encode($response);
    return;
}

if(!$email) {
    $response['message'] = 'No valid email address';
    echo json_encode($response);
    return;
}

$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host = "192.168.200.100";
$mlink = mysql_connect($mdb_host, $mdb_username, $mdb_password);
mysql_select_db("$mdb_database", $mlink);
$sql = "INSERT INTO `request_save` (`requestid`,`hnumber`,`email`,`created_at`) VALUES('{$reqid}','{$hnumber}','{$email}',NOW());";

$que = mysql_query($sql) or die(mysql_error());
if ($que) {
    $response['result'] = true;
    echo json_encode($response);

    if($yardid) {
        $yardResult = mysql_query("SELECT * FROM yards WHERE yardid = '{$yardid}';");
        if (!$yardResult) {
            return;
        }
        $yard = mysql_fetch_assoc($yardResult);
        $dealerInfo = '';
        if ($yard['directory'] != "") {
            $dealerInfo .= "<a href='{$yard['directory']}' target=_BLANK>";
        }
        $dealerInfo .=  "<font color=\"#55565B\">".$yard['yard']."</font>";
        if ($yard['directory'] != "") {
            $dealerInfo .=  "</a>";
        }
        $dealerInfo .= "<br>";
        $dealerInfo .= "{$yard['address']}, {$yard['city']}, {$yard['state']}, {$yard['zip']}";
        $dealerInfo .= "<br><font color=\"red\">{$yard['phone']}</font>&nbsp;&nbsp;";
        if ($yard['facebook'] != "") {
            $dealerInfo .= '<a href="' . $yard['facebook'] . '" target="_blank"><img src="' . $_SERVER['SERVER_NAME'] . '/images/facebook.png"></a>';
        }

        $results = mysql_query("SELECT inventory.*
        FROM inventory 
        WHERE inventory.inventorynumber = '{$hnumber}' AND inventory.yardid = '{$yardid}'
        ORDER BY inventory.retailprice ASC;");
        if (!$results) {
            return;
        }

        $body = 'Dealer Info<br/>' . $dealerInfo . '<br>' .
            '<table style="min-width: 900px;background: #E7F9FD;margin-bottom: 20px;">
                <tr>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Donor Vehicle</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;" width="60px">Part/Options</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Stock #</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Grade</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #69b338;color: #FFF;text-align: center;">Price</th>
                </tr>';
        while ($row = mysql_fetch_assoc($results)) {
            $quote = (float)$row['retailprice'];
            if ($quote == 0) { $quote='Call'; } else { $quote = '$'.(float)$row['retailprice']; }

            $body .= "<tr>";
            $body .= "<td>{$row['modelyear']} {$row['modelname']}</td>";
            $body .= "<td style=\"text-align: center;\">{$row['conditionsandoptions']}</td>";
            $body .= "<td style=\"text-align: center;\">{$row['stockticketnumber']}</td>";
            $body .= "<td style=\"text-align: center;\">{$row['conditioncode']} - {$row['partrating']}</td>";
            $body .= "<td style=\"text-align: center;\"><p style=\"text-align: center;font-weight: bold;font-size: 20px;line-height: 9px;color: black;\">{$quote}</p></td>";
            $body .= "</tr>";
        }
        $body .= "</table>";
    } else {
        $body = 'Your search result ' . $_SERVER['SERVER_NAME'] . '/inventory?reqid=' . $reqid . '';
    }

    $body = '<html><head></head><body>' . $body . '</body></html>';

    //Send mail
    require_once 'lib/swift_required.php';

    // Create the Transport
    $transport = Swift_MailTransport::newInstance();

    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create the message
    $message = Swift_Message::newInstance()

        // Give the message a subject
        ->setSubject('')

        // Set the From address with an associative array
        ->setFrom(array('noreply@autorecyclersonline.com' => 'iUsedAutoParts'))

        // Set the To addresses with an associative array
        ->setTo(array($email))

        // Give it a body
        ->setBody(
            $body,
            'text/html'
        );

    $resultSend = $mailer->send($message);
} else {
    echo json_encode($response);
}