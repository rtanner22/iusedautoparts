<?
include_once('db.php');

/*
header("Cache-Control: no-cache, must-revalidate");
header("Content-disposition: attachment; filename=adgroups.txt");
header("Content-Type: text/csv");
*/

/*
Headline: 		Example Website 25 characters
Description line 1: 	Summer sale 	35 characters
Description line 2: 	Save 15% 	35 characters
Display URL:		www.example.com	35 characters
*/

echo "Campaign,AdGroup,Max CPC,Keyword,Keyword Type,Headline,Desc Line 1,Desc Line 2,DisplayURL,DestUrl,Ad Group Status,Keyword Status\r\n";


$sql = buildsql();
//echo $sql;

mysql_query('TRUNCATE TABLE adwords');
mysql_query('TRUNCATE TABLE ads');
mysql_query('TRUNCATE TABLE adgroups');
mysql_query('TRUNCATE TABLE adwordslive');

$res=mysql_query($sql);
$nr = mysql_num_rows($res);
$nstart = 0;
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

	$rsql = "select distinct hmodelxref.cplmake,hmodelxref.cplmodel,min(indexlist.BeginYear) as byear,max(indexlist.EndYear) as year,hmodelxref.keywords as mkeywords,ptype.PartType as ptype,replace(ptype.url,'_',' ') as partdesc,ptype.keywords from indexlistapp
	inner join indexlist on indexlistapp.IndexListId = indexlist.indexlistid
	inner join hmodelxref on hmodelxref.HModel = indexlist.ModelNm
	inner join ptype on ptype.PartType = indexlist.PartType
	where  indexlistapp.InterchangeNumber ='$hn' 
	and cplmake!='' and cplmodel != ''
	group by indexlist.Modelnm" ;

	//echo $rsql;
	//die();
	
		$res2 = mysql_query($rsql);
		while ( $row2 = mysql_fetch_array($res2))
		{



		/*echo "Campaign,AdGroup,Max CPC,Display Max CPC,Keyword,Keyword Type,Headline,Desc Line 1,Desc Line 2,DisplayURL,DestUrl,Ad Group Status,Keyword Status\n";*/

			/*
			Headline 25 characters
			Des 1  35
			Des 2  35
			DispuRL 35
			*/
			extract($row2);
			$rawkeywords = trim($keywords);

			// This one is for multiple keywords for one thing
			$kwlist = explode(",",$rawkeywords);

			// THis would be for models like Mercedes where we actually need an ad for each one.. E350 E550 etc.
			$kwlist2 = explode("|",$rawkeywords); 

			//echo "<br>Raw: ".$rawkeywords."<br>";
			//echo "First: ". $kwlist[0]."<br>";

			$keywords = trim($keywords);
			$cplmodel = trim($cplmodel);
			$rawmodelkeywords = trim($mkeywords);

			$mkeywords = str_replace(" "," +",$mkeywords);
			$mkeywords = str_replace("++","+",$mkeywords);

			$multikw = false;


			if (strpos($rawkeywords,",") === false && strpos($rawkeywords,"|") === false)
			{
				$headline = $rawkeywords;	
				$fkeyword = $rawkeywords;
				$bkeywords = str_replace(" "," +",$keywords);
				$bkeywords = str_replace("++","+",$bkeywords);

			}else
			{
				$multikw = true;
				$headline = $kwlist[0]; //strstr($rawkeywords,",",true);	
				$fkeyword = $kwlist[0];
				$bkeywords = str_replace(" "," +",$fkeyword);
				$bkeywords = str_replace("++","+",$bkeywords);
			}


			// this is the one where we need to loop and make a new adgroup for each model 
			$multikw2 = false;

			if (strpos($rawkeywords,"|") > 0)
			{
			
				//Need to come up with some logic here to loop and get makes and models with info below this loop
			/*
				$multikw = true;
				$headline = $kwlist[0]; //strstr($rawkeywords,",",true);	
				$fkeyword = $kwlist[0];
				$bkeywords = str_replace(" "," +",$fkeyword);
				$bkeywords = str_replace("++","+",$bkeywords);	
			*/
			}






		$vowels = array('A','E','I','O','U');

		// check for 

		if (in_array(substr($headline,0,1),$vowels))
		{
		$prefix1 = "Need an ";	
		}else
		{
		$prefix1 = "Need a ";		
		}


		$suffix1 = "?";

		if (strlen($headline) <= 17)
		{
			$headline = $prefix1.$headline.$suffix1;	
		}elseif (strlen($headline) > 17 && strlen($headline) < 25)
		{
			$headline = $headline.$suffix1;		
		}


		if ($multikw == true)
		{
			$desc1 = strstr($rawkeywords,",",true);	
		}else {  
			$desc1= $rawkeywords;
		}


		$prefix1 = "Discount ";
		if (strlen($desc1) <= 22)
		{
			$desc1 = $prefix1.$desc1;
		}



		//$desc2= "Great Prices. Nationwide Shipping.";
		$desc2= $cplmodel ." parts";
		
		$dispurl= "iusedautoparts.com/";

		//add part to this 19 characters
		if (strlen($kwlist[0] < 16))
		{
			$dispurl = $dispurl . strtolower(str_replace(" ","_",$kwlist[0]));	
		}


		$url ="http://www.iusedautoparts.com/parts/?make=".$cplmake."&model=".$cplmodel."&part=".$ptype;

	
		if ($cplmake == "" || $cplmodel == "")
		{
			continue;	
		}

		
		if ($cplmodel == "Colorado" && $kwlist[0] == "Speedometer")	
		{
			//echo "<br>".$cplmodel." ".$keywords."<br>";
		}


		// broad + modifier
		foreach ($kwlist as $kw) 
		{
		
			$rkw = $kw;
			$bkeywords = str_replace(" "," +",$kw);
			$bkeywords = str_replace("++","+",$bkeywords);
		
			if ($bkeywords == "")
				{
				continue;	
				}
					
			//echo "\"IUAP-Main\",\"".$cplmake." ".$cplmodel." ".$kwlist[0]."\",\".50\",\"+".$mkeywords." +".$bkeywords.
			"\",\"Broad\",\"".$headline."\",\"".$desc1."\",\"".$desc2."\",\"".$dispurl."\",\"".$url."\",\"Enabled\",\"Enabled\"\n";
		

			$lcinsert = "insert into adwords (campaign,adgroup,maxcpc,keyword,type,headline,desc1,desc2,
dispurl,desturl,adgroupstatus,keywordstatus) VALUES ('IUAP-Main','".$cplmake." ".$cplmodel." ".$kwlist[0]."','.50',
                                       '+".$mkeywords." +".$bkeywords."','Broad','$headline','$desc1','$desc2','$dispurl','$url','Enabled','Enabled')";

			//echo $lcinsert."<br>";
			mysql_query($lcinsert);

			
			// phrase
			/*
			echo "\"IUAP-Main\",\"".$cplmake." ".$cplmodel." ".$kwlist[0]."\",\".50\",\"".$rawmkeywords." ".$rkw.
			"\",\"Phrase\",\"".$headline."\",\"".$desc1."\",\"".$desc2."\",\"".$dispurl."\",\"".$url."\",\"Enabled\",\"Enabled\"\n";
			// exact
			echo "\"IUAP-Main\",\"".$cplmake." ".$cplmodel." ".$kwlist[0]."\",\".50\",\"".$rawmkeywords." ".$rkw.
			"\",\"Exact\",\"".$headline."\",\"".$desc1."\",\"".$desc2."\",\"".$dispurl."\",\"".$url."\",\"Enabled\",\"Enabled\"\n";
	
			*/
		}
	

	}	

}



