<?php
session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "BHeFVC7i";
$mdb_database = "rtanner2_cpl";
$mdb_host="qs3505.pair.com" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

$obj=@$_REQUEST["obj"];
$type=@$_REQUEST["type"];

function modelxref($aphmodel)
{
	$lcsql = "select distinct HModel from hmodelxref where AphModel = '$aphmodel' limit 1";
	$result = mysql_query($lcsql);
	$row = mysql_fetch_array($result);
	return $row['HModel'];
}

if($obj=='')
{
	if($type=='make')
	{
	echo"<option value=''>Make</option>";
	}
	if($type=='model')
	{
	echo"<option value=''>Model</option>";
	}
	if($type=='part')
	{
	echo"<option value=''>Part</option>";
	}
	if($type=='partoption')
	{
	echo"<option value=''>Part Option</option>";
	}
	

}
else
{
	
	if($type=='make')
	{
		$sql = "select distinct hmodelxref.AphMake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". $obj. " order by make" ;
    		  $result = mysql_query($sql,$mlink);
			  echo"<option value=''>Select Make</option>";
			  while ($row = mysql_fetch_array($result))
			  {
				  $rmake = trim($row['make']);
				  echo"<option value=".$rmake.">".$rmake."</option>";
			  }
			  $_SESSION['cyear']=$obj;		  
	}
	if($type=='model')
	{
		 $cyear=$_SESSION['cyear'];
		 $sql = "select distinct hmodelxref.AphModel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.AphMake = '$obj' and carline.CarLineYear = '$cyear' order by Model" ;
         $result = mysql_query($sql,$mlink);
         echo"<option value=''>Select Model</option>";
		 while ($row = mysql_fetch_array($result))
         {
         $rmodel = trim($row['model']);
		 echo "<option value=".$rmodel.">".$rmodel."</option>";
		 }
		 $_SESSION['cmake']=$obj;
	}
	if($type=='part')
	{
		$cyear=$_SESSION['cyear'];
		$cmake=$_SESSION['cmake'];
		
		$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where $cyear between beginyear and endyear and ModelNm = '".modelxref($obj)."' order by pdesc asc" ;
		 echo"<option value=''>Select Part</option>";
		 $result = mysql_query($sql,$mlink);
         while ($row = mysql_fetch_array($result))
         {
          $ptype = trim($row['ptype']);
          $pdesc =  trim($row['pdesc']);
		  echo "<option value=".$ptype.">".$pdesc."</option>";
		 }
		 $_SESSION['cmodel']=$obj;
	}
	if($type=='partoption')
	{
		$cyear=$_SESSION['cyear'];
		$cmake=$_SESSION['cmake'];
		$cmodel=$_SESSION['cmodel'];
		
		 $sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($cmodel)."' and indexlist.parttype = '$obj' and indexlistapp.treelevel =1;" ;
         $result = mysql_query($sql,$mlink);
		 echo"<option value=''>Select Part Option</option>";
         while ($row = mysql_fetch_array($result))
         {
			 $indexlistid = $row['IndexListId'];
			 $seqnbr = $row['SeqNbr'];	
			 $interchange = trim($row['InterchangeNumber']);
			 $application = trim($row['Application']);
			 if ($application == "")
			 {
				$application = "Standard";
			 }
										
			 $ival = $indexlistid."|".$seqnbr."|".$interchange;
			  echo "<option value=".$ival.">".$application."</option>";
			 
         } 
	}
	
			
			
	
	
	
}


?>