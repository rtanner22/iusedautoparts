<?php
session_start();
error_reporting(0);

$response = array(
    'result' => false,
);

$types = array(
    1 => 'General question about this item',
    2 => 'Need a shipping quote',
);

$reqid = filter_input(INPUT_POST, 'reqid', FILTER_VALIDATE_INT);
$yardid = filter_input(INPUT_POST, 'yardid', FILTER_VALIDATE_INT);
$type = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9\+\-]{7,13}/i')));
$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH & FILTER_FLAG_ENCODE_HIGH);

if(!$reqid || !$yardid || !in_array($type, array_keys($types))) {
    echo json_encode($response);
    return;
}

if(!$email) {
    $response['message'] = 'No valid email address';
    echo json_encode($response);
    return;
}

if(!$phone) {
    $response['message'] = 'No valid phone number';
    echo json_encode($response);
    return;
}
if(!$text || empty($text)) {
    $response['message'] = 'Need feel text';
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

$yardResult = mysql_query("SELECT * FROM yards WHERE yardid = '{$yardid}';");
if(!$yardResult) {
    echo json_encode($response);
    return;
}

$request = mysql_fetch_assoc($requestResult);
$yard = mysql_fetch_assoc($yardResult);

$subject = $types[$type];

$clientInfo = 'Email: ' . $email . '<br/>';
$clientInfo .= 'Phone: ' . $phone . '<br/>';
$clientInfo .= 'Subject: ' . $types[$type] . '<br/>';
$clientInfo .= 'Message: ' . $text . '<br/>';

$requestInfo = 'Year: ' . $request['year'] . '<br/>';
$requestInfo .= 'Make: ' . $request['make'] . '<br/>';
$requestInfo .= 'Model: ' . $request['model'] . '<br/>';
$requestInfo .= 'Part: ' . $request['part'] . '<br/>';
$requestInfo .= 'Options: ' . $request['hollanderoption'] . '<br/>';
$requestInfo .= 'Hollander number: ' . $request['hnumber'] . '<br/>';
$requestInfo .= 'Shipping zip code: ' . $request['zip'] . '<br/>';

$results = mysql_query("SELECT inventory.*
FROM inventory 
WHERE inventory.inventorynumber = '{$request['hnumber']}' AND inventory.yardid = '{$yardid}'
ORDER BY inventory.retailprice ASC;");

$productsInfo = 'Products info:<br/>' .
    '<table style="min-width: 900px;background: #E7F9FD;margin-bottom: 20px;border: 1px solid #ddd;border-collapse: collapse;border-spacing: 0;font-family: \'Open Sans\', sans-serif;font-weight: 600;font-size: 14px;color: #55565b;line-height: 1.5em;">
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

    $productsInfo .= "<tr>";
    $productsInfo .= "<td>{$row['modelyear']} {$row['modelname']}</td>";
    $productsInfo .= "<td style=\"text-align: center;\">{$row['conditionsandoptions']}</td>";
    $productsInfo .= "<td style=\"text-align: center;\">{$row['stockticketnumber']}</td>";
    $productsInfo .= "<td style=\"text-align: center;\">{$row['conditioncode']} - {$row['partrating']}</td>";
    $productsInfo .= "<td style=\"text-align: center;\"><p style=\"text-align: center;font-weight: bold;font-size: 20px;line-height: 9px;color: black;\">{$quote}</p></td>";
    $productsInfo .= "</tr>";
}
$productsInfo .= "</table>";

$body = '<html><head></head><body>' . $requestInfo . '<br/>' . $clientInfo . '<br/>' . $productsInfo . '</body></html>';

//Send mail
require_once 'lib/swift_required.php';

// Create the Transport
$transport = Swift_MailTransport::newInstance();

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create the message
$message = Swift_Message::newInstance()

    // Give the message a subject
    ->setSubject($subject)

    // Set the From address with an associative array
    ->setFrom(array('noreply@autorecyclersonline.com' => 'AutoRecyclersOnline.com'))

    // Specifies the address where replies are sent to
    ->setReplyTo($email)

    // Set the To addresses with an associative array
    ->setTo(array($yard['contactemail']))

    // Give it a body
    ->setBody(
        $body,
        'text/html'
    );

$resultSend = $mailer->send($message);

$response['result'] = true;
echo json_encode($response);