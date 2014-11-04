<?
include_once('db.php');
?>

<table border=1>

<tr>
	<TD>Campaign</TD>
	<TD>Adgroup</TD>    
	<TD nowrap> Keyword </TD>
	<TD>Type</TD>
	<TD>Max CPC</TD>
	<TD>Landing URL</TD>
	<TD>Keyword Status</TD>
</tr>


<?

$sql = "SELECT a.VPartID as id ,HSId as Hollander,left(trim(HSId),3) as Part,c.Vmake Make,d.Vmodel Model 
		FROM TabVParts a, TabVehicle b,xTabVMake c, xTabVModel d WHERE a.VEStockID = b.VVendorStockID AND c.VMakeID=d.VMakeID AND b.VModelID=d.VModelID  AND b.VMakeID=d.VMakeID 
		AND  a.VPartPrice > 0 AND a.Flag=0 AND a.Vid=5001 Group BY Make,Model,Part";
$res=$db_obj->query($sql);

$KeywordsArray1[]='';
while ( $row = $db_obj->fetcharray($res) )
{
	extract($row);
	
	$getsql = "SELECT cplMake,cplModel,aUrl FROM xTabMakeModelRef WHERE HModel='$Model' ";
	$getres=$db_obj->query($getsql);
	list($cplMake,$cplModel,$aUrl)=$db_obj->fetcharray($getres);

	$getsql1 = "SELECT PartKw,PartUrl FROM xTabPartRef WHERE PartCode='$Part' ";
	$getres1=$db_obj->query($getsql1);
	list($PartKw,$PartUrl)=$db_obj->fetcharray($getres1);

	$DispMakeUrl = "carpartslocator.com/$cplMake";
	$DispMakePartUrl="carpartslocator.com/$cplMake"."_".$PartUrl;
	$DispMakeModelPartUrl = "carpartslocator.com/".$aUrl."_".$PartUrl;
	$DispMakeModelUrl = "carpartslocator.com/".$aUrl;
	$LandingUrl3="http://www.carpartslocator.com/cpllanding.php?make=".$cplMake."&model=".$cplModel."&Part=".$PartKw;
	//for just make/part 
	$LandingUrl4="http://www.carpartslocator.com/cpllanding.php?make=".$cplMake."&Part=".$PartKw;
	$sl++;


	if ($PartKw == "")
	{continue;}
	
	if (strlen($DispMakePartUrl) > 35)
	{
		$DispMakePartUrl="carpartslocator.com/$cplMake" . "-Parts";
	}


	//make model part
	if (strlen($DispMakeModelPartUrl) > 35)
	{
		$DispMakeModelPartUrl="carpartslocator.com/".$aUrl."-Parts";
		
			if (strlen($DispMakeModelPartUrl) > 35)
			{
				$DispMakeModelPartUrl="carpartslocator.com/".$cplModel."-Parts";
				
				
			}
		
	}
	
	//make model

	if (strlen(	$DispMakeModelUrl) > 35)
	{
			$DispMakeModelUrl="carpartslocator.com/$cplMake" . "-Parts";
	}


//This will add a + sign to all keywords in PartKw

$MakeKeywords = "+".$cplMake ;
$MakeKeywords =str_replace(" "," +",$MakeKeywords);

$ModelKeywords = "+" .$cplModel ;
$ModelKeywords =str_replace(" "," +",$ModelKeywords);

$PartKeywords = "+".$PartKw;
$PartKeywords = str_replace(" "," +",$PartKeywords);

	if (!in_array($LandingUrl3, $KeywordsArray1)) 
	{
?>
<!-- Make Model Part-->
<!--
<tr>
	<td>5001-All Foreign</td>
    <td><?=$cplMake?> <?=$cplModel?> <?=$PartKw?></td>
    <td><?=$ModelKeywords?> <?=$PartKeywords?></td>
    <td>Broad</td>
    <td>0.15</td>
    <td><?=$LandingUrl3?></td>
    <td>Active</td>
</tr>
-->

<? 
	}
	if (!in_array($LandingUrl4, $KeywordsArray)) {
	?>
<tr>
	<td>5001-All Foreign</td>
    <td><?=$cplMake?> <?=$PartKw?></td>
    <td><?=$MakeKeywords?> <?=$PartKeywords?></td>
    <td>Broad</td>
    <td>0.15</td>
    <td><?=$LandingUrl4?></td>
    <td>Active</td>
</tr>
	<?
	}

		$KeywordsArray[$LandingUrl4]=$LandingUrl4;
		$KeywordsArray1[$LandingUrl3]=$LandingUrl3;
	
	$usql = "UPDATE TabVParts SET Flag='1' WHERE VPartID='$id' ";
	//$db_obj->query($usql);
}
?>
</table>
