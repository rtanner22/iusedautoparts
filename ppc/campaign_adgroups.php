<?
include_once('db.php');

/*$lcsql = "SELECT * INTO OUTFILE '/usr/www/users/rtanner2/aro/ppc/ads.txt' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM ppc_ads" ;
echo $lcsql;
$result = mysql_query($lcsql);
$error = mysql_errno($result);
echo $error;
die();
*/


echo "Campaign,AdGroup,Max CPC,Keyword,Keyword Type,Headline,Desc Line 1,Desc Line 2,DisplayURL,DestUrl,Ad Group Status,Keyword Status\r\n";

$sql = buildsql();
echo $sql;


mysql_query('TRUNCATE TABLE ppc_adwords');
mysql_query('TRUNCATE TABLE ppc_ads');
mysql_query('TRUNCATE TABLE ppc_adgroups');
//mysql_query('TRUNCATE TABLE adwordslive');
mysql_query('TRUNCATE TABLE ppc_keywords');


$res=mysql_query($sql);
$nr = mysql_num_rows($res);
$nstart = 0;

// This will loop through all parts from active inventory
while ( $row = mysql_fetch_array($res))

{

  
  $nstart = $nstart + 1;
  echo $nstart ." of ". $nr."<br>";

  $keywords = "";
  $mkeywords = "";
  $rawmkeywords="";
  $rawkeywords = "";
  
  extract($row);
  $hn = $row['inventorynumber'];

  $rsql = "select distinct hmodelxref.cplmake,hmodelxref.cplmodel,min(indexlist.BeginYear) as byear,max(indexlist.EndYear) as eyear,
  indexlistapp.application,length(indexlistapp.application) as applength,hmodelxref.keywords as 
  modelkeywords,ptype.PartType as ptype,replace(ptype.url,'_',' ') as partdesc,ptype.keywords as partkeywords from indexlistapp
  inner join indexlist on indexlistapp.IndexListId = indexlist.indexlistid
  inner join hmodelxref on hmodelxref.HModel = indexlist.ModelNm
  inner join ptype on ptype.PartType = indexlist.PartType
  where  indexlistapp.InterchangeNumber ='$hn' and indexlist.BeginYear >1990
  and cplmake!='' and cplmodel != ''
  group by indexlist.Modelnm" ;

 // echo $rsql;
  //die();
  
    $res2 = mysql_query($rsql);
	//Now this will loop through all applications for a particular hollander number
    while ( $row2 = mysql_fetch_array($res2))
    {

      extract($row2);
      $rawpartkeywords = trim($partkeywords);
	  $rawmodelkeywords = trim($modelkeywords);
      $cplmodel = trim($cplmodel);   
      $application = str_replace("8-350","8cyl",$application);
	  $application = str_replace("8-323","8cyl",$application);
	  $application = str_replace("8-305","8cyl",$application);
	  $application = str_replace("8-395","8cyl",$application);
	  $application = str_replace("8-364","8cyl",$application);
	  $application = str_replace("8-287","8cyl",$application);
	  $application = str_replace("6-262","6cyl",$application);
	  $application = str_replace("6-231","6cyl",$application);
	  $application = str_replace("6-204","6cyl",$application);
	  
	  $application = str_replace("6-191","6cyl",$application);
	  $application = str_replace("4-134","4cyl",$application);
	  $application = str_replace("4-146","4cyl",$application);
	$application = str_replace("4-122","4cyl",$application);
	$application = str_replace("4-148","4cyl",$application);	  
	$application = str_replace("4-150","4cyl",$application);	  
	$application = str_replace("4-121","4cyl",$application);
     
	 
	 //8TH DIGIT
	 $application = str_replace(", 8th digit","",$application);
	 $application = str_replace(" 8th digit","",$application);
	 $application = str_replace("(8th digit)","",$application);
	 $application = str_replace("(8th digit,","(",$application);
	 $application = str_replace(" 8th  digit)",")",$application);
	 $application = str_replace(" 8ht digit)",")",$application);
	 
	 //5TH DIGIT
	 $application = str_replace(" 5th digit,","",$application);
	 $application = str_replace(", 5th digit","",$application);
	 $application = str_replace(" 5th digit","",$application);
	 $application = str_replace("(5th digit)","",$application);
	 $application = str_replace("(5th digit,","(",$application);
	 $application = str_replace(" 5th  digit)",")",$application);
	 $application = str_replace(" 5ht digit)",")",$application);
	 
	 //6TH DIGIT
	 $application = str_replace(" 6th digit,","",$application);
	 $application = str_replace(", 6th digit","",$application);
	 $application = str_replace(" 6th digit","",$application);
	 $application = str_replace("(6th digit)","",$application);
	 $application = str_replace("(6th digit,","(",$application);
	 $application = str_replace(" 6th  digit)",")",$application);
	 $application = str_replace(" 6ht digit)",")",$application);
	 
	 //7TH DIGIT
	 $application = str_replace(" 7th digit,","",$application);
	 $application = str_replace(", 7th digit","",$application);
	 $application = str_replace(" 7th digit","",$application);
	 $application = str_replace("(7th digit)","",$application);
	 $application = str_replace("(7th digit,","(",$application);
	 $application = str_replace(" 7th  digit)",")",$application);
	 $application = str_replace(" 7ht digit)",")",$application);
	 
	 //6TH AND 7TH
	 $application = str_replace("6th & 7th digits,","",$application);
	 $application = str_replace("6th & 7th digit,","",$application);
	  $application = str_replace(" 6th &s,","",$application);
	  
    $applength = strlen(trim($application));
	  

	  
      // This one is for multiple keywords for one thing
      $partkwlist = explode(",",$rawpartkeywords);
        
   

      	      
	  $suffix = "?";
      $vowels = array('A','E','I','O','U','H');

      
    if (in_array(substr($cplmodel,0,1),$vowels))
    {
    $prefix1 = "Need an ";  
    }else
    {
    $prefix1 = "Need a ";    
    }

  
    $headline = $prefix1. $cplmodel." ".$rawpartkeywords.$suffix ;
    $nomodel = false;
	
    if (strlen($headline) > 25)
    {
    
			if (in_array(substr($rawpartkeywords,0,1),$vowels))
			{
			$prefix2 = "Need an ";  
			}else
			{
			$prefix2 = "Need a ";    
			}
	
			$headline = $prefix2 .$rawpartkeywords.$suffix;
			$nomodel=true;
	
    }
	
	
    
   if ($byear!=$eyear)
   {
	$yearlength=6;
   }else{
   $yearlength=3;
   }

   
   if ($applength <= 29)
   {
	   if ($byear != $eyear)
	   {
		$desc1 = substr($byear,-2)."-".substr($eyear,-2)." ".$application;
	   }else
	   {
	   $desc1 = "'".substr($byear,-2)." ".$application;
	   }
	}
	
	if ($nomodel == true && strlen($desc1) <= 35-strlen($cplmodel))
	{
	  $desc1 = $cplmodel. " " . $desc1;
	}
   
   if ($applength > 29 && $applength <= 35)
   {$desc1 = $application;}
   
   if ($applength > 35)
   {$desc1 = substr($application,0,35);}
   
   if (strlen($desc1) <= 30)
   {
   $desc1 = "Fits ".$desc1;
   }
   
   
    $desc2= "Compare prices and save big.";
     
    $dispurl= "/";
    echo $headline." ".$desc1." ".$desc2."<br>";

    //add part to this 19 characters
    if (strlen($kwlist[0] < 16))
    {
      $dispurl = $dispurl . strtolower(str_replace(" ","_",$partkwlist[0]));  
    }


    $url ="/parts/?make=".$cplmake."&model=".$cplmodel."&part=".$ptype;

  
    if ($cplmake == "" || $cplmodel == "")
    {
      continue;  
    }


    foreach ($partkwlist as $partkw) 
    {
    
      $rpartkw = $partkw;
      $bkeywords = str_replace(" "," +",$rpartkw);
      $bkeywords = str_replace("++","+",$bkeywords);
	  $admodelkeywords = str_replace(" "," +",$modelkeywords);
      $admodelkeywords = str_replace("++","+",$admodelkeywords);
	  $campaignname = "ARO-".$partkw;
      $desc1 = addslashes($desc1);
	  
      if ($bkeywords == "")
        {
        continue;  	
        }
			   
			  for ($yctr=$byear;$yctr<= $eyear+1;$yctr++)  // Added the +1 for an extra loop to add an entry without a year
			  {	
			  
				  $adyear = "+".substr($yctr,-2)." ";	
				  $yearheadline = substr($byear,-2)."-".substr($eyear,-2)." ";
					  if ($yctr >= 2010 || $yctr == 2000)
					  {
					  $adyear = "+".$yctr." ";
					  }

					  if ($yctr == $eyear + 1) // Did this for an extra insert that will not contain a yearlength}
					  {
						$adyear = "";
						$yearheadline = $yearheadline . " (Broad) " ;
						$adgroupyear = $yearheadline;
					  }else{
					  $adgroupyear = $yctr." ";
					  }


					  $lcinsert = "insert into ppc_adwords (campaign,adgroup,maxcpc,keyword,type,headline,desc1,desc2,
					  dispurl,desturl,adgroupstatus,keywordstatus) VALUES ('$campaignname','".$adgroupyear.$cplmake." ".$cplmodel." ".$partkwlist[0]."','.80',
					  '".$adyear."+".$admodelkeywords." +".$bkeywords."','Broad','$headline','$desc1','$desc2','$dispurl','$url','Enabled','Enabled')";
					
						mysql_query($lcinsert);
						
					
					
					if ($adyear == "") // No years listed so lets add negatives
					 {
					 
					   // first lets build a string of years outside the range of this particular part
					   // We can go back 5 years and ahead 5 years maybe
					   $negstart = $byear - 5;
					   $negend = $eyear + 5;
					   $negs = "";
						   for ($negctr=$negstart;$negctr <= $negend;$negctr++)
						   {
							 if ($negctr >= $byear && $negctr <= $eyear)
							 {
							  
							 }else{
							  $neg = " -".$negctr ;
							  $neg2 = " -".substr($negctr,-2);
							  
								$lcinsert = "insert into ppc_adwords (campaign,adgroup,maxcpc,keyword,type,headline,desc1,desc2,
								dispurl,desturl,adgroupstatus,keywordstatus) VALUES ('$campaignname','".$yearheadline.$cplmake." ".$cplmodel." ".$partkwlist[0]."','.80',
								'".$neg."','Negative','$headline','$desc1','$desc2','$dispurl','$url','Enabled','Enabled')" ;
								mysql_query($lcinsert);		
								
								$lcinsert = "insert into ppc_adwords (campaign,adgroup,maxcpc,keyword,type,headline,desc1,desc2,
								dispurl,desturl,adgroupstatus,keywordstatus) VALUES ('$campaignname','".$yearheadline.$cplmake." ".$cplmodel." ".$partkwlist[0]."','.80',
								'".$neg2."','Negative','$headline','$desc1','$desc2','$dispurl','$url','Enabled','Enabled')" ;
								
								mysql_query($lcinsert);		

							
					    	}
						}
					   
						   
					     
						 
						 

						 }
					

			  
			  }

			

    }

  }  
  
}



$lcinsert1="insert into ppc_adgroups select distinct campaign,adgroup,maxcpc,adgroupstatus from ppc_adwords";
$lcinsert2="insert into ppc_ads select distinct campaign,adgroup,headline,desc1,desc2,dispurl,desturl from ppc_adwords";
$lcinsert3="insert into ppc_keywords select distinct campaign,adgroup,keyword,type,keywordstatus from ppc_adwords";

ECHO 'About to do query';
mysql_query($lcinsert1);
mysql_query($lcinsert2);
mysql_query($lcinsert3);
ECHO 'DONE';


function buildsql()
{
$lcsql = "select distinct inventorynumber from inventory where modelyear > 1990 and substring(inventorynumber,4,1) = '-'
and substring(inventorynumber,1,3) in ('300','400','412','434','435','440','444')" ;

return $lcsql;
}



?>
