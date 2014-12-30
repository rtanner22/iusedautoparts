<?php
require '../inc/rb.phar';
R::setup('mysql:host=192.168.200.100;dbname=iusedparts','iusedparts','5huYvRDH');

function modelxref($cplmodel)
{
    $result = R::getAll("select distinct HModel from hmodelxref where cplmodel = '$cplmodel' limit 1");
    if($result)
	{
        return $result[0]['HModel'];}
    else{ return false;}
}


function makexref($cplmake)
{
    $result = R::getAll("select distinct HMakeCode from hmodelxref where cplmake = '$cplmake' limit 1");
    if($result)
	{	
        return $result[0]['HMakeCode'];
    }	
    else
	{ return 0;}

}

if(!empty($_POST['carYears']))
{
	if(!empty($_POST['carYearsMake'])) {
	  //  $result = R::getAll( 'SELECT CarlineYear FROM carline WHERE MfrName = "'.$_POST['carYearsMake'].'" group by CarlineYear DESC' );
	      $result = R::getAll( 'SELECT CarlineYear FROM hmodelxref inner join carline on carline.Mfrcode = hmodelxref.hMakeCode WHERE hmodelxref.cplmake = "'.urldecode($_POST['carYearsMake']).'"  group by CarlineYear DESC' );

	echo "carYearsMake: ". $_POST['carYearsMake'];

	}
	else if(!empty($_POST['carYearsModel'])) {
	        $postmodel = $_POST['carYearsModel'];
	      //$postmodel = str_replace("%20"," ",$postmodel);
		$postmodel = urldecode($postmodel);
	     $result = R::getAll( 'SELECT CarlineYear FROM hmodelxref inner join carline on carline.ModelNm = hmodelxref.hmodel WHERE hmodelxref.cplmodel = "'.$postmodel.'"  group by CarlineYear DESC');

	    
	} else {
	    $result = R::getAll( 'SELECT CarlineYear FROM carline group by CarlineYear DESC' );
	}
    if($result)
    {
        $years = array();
        foreach($result as $r)
        {
            $years[] = $r['CarlineYear'];
        }
        echo json_encode($result, JSON_FORCE_OBJECT);
    }
}
if(!empty($_POST['label']))
{
    $result = R::getAll( "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". (int)$_POST['label']. " order by make" );
    if($result)
    {
        $json = array();
        foreach($result as $r)
        {
            $json[] = '{"manufacture":"' . $r['make'] . '"}';
        }
    }
    $json = "[".implode(',',$json)."]";
        echo $json;//json_encode($result, JSON_FORCE_OBJECT);
}
if(!empty($_POST['manufacture'])&&empty($_POST['models']))
{
    $result = R::getAll( "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '".$_POST['manufacture']."' and carline.CarLineYear = '".$_POST['year']."' order by Model");
    if($result)
    {
        $json = array();
        foreach($result as $r)
        {
            $json[] = '{"model":"' . trim($r['model']) . '"}';
        }
    }
    $json = "[".implode(',',$json)."]";
        echo $json;//json_encode($result, JSON_FORCE_OBJECT);
}
if(!empty($_POST['makes']) && $_POST['makes']==1)
{

    $result = R::getAll( "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  order by make" );
    if($result)
    {
        $json = array();
        foreach($result as $r)
        {
            $json[] = '{"manufacture":"' . trim($r['make']) . '"}';
        }
    }
    $json = "[".implode(',',$json)."]";

    echo $json;//json_encode($result, JSON_FORCE_OBJECT);
}

if(!empty($_POST['getMake']) && $_POST['getMake']==1)
{

    $result = R::getAll( "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd where cplmodel LIKE '".$_POST['carMakeModel']."' order by make" );

	echo $result[0]['make'];
    //echo $json;//json_encode($result, JSON_FORCE_OBJECT);
}
if(!empty($_POST['models']) && $_POST['models']==1)
{

    $result = R::getAll( "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '".$_POST['manufacture']."'  order by Model");
    {
        $json = array();
        foreach($result as $r)
        {
            $json[] = '{"model":"' . trim($r['model']) . '"}';
        }
    }
    $json = "[".implode(',',$json)."]";

    echo $json;//json_encode($result, JSON_FORCE_OBJECT);
}

if(!empty($_POST['carModel']))
{
	if(!empty($_POST['year']))
	    $result = R::getAll( "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where ".$_POST['year']." between beginyear and endyear and ModelNm = '".modelxref($_POST['carModel'])."' order by pdesc asc" );
	else
	    $result = R::getAll( "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where ModelNm = '".modelxref($_POST['carModel'])."' order by pdesc asc" );

    if($result)
    {
        $json = array();
        $counter = 0;

        foreach($result as $r)
        {
            $json[] = '{"part":{"desc":"' . $r['pdesc']. '","id":"' . $r['ptype']. '"}}';
            $counter++;
        }
    }
    if(!empty($json))
    {
        $json = "[".implode(',',$json)."]";
        echo $json;
    } else echo "[]";
}
if(!empty($_POST['partOptions']))
{
    $res = array();
    $level = array();
    $entry = array();
    $parentids = array(1 => "-1");
    $result = R::getAll( "select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".
        $_POST["year"]." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '"
        .modelxref($_POST['model'])."' and indexlist.parttype = '".$_POST["part"]."' " );
$query = "select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".
        $_POST["year"]." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '"
        .modelxref($_POST['model'])."' and indexlist.parttype = '".$_POST["part"]."';";
        //echo $query;
        //return;
$id=1;
    if($result)
    {
        foreach($result as $r)
        {
			$interchange = trim($r['InterchangeNumber']);
			$indexlistid = $r['IndexListId'];
			$seqnbr = $r['SeqNbr'];
			$ival = $indexlistid."|".$seqnbr."|".$interchange;
        	if($r['Application']!="") {
        		$entry[$id]['text'] = str_replace('"', '&quot;', $r['Application']);
				$entry[$id]['value'] = $ival;
				$entry[$id]['id'] = $id;
				$level = $r['TreeLevel'];
				$entry[$id]['parentid'] = $parentids[$level];
				$parentids[$level+1] = $id;
				$id++;
			}
			else {
        		$entry2['text'] = str_replace('"', '&quot;', $r['Application']);
				$entry2['value'] = $ival;
				$entry2['id'] = $id;
				$level2 = $r['TreeLevel'];
				$entry2['parentid'] = $parentids[$level2];
			}
		}
		if(count($entry) > 1 || !isset($entry2)) {
			foreach($entry as $r)
			{
				$json[] = '{"value":"' . $r['value']. '","id":"' .
					$r['id'] . '","parentid":"' . $r['parentid']. '","text":"' . $r['text']. '"}';
				//$json[] = '{"option":{"value":"' . $part[1]. '","text":"' .
				//    str_replace('"',"''",$part[0]). '","parentid":"1"}}';
			}
		}
    }
    if(!empty($json))
    {
        $json = "[".implode(',',$json)."]";
        echo $json;
    } else if($entry2) {
		$json[] = '{"value":"' . $entry2['value']. '","id":"' .
         $entry2['id'] . '","parentid":"' . $entry2['parentid']. '","text":"' . $entry2['text']. '"}';
        $json = "[".implode(',',$json)."]";
        echo $json;
     } else echo "[]";
}