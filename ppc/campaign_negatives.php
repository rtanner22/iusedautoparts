<?
include_once('includes/config.php');
include_once('includes/db.class.php');
include_once('mfrcodes.php');
$db_obj = new DB();
?>
<style type="text/css">
* { font-size: 12px; }
</style>

<?

$sqlq = "truncate table negatives";
$res = mysql_query($sqlq);

				
/*$sql = "SELECT distinct a.VPartID as id ,HSId as Hollander,left(trim(HSId),3) as Part,c.Vmake Make,d.Vmodel Model 
		FROM TabVParts a, TabVehicle b,xTabVMake c, xTabVModel d WHERE a.VEStockID = b.VVendorStockID AND c.VMakeID=d.VMakeID AND b.VModelID=d.VModelID  AND b.VMakeID=d.VMakeID 
		AND  a.VPartPrice > 0 AND a.Flag=0 AND a.Vid=5001 Group BY Make,Part,Model";
*/

$sql = "SELECT  distinct e.Aphmake as AphMake,left(trim(HSId),3) as Part
		FROM TabVParts a, TabVehicle b,xTabVMake c, xTabVModel d,xTabMakeModelRef e WHERE
 a.VEStockID = b.VVendorStockID
 AND c.VMakeID=d.VMakeID 
AND b.VModelID=d.VModelID  
AND b.VMakeID=d.VMakeID 
AND e.HModel=d.VModel
		AND  a.VPartPrice > 0 AND a.Flag=0 AND a.Vid=5001";

$res=$db_obj->query($sql);
while ( $row = $db_obj->fetcharray($res) )

{
	extract($row);
	// Now we have the make for that model. Now get all models for that make and loop through them
		$getsqlmods = "SELECT distinct trim(AphModel) as AphModel FROM xTabMakeModelRef WHERE AphMake='$AphMake'";
		$getresmods=$db_obj->query($getsqlmods);


		while ( $row1 = $db_obj->fetcharray($getresmods) )
			{
				extract($row1);
				//we have model now
				$getsql2 = "SELECT distinct PartKw FROM xTabPartRef WHERE PartCode='$Part'";
				$getres2=$db_obj->query($getsql2);
				while ($row2 = $db_obj->fetcharray($getres2))
				{
					extract($row2);
					$PartKw = trim($PartKw);
					$negatives = "-". trim($AphModel);
					$camp = '5001-All Foreign';
					$Adgroup =$AphMake.' '.$PartKw;
					//echo $camp." " .$Adgroup." ".$negatives." Phrase<br>";
					
					$sqli = "insert into negatives (campaign,Adgroup,negative,type) values 
					('$camp','$Adgroup','$negatives','Phrase')";
				
					$ires = mysql_query($sqli);
					
				}

	}

}

?>

