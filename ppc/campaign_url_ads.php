
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
	<TD nowrap>Headline</TD>
	<TD>Desc Line 1</TD>    
	<TD>Desc Line 2</TD>    
	<TD>DisplayURL</TD>
	<TD>DestURL</TD>
	<TD>Status</TD>
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


	$getsql1 = "SELECT PartKw,PartUrl,PartCode  FROM xTabPartRef WHERE PartCode='$Part' ";
	$getres1=$db_obj->query($getsql1);
	while ( $row1= $db_obj->fetcharray($getres1))
	{
		//list($PartKw,$PartUrl)=$db_obj->fetcharray($getres1);
		extract($row1);
		$sUrl = "http://autopartshub.com/$AphMake".".html";
		$sUrl1 = "http://autopartshub.com/".$aUrl."_".$PartUrl.".html";
		$sUrl2 = "http://autopartshub.com/".$aUrl.".html";
	
	//	$LandingUrl1="http://autopartshub.com/aphlanding.php?make=".$AphMake;
	//	$LandingUrl2="http://autopartshub.com/aphlanding.php?make=".$AphMake."&model=".$AphModel;
		$LandingUrl4="http://autopartshub.com/aphlanding.php?make=".$AphMake."&Part=".$PartKw;
		$LandingUrl3="http://autopartshub.com/aphlanding.php?make=".$AphMake."&model=".$AphModel."&Part=".$PartKw;
		
		$sl++;
	
		
		//Make Model and Part
		$Array[$LandingUrl3]=$sUrl1;
		// Make and Part
		$Array[$LandingUrl4]=$sUrl;

		$Array1[$LandingUrl3][Make]=$AphMake;
		$Array1[$LandingUrl3][Model]=$AphModel;
		$Array1[$LandingUrl3][Part]=$PartKw;
		$Array1[$LandingUrl3][Part]=$PartKw;
		$Array1[$LandingUrl3][MUL]=$aUrl;
		$Array1[$LandingUrl3][PUL]=$PartUrl;
		$Array1[$LandingUrl3][Pcode]=$PartCode;

		$Array1[$LandingUrl4][Make]=$AphMake;
		$Array1[$LandingUrl4][Model]="";$AphModel;
		$Array1[$LandingUrl4][Part]=$PartKw;
		$Array1[$LandingUrl4][MUL]=$aUrl;
		$Array1[$LandingUrl4][PUL]=$PartUrl;
		$Array1[$LandingUrl4][Pcode]=$PartCode;
	}	
	
	$usql = "UPDATE TabVParts SET Flag='1' WHERE VPartID='$id' ";
	//$db_obj->query($usql);
}
//print "<pre>";
array_unique($Array);
//print_r($Array1);
$sl=0;
foreach($Array as $key => $value)
{
	$sl++;



			$DispMakeUrl = "autopartshub.com/".$Array1[$key][Make];
			$DispMakePartUrl="autopartshub.com/".$Array1[$key][Make]."_".$Array1[$key][PUL];
			$DispMakeModelPartUrl = "autopartshub.com/".$Array1[$key][MUL]."_".$Array1[$key][PUL];
			$DispMakeModelUrl = "autopartshub.com/".$Array1[$key][MUL];
			$LandingUrl3="http://www.autopartshub.com/aphlanding.php?make=".$Array1[$key][Make]."&model=".$Array1[$key][Model]."&Part=".$Array1[$key][Part];
			//for just make/part 
			$LandingUrl4="http://www.autopartshub.com/aphlanding.php?make=".$Array1[$key][Make]."&Part=".$Array1[$key][Part];

if (strlen($DispMakePartUrl) > 35)
			{
				$DispMakePartUrl="autopartshub.com/".$Array1[$key][Make] . "-Parts";
			}
		
		
			//make model part
			if (strlen($DispMakeModelPartUrl) > 35)
			{
				$DispMakeModelPartUrl="autopartshub.com/".$Array1[$key][MUL]."-Parts";
				
					if (strlen($DispMakeModelPartUrl) > 35)
					{
						$DispMakeModelPartUrl="autopartshub.com/".$Array1[$key][Model]."-Parts";


							if (strlen($DispMakeModelPartUrl) > 35)
							{
								$DispMakeModelPartUrl="autopartshub.com/".$Array1[$key][Model];
								
								
							}

						
						
					}
				
			}
			
			//make model
		
			if (strlen(	$DispMakeModelUrl) > 35)
			{
					$DispMakeModelUrl="autopartshub.com/$AphMake" . "-Parts";
			}

$headline = "Buy {Keyword:".$Array1[$key][Make]." Parts}";
$desc1=$Array1[$key][Model]." ". $Array1[$key][Part];
$desc2="Low Cost. Fast Shipping. Order Now";
if($Array1[$key][Model]!='')
	{
?>
<tr>
	<td>5001-All Foreign</td>
    <td><?=$Array1[$key][Make]?> <?=$Array1[$key][Model]?> <?=$Array1[$key][Part]?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$desc2?></td>
    <td><?=$DispMakeModelPartUrl?></td>
	<td><?=$LandingUrl3?></td>
    <td>Active</td>
<!--	<td><?=$Array1[$key][Pcode]?></td>-->
</tr>
<?
	}
if (strlen($Array1[$key][Part]) > 26)
{$altdesc2="OEM ".$Array1[$key][Part] ;
}else
{$altdesc2="Original ".$Array1[$key][Part] ;
}

if (strlen($Array1[$key][Part]) > 16)
{
	$altdesc2 = $Array1[$key][Part].". Buy Now.";
}else
{
$altdesc2 = "Low Cost ". $Array1[$key][Part]. ". Buy Now.";	
}
if($Array1[$key][Model]!='')
	{
?>


 <tr>
	<td>5001-All Foreign</td>
   <td><?=$Array1[$key][Make]?> <?=$Array1[$key][Model]?> <?=$Array1[$key][Part]?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$altdesc2?></td>
    <td><?=$DispMakeModelPartUrl?></td>
    <td><?=$LandingUrl3?></td>
    <td>Active</td>
</tr>  
<?
}

$desc1="Quality Used ".$Array1[$key][Make] ." Parts";
$desc2 = "All ".$Array1[$key][Make]." models. Buy Now.";
if($Array1[$key][Model]=='')
	{
?>

 <tr>
	<td>5001-All Foreign</td>
    <td><?=$Array1[$key][Make]?>  <?=$Array1[$key][Part]?></td>
    <td><?=$headline?></td>
    <td><?=$desc1?></td>
    <td><?=$desc2?></td>
    <td><?=$DispMakePartUrl?></td>
    <td><?=$LandingUrl4?></td>
    <td>Active</td>
</tr> 
<?
}
}
?>
</table>
