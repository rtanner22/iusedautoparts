<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

date_default_timezone_set('America/Chicago');

//Send mail
require_once 'lib/swift_required.php';

// Create the Transport
$transport = Swift_MailTransport::newInstance();

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

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

$requestResult = mysql_query("SELECT * FROM requests WHERE id = '{$reqid}';");
if(!$requestResult) {
    echo json_encode($response);
    return;
}
$request = mysql_fetch_assoc($requestResult);

$que = mysql_query("INSERT INTO `request_save` (`requestid`,`hnumber`,`yardid`,`email`,`created_at`) VALUES('{$reqid}','{$hnumber}','{$yardid}','{$email}',NOW());");
if ($que) {
    $response['result'] = true;
    echo json_encode($response);

    $subject = '';
    if($yardid) {
        $yardResult = mysql_query("SELECT * FROM yards WHERE yardid = '{$yardid}';");
        if (!$yardResult) {
            return;
        }
        $yard = mysql_fetch_assoc($yardResult);
        //Fix email address
        $yard['partsemail'] = trim($yard['partsemail']);

        $dealerInfo = '';
        if ($yard['directory'] != "") {
            $dealerInfo .= "<a href='{$yard['directory']}' target=_BLANK>";
        }
        $dealerInfo .=  "<font color=\"#55565B\">".$yard['yard']."</font>";
        if ($yard['directory'] != "") {
            $dealerInfo .=  "</a>";
        }
        $dealerInfo .= "<br/>";
        $dealerInfo .= "{$yard['address']}, {$yard['city']}, {$yard['state']}, {$yard['zip']}";
        $dealerInfo .= "<br/><font color=\"red\">{$yard['phone']}</font>&nbsp;&nbsp;";
        if ($yard['facebook'] != "") {
            $dealerInfo .= '<a href="' . $yard['facebook'] . '" target="_blank"><img src="' . $_SERVER['SERVER_NAME'] . '/images/facebook.png"></a>';
        }

        $requestInfo = 'Year: ' . $request['year'] . '<br/>';
        $requestInfo .= 'Make: ' . $request['make'] . '<br/>';
        $requestInfo .= 'Model: ' . $request['model'] . '<br/>';
        $requestInfo .= 'Part: ' . $request['part'] . '<br/>';
        $requestInfo .= 'Options: ' . $request['hollanderoption'] . '<br/>';

        $results = mysql_query("SELECT inventory.*
        FROM inventory 
        WHERE inventory.inventorynumber = '{$hnumber}' AND inventory.yardid = '{$yardid}'
        ORDER BY inventory.retailprice ASC;");
        if (!$results) {
            return;
        }

        $body = 'Search info:<br/>Just press reply to ask any questions from this vendor or call them at the number below!<br/>' . $requestInfo . '<br/>Dealer Info<br/>' . $dealerInfo . '<br/>';
        $table = '<table style="min-width: 900px;background: #E7F9FD;margin-bottom: 20px;border: 1px solid #ddd;border-collapse: collapse;border-spacing: 0;font-family: \'Open Sans\', sans-serif;font-weight: 600;font-size: 14px;color: #55565b;line-height: 1.5em;">
                <tr>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Donor Vehicle</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;" width="60px">Part/Options</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Stock #</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #355F79;color: #FFF;text-align: center;">Grade</th>
                    <th style="height: 40px;border-top: 1px solid #ddd;line-height: 1.42857143;background: #69b338;color: #FFF;text-align: center;">Price</th>
                </tr>';
        $priceArray = array();
        while ($row = mysql_fetch_assoc($results)) {
            $priceArray[] = (float)$row['retailprice'];
            $quote = (float)$row['retailprice'];
            if ($quote == 0) { $quote='Call'; } else { $quote = '$'.(float)$row['retailprice']; }

            //Stock number for mail subject
            $sNumber = $row['stockticketnumber'];
            
            $table .= "<tr>";
            $table .= "<td>{$row['modelyear']} {$row['modelname']}</td>";
            $table .= "<td style=\"text-align: center;\">{$row['conditionsandoptions']}</td>";
            $table .= "<td style=\"text-align: center;\">{$row['stockticketnumber']}</td>";
            $table .= "<td style=\"text-align: center;\">{$row['conditioncode']} - {$row['partrating']}</td>";
            $table .= "<td style=\"text-align: center;\"><p style=\"text-align: center;font-weight: bold;font-size: 20px;line-height: 9px;color: black;\">{$quote}</p></td>";
            $table .= "</tr>";
        }
        $table .= "</table>";

        $body .= $table;

        $priceArray = array_unique($priceArray);

        $subject = "Re: {$yard['yard']} {$yard['phone']} current inventory for your {$request['year']},{$request['make']},{$request['model']},{$request['part']}";

        if(!empty($yard['partsemail'])) {
            //sent to yard email
            $message = Swift_Message::newInstance()

                // Give the message a subject
                ->setSubject('Re: Item was saved # ' . $sNumber. ' - ' .$a. ' ' .$request['year']. ' ' .$request['make']. ' ' .$request['model']. ' ' . $request['part'])

                // Set the From address with an associative array
                ->setFrom(array('noreply@autorecyclersonline.com' => $email))

                // Copy to site holder
                ->addBcc('admin@autorecyclersonline.com')

                // Specifies the address where replies are sent to
                ->setReplyTo($email)

                //Setting the Return-Path
                ->setReturnPath($email)

                // Set the To addresses with an associative array
                ->setTo(array($yard['partsemail']))

                // Give it a body
                ->setBody(
                    '<html><head></head><body>Below are the details. You can reply to this email to contact customer:<br/><br/>'
                        . 'Part: ' . $request['part'] . '<br/>'
                        . (count($priceArray) ? 'Price: ' . ((count($priceArray) == 1) ? $priceArray[0] : min($priceArray) . ' - ' . max($priceArray)) : '')
                        . '<br/><br/>'
                        . 'Customer Zip: ' . $request['zip'] . '<br/>'
                        . 'Customer Phone: ' . $request['phone'] . '<br/>'
                        . 'Customer Firstname: ' . $request['firstname'] . '<br/>'
                        . 'eMail: ' . $email . '<br/>'
                        . '<br/><br/>'
                        . $table
                        . '<br/>'
                        . ' Hollander number: ' . $hnumber
                        . '<br/>'
                        . 'AutoRecyclersOnline.com Team'
                        . '</body></html>',
                    'text/html'
                );

            $mailer->send($message);
        }
    } else {
        $subject = "Re: Your Saved Part Search from AutoRecyclersOnline.com";
        $body = 'Your search result ' . $_SERVER['SERVER_NAME'] . '/inventory?reqid=' . $reqid . '';
    }

    $body = '<html><head></head><body>' . $body . '</body></html>';

    // Create the message
    $message = Swift_Message::newInstance()

        // Give the message a subject
        ->setSubject($subject)

        // Set the From address with an associative array
        ->setFrom(array('noreply@autorecyclersonline.com' => (!empty($yard['partsemail']) ? $yard['partsemail'] :'AutoRecyclersOnline.com')))

        // Copy to site holder
        ->addBcc('admin@autorecyclersonline.com')

        // Set the To addresses with an associative array
        ->setTo(array($email))

        // Give it a body
        ->setBody(
            $body,
            'text/html'
        );

    if(!empty($yard['partsemail'])) {
        // Specifies the address where replies are sent to
        $message->setReplyTo($yard['partsemail'])->setReturnPath($yard['partsemail']);
    }

    $resultSend = $mailer->send($message);
} else {
    echo json_encode($response);
}