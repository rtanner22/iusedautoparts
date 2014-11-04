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
<!--
<tr>
	<TD>SL# </TD>
	<TD nowrap> Keyword </TD>
	<TD> Max CPC </TD>
	<TD> Destination URL </TD>
	<TD> Landing URL </TD>
	<TD> Keyword Status </TD>
</tr>
-->

<?

$sql = "SELECT a.VPartID as id ,HSId as Hollander,left(trim(HSId),3) as Part,c.Vmake Make,d.Vmodel Model 
		FROM TabVParts a, TabVehicle b,xTabVMake c, xTabVModel d WHERE a.VEStockID = b.VVendorStockID AND c.VMakeID=d.VMakeID AND b.VModelID=d.VModelID  AND b.VMakeID=d.VMakeID 
		AND  a.VPartPrice > 0 AND a.Flag=0 AND a.Vid=5001 Group BY Make,Model,Part";
$res=$db_obj->query($sql);


while ( $row = $db_obj->fetcharray($res) )
{
	extract($row);
	
	$getsql = "SELECT AphMake,AphModel,aUrl FROM xTabMakeModelRef WHERE HModel='$Model' ";
	$getres=$db_obj->query($getsql);
	list($AphMake,$AphModel,$aUrl)=$db_obj->fetcharray($getres);

	$getsql1 = "SELECT PartKw,PartUrl  FROM xTabPartRef WHERE PartCode='$Part' ";
	$getres1=$db_obj->query($getsql1);
	while ($row1 = $db_obj->fetcharray($getres1))
	{
			//list($PartKw,$PartUrl)=$db_obj->fetcharray($getres1);
			extract($row1);
			$DispMakeUrl = "autopartshub.com/$AphMake";
			$DispMakePartUrl="autopartshub.com/$AphMake"."_".$PartUrl;
			$DispMakeModelPartUrl = "autopartshub.com/".$aUrl."_".$PartUrl;
			$DispMakeModelUrl = "autopartshub.com/".$aUrl;
			$LandingUrl3="http://www.autopartshub.com/aphlanding.php?make=".$AphMake."&model=".$AphModel."&Part=".$PartKw;
			//for just make/part 
			$LandingUrl4="http://www.autopartshub.com/aphlanding.php?make=".$AphMake."&Part=".$PartKw;
			$sl++;
		
		
			if ($PartKw == "")
			{continue;}
			
			if (strlen($DispMakePartUrl) > 35)
			{
				$DispMakePartUrl="autopartshub.com/$AphMake" . "-Parts";
			}
		
		
			//make model part
			if (strlen($DispMakeModelPartUrl) > 35)
			{
				$DispMakeModelPartUrl="autopartshub.com/".$aUrl."-Parts";
				
					if (strlen($DispMakeModelPartUrl) > 35)
					{
						$DispMakeModelPartUrl="autopartshub.com/".$AphModel."-Parts";


							if (strlen($DispMakeModelPartUrl) > 35)
							{
								$DispMakeModelPartUrl="autopartshub.com/".$AphModel;
								
								
							}

						
						
					}
				
			}
			
			//make model
		
			if (strlen(	$DispMakeModelUrl) > 35)
			{
					$DispMakeModelUrl="autopartshub.com/$AphMake" . "-Parts";
			}



	

	?>
<!--Text Ad
Campaign
Ad Group
Headline
Des 1
Des 2
Display
Desturl
Status

-->
<?
$headline = "Buy {Keyword:".$AphMake." Parts}";
$desc1="Quality Used ".$AphModel ." Parts";
$desc2="Low Cost. Fast Shipping. Order Now";
?>

<tr>
	<td>5001-All Foreign</td>
    <td><?=$AphMake?> <?=$AphModel?> <?=$PartKw?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$desc2?></td>
    <td><?=$DispMakeModelPartUrl?></td>
    <td><?=$LandingUrl3?></td>
    <td>Active</td>
</tr>

<?
if (strlen($PartKw) > 26)
{$altdesc2="OEM ".$PartKw ;
}else
{$altdesc2="Original ".$PartKw ;
}

if (strlen($PartKw) > 16)
{
	$altdesc2 = $PartKw.". Buy Now.";
}else
{
$altdesc2 = "Low Cost ". $PartKw. ". Buy Now.";	
}

?>

<tr>
	<td>5001-All Foreign</td>
    <td><?=$AphMake?> <?=$AphModel?> <?=$PartKw?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$altdesc2?></td>
    <td><?=$DispMakeModelPartUrl?></td>
    <td><?=$LandingUrl3?></td>
    <td>Active</td>
</tr>



<!-- Make Part Ads-->

<?
$desc1="Quality Used ".$AphMake ." Parts";
$desc2 = "All ".$AphMake." models. Buy Now.";
?>

<tr>
	<td>5001-All Foreign</td>
    <td><?=$AphMake?> <?=$PartKw?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$desc2?></td>
    <td><?=$DispMakePartUrl?></td>
    <td><?=$LandingUrl4?></td>
    <td>Active</td>
</tr>




	<?
	}	
	$usql = "UPDATE TabVParts SET Flag='1' WHERE VPartID='$id' ";
	//$db_obj->query($usql);
}
?>
</table>
