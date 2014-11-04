<?php
rand();
session_start();
$mdb_username = "rtanner2_38";
$mdb_password = "BHeFVC7i";
$mdb_database = "rtanner2_cpl";
$mdb_host="localhost" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

$obj=@$_REQUEST["obj"];
$type=@$_REQUEST["type"];
$dtype=@$_REQUEST["dtype"];

$cyear=@$_REQUEST["cyear"];
$make=@$_REQUEST["make"];
$model=@$_REQUEST["model"];
$part=@$_REQUEST["part"];

function modelxref($cplmodel)
{
	$lcsql = "select distinct HModel from hmodelxref where cplmodel = '$cplmodel' limit 1";
	$result = mysql_query($lcsql);
	$row = mysql_fetch_array($result);
	return $row['HModel'];
}


function makexref($cplmake)
{
	$lcsql = "select distinct HMakeCode from hmodelxref where cplmake = '$cplmake' limit 1";
	$result = mysql_query($lcsql);
	$row = mysql_fetch_array($result);
	return $row['HMakeCode'];
	
}


if($type=='year')
	{
		if($dtype!=0)
		{
			 
			 
			$sql ="select distinct min(indexlist.BeginYear) as BeginYear, max(indexlist.EndYear) as EndYear, ptype.Description as pdesc,indexlist.parttype as ptype,indexlist.ModelNm as model from indexlist inner join ptype on ptype.PartType = indexlist.PartType where indexlist.parttype='$part' ";

		  if(trim($make)!='')
	{   $makenew=makexref($make);	  
		$sql .=" and indexlist.MfrCd='$makenew' ";

			}
			if($model!='')
			{
				$modelnew=modelxref($model);
				$sql .=" and indexlist.ModelNm='$modelnew'";
			}
			
			$sql .=" order by BeginYear asc";
			
			
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$lowval = $row['BeginYear'];
			$highval = $row['EndYear'];
			echo "<option value='0' >Select Year</option>";
			for  ($i=$highval;$i>=$lowval;$i--)	
			{
				 echo "<option value=".$i.">".$i."</option>";
			}
		}
	}

if($obj=='0')
{
	if($type=='make')
	{
	echo"<option value=''>Select Make</option>";
	}
	if($type=='model')
	{
	echo"<option value=''>Select Model</option>";
	}
	if($type=='part')
	{
	echo"<option value=''>Select Part</option>";
	}
	if($type=='partoption0')
	{
	echo"<option value=''>Select Part Option</option>";
	}
	

}
else
{
	if($type=='make')
	{
		if($dtype!=0)
		{
		 $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  order by make" ;	
		}
		else
		{
		$sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". $cyear. " order by make" ;
		}
    		  $result = mysql_query($sql,$mlink);
			  echo "<option value='0' >Select Make</option>";
			  while ($row = mysql_fetch_array($result))
			  {
				  $rmake = trim($row['make']);
				  if($rmake!='')
				  {
				  echo "<option value='".$rmake."'>".$rmake."</option>";
				  }
			  }
			  
	}
	if($type=='model')
	{
		
		
		 
		if($dtype!=0)
		{   
			 $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make' order by Model" ;
		}
		else
		{
		 $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make' and carline.CarLineYear = '$cyear' order by Model" ;
		}

         $result = mysql_query($sql,$mlink);
		//echo"<option value='0'>Model: ".$model."</option>";	
         echo"<option value='0'>Select Model</option>";
		 while ($row = mysql_fetch_array($result))
         {
         $rmodel = trim($row['model']);
		 echo "<option value='".$rmodel."'>".$rmodel."</option>";
		 }
		
	}
	if($type=='part')
	{
		
		
		if($dtype!=0)
		{
			$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
		}
		else
		{
		$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where $cyear between beginyear and endyear and ModelNm = '".modelxref($model)."' order by pdesc asc" ;
		}
		//echo"<option value='0'>Model: ".$model."</option>";	
		 echo "<option value='0'>Select Part</option>";
		 $result = mysql_query($sql,$mlink);
         while ($row = mysql_fetch_array($result))
         {
          $ptype = trim($row['ptype']);
          $pdesc =  trim($row['pdesc']);
		  echo "<option value='".$ptype."'>".$pdesc."</option>";
		 }
		 
	}
	if($type=='partoption0')
	{
		if($dtype!=0)
		{
		
		
		$sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($model)."' and indexlist.parttype = '$part' and indexlistapp.treelevel =1;" ;
		}
		else
		{
		
		 $sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($model)."' and indexlist.parttype = '$part' and indexlistapp.treelevel =1;" ;
		}
         $result = mysql_query($sql,$mlink);
		 echo "<option value='0'>Select Part Option</option>";
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
			 echo "<option value='".$ival."'>".$application."</option>";
			 
         }
		 if(mysql_num_rows($result)==0){ echo "<option>No results match your keyword.</option>"; } 
		 $_SESSION['cpart']=$obj;
	}
	
	
	for($a=1; $a<11; $a++ )
	{$b=$a+1;
	
	if($type=="partoption$a")
	{
		
		$cmake=$_SESSION['cmake'];
		$cmodel=$_SESSION['cmodel'];
		$cpart=$_SESSION['cpart'];
		$expo=explode('|',$obj);
		$nindexlistid=$expo[0];
		$nseqnbr=$expo[1];
		$ntreelevel=$b;
		
		 $sql ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$cyear." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '". modelxref($model)."' and seqnbr > ". $nseqnbr. " and indexlist.parttype = '$part' and indexlistapp.indexlistid = " .$nindexlistid ;
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
						echo "<option value='".$ival."'>".$application."</option>";
						} 
           } 
	  }
	
	
	}
			
	
	
	
}


?>