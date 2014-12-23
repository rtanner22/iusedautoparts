<html>
<title>Report Generator</title>
<body>
<?php
$base = "iusedparts";
$user = "iusedparts";
$pass = "5huYvRDH";
$mlink = mysql_connect("192.168.200.100", "$user", "$pass") or  die('NODATA1');
mysql_select_db("$base", $mlink) or die('NODATA2');

//First need to get all active yards
?>
Inventory Match Report for <b>Hertiage Auto Parts</b> for the period 2014-11-24 through 2014-11-28<br><br>

<table border="1">
<th>Date</th>
<th>Requested Part</th>
<th># of Lookups</th>
<th>We have it?</th>
<th>Our Price</th>
<th>Other matches</th>
<th>Other prices</th>
<?
$totmatches = 0;
$totcmatches = 0;
$lcyards ="select yardid,yard from yards where active=1 and yardid=1004";
$lnyards = mysql_query($lcyards,$mlink);
while ($rowyards = mysql_fetch_array($lnyards)) // Yards
		{
			 extract($rowyards); // Get yardid
			 
			$dfrom = '2014-11-24';
			$dto= '2014-11-28';
			$lcreq = "select date,hnumber,year,make,model,part,count(distinct id) as lookups from requests where hnumber != '' and  left(date,10) >= '" . $dfrom. "' and left(date,10) <= '".$dto."' group by hnumber order by make,model";
			//echo $lcreq."<br>";
			$result1= mysql_query($lcreq,$mlink);




	
			while ($row2=mysql_fetch_array($result1)) // loop through requests
			{
			 extract($row2);
			 
			 
			 $lcinv = "select avg(retailprice) as avgprice,count(distinct inventorynumber) as matches from inventory where inventorynumber = '".$hnumber."' and  yardid= ".$yardid ." and retailprice>0";
			 $lccomp ="select avg(retailprice) as cavgprice,count(distinct inventorynumber) as cmatches from inventory where inventorynumber = '".$hnumber."' and  yardid!= ".$yardid." and retailprice>0";
			//echo $lcinv."<br>";
			 $result2 = mysql_query($lcinv,$mlink);
			 $row3 = mysql_fetch_array($result2);
			 extract($row3);
			 $totmatches = $totmatches + $matches;
			 if ($matches >0){$matched='Yes';}else{$matched="No";}
			 
			 $result3 = mysql_query($lccomp,$mlink);
			 $row4 = mysql_fetch_array($result3);
			 extract($row4);
			 
			 echo "<tr><td>".$date."</td><td>".$year." ".$make." ".$model." ".$part." (".$hnumber.")</td><td>".$lookups."</td><td>".$matched."</td><td>".number_format($avgprice,2,'.',',')."</td><td>".$cmatches."</td><td>".number_format($cavgprice,2,'.',',')."</td></tr>";
			}
		}


        

?>

</table>
Total number of customer requests:<?=mysql_num_rows($result1)?><br>
Total number of matched parts:<?=$totmatches?><br>
Number of missed opportunties:<?=mysql_num_rows($result1)-$totmatches?><br>
</body>
</html>