$lcinsert1="insert into adgroups select distinct campaign,adgroup,maxcpc,keyword,type,adgroupstatus,keywordstatus from adwords";
$lcinsert2="insert into ads select distinct campaign,adgroup,headline,desc1,desc2,dispurl,desturl from adwords";

msyql_query($lcinsert1);
msyql_query($lcinsert2);



function buildsql()
{

$lcsql = "select distinct inventorynumber from 1004inv where quantityavailable>0 and modelyear > 1990 and substring(inventorynumber,4,1) = '-'
and substring(inventorynumber,1,3) in ('300','400','128','166','560','257','590','114','655','116','591','400','238','125','336','515','512','431','327','306','323','311','545',
'104','135','629','337','447','412','329','551','538','615','675','319','601','617','435','309','553','674','308','606','527','676','430')

union ALL

select distinct inventorynumber from 1002inv where quantityavailable>0 and modelyear > 1990 and substring(inventorynumber,4,1) = '-'
and substring(inventorynumber,1,3) in ('300','400','128','166','560','257','590','114','655','116','591','400','238','125','336','515','512','431','327','306','323','311','545',
'104','135','629','337','447','412','329','551','538','615','675','319','601','617','435','309','553','674','308','606','527','676','430')";

return $lcsql;
}


?>

