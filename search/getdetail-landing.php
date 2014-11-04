<?php
rand();
session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "e9!R7a03raa";
$mdb_database = "rtanner2_cpl";
$mdb_host="qs3505.pair.com" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

$obj=@$_REQUEST["obj"];
$type=@$_REQUEST["type"];
$dtype=@$_REQUEST["dtype"];

function modelxref($cplmodel)
{
	$lcsql = "select distinct HModel from hmodelxref where cplmodel = '$cplmodel' limit 1";
	$result = mysql_query($lcsql);
	$row = mysql_fetch_array($result);
	return $row['HModel'];
}

if($obj=='0')
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
	if($type=='partoption0')
	{
	echo"<option value=''>Part Option</option>";
	}
	

}
else
{
	
	
	
	
	if($type=='make')
	{
		$cyear=$obj;
		$cmake=$_SESSION['cmake'];
		$cmodel=$_SESSION['cmodel'];
		$cpart=$_SESSION['cpart'];
		
		
		$sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($cmodel)."' and indexlist.parttype = '$cpart' and indexlistapp.treelevel =1;" ;
         $result = mysql_query($sql,$mlink);
		 echo"<option value='0'>Select Part Option</option>";
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
		 $_SESSION['cpart']=$obj;
	}
	
	
	
	
	/*if($type=='make')
	{
		if($dtype!=0)
		{
		 $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  order by make" ;	
		}
		else
		{
		$sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". $obj. " order by make" ;
		}
    		  $result = mysql_query($sql,$mlink);
			  echo"<option value='0'>Select Make</option>";
			  while ($row = mysql_fetch_array($result))
			  {
				  $rmake = trim($row['make']);
				  echo "<option value=".$rmake.">".$rmake."</option>";
				  
			  }
			  $_SESSION['cyear']=$obj;		  
	}*/
	if($type=='model')
	{
		
		 $cyear=$_SESSION['cyear'];
		 
		if($dtype!=0)
		{
			$sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$obj' order by Model" ;
		}
		else
		{
		 $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$obj' and carline.CarLineYear = '$cyear' order by Model" ;
		}
         $result = mysql_query($sql,$mlink);
         echo"<option value='0'>Select Model</option>";
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
		
		if($dtype!=0)
		{
			$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($obj)."' order by pdesc asc" ;
		}
		else
		{
		$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where $cyear between beginyear and endyear and ModelNm = '".modelxref($obj)."' order by pdesc asc" ;
		}
		 echo"<option value='0'>Select Part</option>";
		 $result = mysql_query($sql,$mlink);
         while ($row = mysql_fetch_array($result))
         {
          $ptype = trim($row['ptype']);
          $pdesc =  trim($row['pdesc']);
		  echo "<option value=".$ptype.">".$pdesc."</option>";
		 }
		 $_SESSION['cmodel']=$obj;
	}
	if($type=='partoption0')
	{
		$cyear=$_SESSION['cyear'];
		$cmake=$_SESSION['cmake'];
		$cmodel=$_SESSION['cmodel'];
		
		 $sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($cmodel)."' and indexlist.parttype = '$obj' and indexlistapp.treelevel =1;" ;
         $result = mysql_query($sql,$mlink);
		 echo"<option value='0'>Select Part Option</option>";
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
		 $_SESSION['cpart']=$obj;
	}
	
	
	for($a=1; $a<11; $a++ )
	{$b=$a+1;
	
	if($type=="partoption$a")
	{
		$cyear=$_SESSION['cyear'];
		$cmake=$_SESSION['cmake'];
		$cmodel=$_SESSION['cmodel'];
		$cpart=$_SESSION['cpart'];
		$expo=explode('|',$obj);
		$nindexlistid=$expo[0];
		$nseqnbr=$expo[1];
		$ntreelevel=$b;
		
		 $sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '". modelxref($cmodel)."' and seqnbr > ". $nseqnbr. " and indexlist.parttype = '$cpart' and indexlistapp.indexlistid = " .$nindexlistid ;
		 $result = mysql_query($sql,$mlink);
		 echo "<option value='0'>Select Part Option $a</option>";
         while ($row = mysql_fetch_array($result))
         {
			$indexlistid = $row['IndexListId'];
			$seqnbr = $row['SeqNbr'];	
			$interchange = trim($row['InterchangeNumber']);
			$application = trim($row['Application']);
			$treelevel = $row['TreeLevel'];
			if ($application == "")
				{
				$application = "Standard";
				}
			
			if ($treelevel != $ntreelevel && $treelevel != ($ntreelevel -1))
					{
						continue;
					}
			
					if ($treelevel == $ntreelevel -1)
						{
							break;
						}else
						{
											
						$ival = $indexlistid."|".$seqnbr."|".$interchange;
						echo "<option value=".$ival.">".$application."</option>";
						} 
           } 
	  }
	
	
	}
			
	
	
	
}


?>