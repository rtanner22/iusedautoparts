
<?
include_once('includes/config.php');
include_once('includes/db.class.php');
include_once('mfrcodes.php');
$db_obj = new DB();
?>
<style type="text/css">
* { font-size: 12px; }
</style>

<table border=1>
<tr>
	<TD>Campaign</TD>
	<TD>AdGroup</TD>    
	<TD nowrap> Keyword </TD>
	<TD>Type</TD>    
	<TD>MaxCPC</TD>    
	<TD>DisplayURL</TD>
	<TD>DestURL</TD>
	<TD> Keyword Status </TD>
</tr>
<?

$sql = "SELECT a.VPartID as id ,HSId as Hollander,left(trim(HSId),3) as Part,c.Vmake Make,d.Vmodel Model 
		FROM TabVParts a, TabVehicle b,xTabVMake c, xTabVModel d WHERE a.VEStockID = b.VVendorStockID AND c.VMakeID=d.VMakeID AND b.VModelID=d.VModelID  AND b.VMakeID=d.VMakeID 
		AND  a.VPartPrice > 0 AND a.Flag=0 AND a.Vid=5001 Group BY Vmake,Vmodel,Part ";
$res=$db_obj->query($sql);
while ( $row = $db_obj->fetcharray($res) )
{
	extract($row);
	
	$getsql = "SELECT AphMake,AphModel,aUrl FROM xTabMakeModelRef WHERE HModel='$Model' ";
	$getres=$db_obj->query($getsql);
	list($AphMake,$AphModel,$aUrl)=$db_obj->fetcharray($getres);


	$getsql1 = "SELECT PartKw,PartUrl  FROM xTabPartRef WHERE PartCode='$Part' ";
	$getres1=$db_obj->query($getsql1);
	while ( $row1= $db_obj->fetcharray($getres1))
	{
		//list($PartKw,$PartUrl)=$db_obj->fetcharray($getres1);
		extract($row1);
		$sUrl = "http://autopartshub.com/$AphMake".".html";
		$sUrl1 = "http://autopartshub.com/".$aUrl."_".$PartUrl.".html";
		$sUrl2 = "http://autopartshub.com/".$aUrl.".html";
	
		$LandingUrl1="http://autopartshub.com/aphlanding.php?make=".$AphMake;
		$LandingUrl2="http://autopartshub.com/aphlanding.php?make=".$AphMake."&model=".$AphModel;
		$LandingUrl4="http://autopartshub.com/aphlanding.php?make=".$AphMake."&Part=".$PartKw;
		$LandingUrl3="http://autopartshub.com/aphlanding.php?make=".$AphMake."&model=".$AphModel."&Part=".$PartKw;
		
		$sl++;
	
		
		//Make Model and Part
		$Array[$LandingUrl3]=$sUrl1;
		// Make and Part
		$Array[$LandingUrl4]=$sUrl;

	}	
	
	$usql = "UPDATE TabVParts SET Flag='1' WHERE VPartID='$id' ";
	//$db_obj->query($usql);
}
//print "<pre>";
//array_unique($Array);
//print_r($Array);
$sl=0;
foreach($Array as $key => $value)
{
	$sl++;

	if(substr(trim($value), -6)=='_.html')
	{
		continue;
	}
	$handle =explode("?",$key);
	$handle1 = $handle[1];
	$Campaign = str_replace("make=","",$handle1);
	$Campaign = str_replace("&model="," ",$Campaign);
	$Campaign = str_replace("&Part="," ",$Campaign);
	$Campaign=str_replace(" "," +",$Campaign);
	$Campaign="+" . $Campaign;
	$Adgroup = str_replace("+","",$Campaign);
?>
	<tr>
	<!--		<td><?=$sl ;?></td>-->
   			<td>5001-All Foreign</td>
			<td><?=$Adgroup?></td>
			<td><?=$Campaign?></td>
			<td>Broad</td>
            <td>0.15</td>
			<td><?=$value?></td>
			<td><?=$key?></td>
			<td>Active</td>
		</tr>
<?
}

?>
</table>
