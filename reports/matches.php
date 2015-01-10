<html>
<title>Report Generator</title>
<body>
<?
$base = "iusedparts";
$user = "iusedparts";
$pass = "5huYvRDH";
$mlink = mysql_connect("192.168.200.100", "$user", "$pass") or  die('NODATA1');
mysql_select_db("$base", $mlink) or die('NODATA2');

//First need to get all active yards

$lcyards ="select yardid,yard from yards where active=1";
$lnyards = mysql_query($lcyards,$mlink);
while ($rowyards = mysql_fetch_array($lnyards)) // Yards
{
        	extract($rowyards); // Get yardid
			$dfrom = '2014-12-17';
			$dto= '2014-12-23';
?>


		Inventory Match Report for <b><? echo $yard;?></b> for the period <?=$dfrom?> through <?=$dto?><br><br>
		<table border="1">
		<th>Date</th>
		<th>Requested Part</th>
		<th># of Lookups</th>
		<th>We have it?</th>
		<th>Our Price</th>
		<th>Competitors<br>have it?</th>
		<th>Their price</th>


<?

			$lcreq = "select date,hnumber,year,make,model,part,count(distinct id) as lookups from requests where hnumber != '' and  left(date,10) >= '" . $dfrom. "' and left(date,10) <= '".$dto."' 
			group by hnumber order by date desc";
			//echo $lcreq."<br>";
			$result1= mysql_query($lcreq,$mlink);




			$totmatches = 0;
			$totrevenue= 0;
			$totcmatches = 0;

			while ($row2=mysql_fetch_array($result1)) // loop through requests
			{
			 extract($row2);
			 
			 
			 $lcinv = "select avg(retailprice) as avgprice,count(distinct inventorynumber) as matches from inventory where inventorynumber = '".$hnumber."' and  yardid= ".$yardid ." and retailprice>0";
			 $lccomp ="select avg(retailprice) as cavgprice,count(distinct inventorynumber) as cmatches from inventory where inventorynumber = '".$hnumber."' and retailprice >0 and  yardid != ".$yardid." and retailprice>0";
			//echo $lcinv."<br>";
			 $result2 = mysql_query($lcinv,$mlink);
			 $row3 = mysql_fetch_array($result2);
			 extract($row3);
			 $totmatches = $totmatches + $matches;
			 $totrevenue = $totrevenue + $avgprice;
			 if ($matches >0){$matched='Yes';}else{$matched="No";}
			 
			 $result3 = mysql_query($lccomp,$mlink);
			 $row4 = mysql_fetch_array($result3);
			 extract($row4);
			 if ($cmatches >0){$cmatched ='Yes';}else{$cmatched="No";}			 
			 if ($avgprice>0)
			 {$ourprice = "$". number_format($avgprice,2,'.',',');
			 }else{$ourprice="NA";}
			 
			 
			 if (($matched == "Yes" or $cmatched =="Yes"))
			 {
			 echo "<tr><td>".$date."</td><td>".$year." ".$make." ".$model." ".$part." (".$hnumber.")</td><td>".$lookups."</td><td>".$matched."</td><td>".$ourprice."</td><td>".$cmatched.
			 "</td><td>$".number_format($cavgprice,2,'.',',')."</td></tr>";
			 }
			}

?>			
</table>
<br><br>
Total number of customer requests:<?=mysql_num_rows($result1)?><br>
Total number of matched parts:<?=$totmatches?> for $<?=number_format($totrevenue,2,'.',',')?><br>
Number of missed opportunties:<?=mysql_num_rows($result1)-$totmatches?><br><br><br>
<p><!-- pagebreak --></p> 
<?
			
}


        

?>


</body>
</html>