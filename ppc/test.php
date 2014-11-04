<?

$string = "Tail Lamp,Tail Light";
$kwlist = explode(",",$string);
//echo count($kwlist);
foreach ($kwlist as $value) {
	echo $value."<br>";
}

?>