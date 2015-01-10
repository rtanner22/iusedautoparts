<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>Car parts locator</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<style>
html {overflow-x:hidden !important;overflow-y:hidden !important;   -webkit-overflow-scrolling: touch;}
body {overflow-x:hidden !important;overflow-y:hidden !important;   -webkit-overflow-scrolling: touch;}
</style>
</head>

<body>
<div class="wrapperheader">
    <div class="inwrap">
        <div class="header-img" align="center">
            <img src="img/logo7.png" alt="img"  />
        </div>
    </div>
</div>
<div class='myIframe' > 
<!--<iframe  src="mobile.php"></iframe>-->
<?php
session_start();
$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host="192.168.200.100" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

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

$keys=implode('~',array_keys($_GET));
$year= mysql_real_escape_string(@$_GET['year']);
$make= mysql_real_escape_string(@$_GET['make']);
$model= mysql_real_escape_string(@$_GET['model']);
$part= mysql_real_escape_string(@$_GET['part']);





if($keys=='make~model~part')
{
	$dtype=1;
	$query=1;
	
}
else if($keys=='model~make~part')
{
	$dtype=2;
	$query=1;
	
}
else if($keys=='model~part~make')
{
	$dtype=3;
	$query=1;
	
}

else if($keys=='make~part~model')
{
	$dtype=4;
	$query=1;
	
}
else if($keys=='part~make~model')
{
	$dtype=5;
	$query=1;
	
}
else if($keys=='part~model~make')
{
	$dtype=6;
	$query=1;
	
}

else if($keys=='make~part')
{
	$dtype=7;
	$query=1;
	
}
else if($keys=='part~make')
{
	$dtype=8;
	$query=1;
	
}
else if($keys=='make')
{
	$dtype=9;
	$query=0;
}

else
{
	$dtype=0;
	$query=0;
}



if(is_numeric($part))
{
	 $sqlpart ="select * from `ptype` where `PartType` ='$part' ";
	 $sqlpartq=mysql_query($sqlpart);
	 $sqlpartr=mysql_fetch_array($sqlpartq);
	 $part=$sqlpartr['Description'];
	 
}
else
{
	
	 $sqlpart ="select * from `ptype` where `Description` ='$part' ";
	 $sqlpartq=mysql_query($sqlpart);
	 $sqlpartr=mysql_fetch_array($sqlpartq);
	 $part=$sqlpartr['Description'];
	
}



if(mysql_num_rows($sqlpartq)!=0)
{
	
  if($query==1)
  {
  $sql ="select distinct min(indexlist.BeginYear) as BeginYear, max(indexlist.EndYear) as EndYear, ptype.Description as pdesc,indexlist.parttype as ptype,indexlist.ModelNm as model from indexlist inner join ptype on ptype.PartType = indexlist.PartType where ptype.Description='$part' ";
  
  if(trim($make)!='')
	{   $makenew=makexref($make);	  
		$sql .=" and indexlist.MfrCd='$makenew' ";

			}
			if($model!='')
			{
				$modelnew=modelxref($model);
				$sql .=" and indexlist.ModelNm='$modelnew'";
			}
  
  $sql .=" order by pdesc asc";
  
  $result = mysql_query($sql);
  $row=mysql_fetch_array($result);
  $lowval = $row['BeginYear'];
  $highval = $row['EndYear'];
  
	  if($lowval=='')
	  {
	  $sql = "select max(CarlineYear) as high,min(CarLineYear) as low from carline";
	  $result = mysql_query($sql);
	  $row = mysql_fetch_array($result);
	  $lowval = $row['low'];
	  $highval = $row['high'];
	  }
	  
  
  
  }
  else
  {
  $sql = "select max(CarlineYear) as high,min(CarLineYear) as low from carline";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $lowval = $row['low'];
  $highval = $row['high'];
  }
	  
	
}
else
{
  $sql = "select max(CarlineYear) as high,min(CarLineYear) as low from carline";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $lowval = $row['low'];
  $highval = $row['high'];
	
}





if(isset($_POST['fs']))
{   
	extract($_POST);
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$source = "";
	
	//print_r($_POST);
	
	if(isset($_POST['mechanics']))
	{
		$wantsrepair=1;
	}
	else
	{
		$wantsrepair=0;
	}
	
    $sql = "insert into requests (date,udate,year,make,model,part,hnumber,hollanderoption,phone,zip,email,source,referrer,kw,se,ip,wantsrepair) values('$date',unix_timestamp(),$year,'$make','$model','$partname','$interchange','$application','$phone','$zip','$email','$source','$_SESSION[referrer]','$_SESSION[kw]','$_SESSION[se]','$ip','$wantsrepair')";
	$que=mysql_query($sql);
	if($que)
	{
		/*echo "<script>alert('Thanks!! We will contact you soon.')</script>";*/
		echo "<script>window.location.href='thanks.php'</script>";	
	}
	
}


?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>Car parts locator</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<link href="js/select2.css" rel="stylesheet"/>
<script src="js/select2.js"></script>
<script>
$(document).ready(function(){
	$("#year").select2({placeholder: "Select Year"});
	$("#make").select2({placeholder: "Select Make"});
	$("#model").select2({placeholder: "Select Model"});
	$("#part").select2({placeholder: "Select Part"});
	$("#partoption0").select2({placeholder: "Part Option"});
	for(a=1; a<12; a++)
	{
	  $("#partoption"+a).select2({placeholder: "Part Option " +a});
	}
});

/*function goback()
{
	document.getElementById('part1').click();
	document.location.hash= '#1';
	document.getElementById('part1').className = 'activeicon showp';
}*/
iam=0;
function getoption(obj,type,uno)
{
  
  if(uno<5)
  {
	document.getElementById("partoption0").innerHTML='<option value=""></option>';
	$('#s2id_partoption0 span.select2-chosen').html('Part Option');
	for(a=1; a<11; a++)
	{
		ccc=a+5
	  document.getElementById("s"+ccc).style.display='none';
	  document.getElementById("partoption"+a).innerHTML= "<option value=''>Select Part Option</option>"
	  $('#s2id_partoption'+a+' span.select2-chosen').html('Part Option');
	}
  }
  
  
  if(uno>=5)
  {
	  bno=uno-4;
	
	
	for(a=bno; a<11; a++)
	{
	  ccc=a+5
	  document.getElementById("s"+ccc).style.display='none';
	  document.getElementById("partoption"+a).innerHTML= "<option value=''>Select Part Option</option>"
	  $('#s2id_partoption'+a+' span.select2-chosen').html('Part Option');
	}
  }
  
  nuno=uno+1;
  
  document.getElementById(nuno+'c').src='img/loader.gif';
  document.getElementById(nuno+'c').style.display='block';
  
	
  cyear=document.getElementById('year').value;
  make=document.getElementById('make').value;
  model=document.getElementById('model').value;
  part=document.getElementById('part').value;
  
  if(type=='partoption1')
  {
	  if(obj=='0')
	  {
	  document.getElementById("part3").className = "blockp";
	  }
  }
  
  if(obj==0)
  {
 	document.getElementById(uno+'c').style.display='none';
  	return false;
  }
  
  if(uno==4)
  {
	  if(obj!='0')
	  {
	  document.getElementById('go_back').innerHTML= '< '+cyear+' '+make+' '+model+' '+document.form1.part.options[document.form1.part.selectedIndex].text;
	  document.getElementById('go_back1').innerHTML= '< '+cyear+' '+make+' '+model+' '+document.form1.part.options[document.form1.part.selectedIndex].text;
	  document.getElementById('part2').click();
	  document.location.hash= '#2';
	  document.getElementById('part2').className = 'activeicon showp';
	  }
  }
  
  if(obj!='0')
  {
	  document.getElementById(uno+'c').src='img/correct.png';
	  document.getElementById(uno+'c').style.display='block';
  }
  
  
  
  
  
  var xmlhttp;
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
	  if(xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		  
		  var coptions = obj.split("|");
	   	  var interchange = coptions.slice(2,3);
 		  if (interchange != "")
 		  {
	 	  document.getElementById('interchange').value=interchange;
 		  }
		  //alert(xmlhttp.responseText);
		  document.getElementById(nuno+'c').style.display='none';
		  returnxml=xmlhttp.responseText
		  if(returnxml=="<option value='0'>Select Part Option 1</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 2</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		  else if(returnxml=="<option value='0'>Select Part Option 3</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 4</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 5</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 6</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 7</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 8</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 9</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 10</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else if(returnxml=="<option value='0'>Select Part Option 11</option>")
		  {
			  
			  document.getElementById('part3').click();
			  document.location.hash= '#3';
			  document.getElementById('part3').className = 'activeicon showp';
			  return false;
		  }
		 else
		  {
			  if(uno>=5)
			  {
				unn=uno+1;
				document.getElementById('s'+unn).style.display='block';
			  }
	  }
	  
	  
	 // document.getElementById(type).innerHTML=xmlhttp.responseText;
	 $('#'+type).html(xmlhttp.responseText);
	  $("#"+type).select2("open");
	  }
  }
  
  xmlhttp.open("GET","getdetail.php?obj="+obj+'&type='+type+'&dtype='+<?php echo $dtype;?>+'&cyear='+cyear+'&make='+make+'&model='+model+'&part='+part,true);
  xmlhttp.send();
  
  
}
</script>


<style>
.blockp {
    pointer-events:none;
}
.showp {
    pointer-events:block;
}
</style>

</head>
<body>


<div class="wrapperbody">
<div class="inwrap">
    <div class="contentbar-1">
       <!-- <p>Find Parts Now.</p>
        <p class="easyPainless">It's quick, easy, and painless!</p>-->
    </div>

<div class="selection-box">
    <form method="post" action="" name="form1" id="form1">
    <div class="part_1 form_part" >
<p><br/></p>
    <!--<img src="img/content-img.png" class="imgcl">
    <h1 class="formTittle small" ><img src="img/carInfo.png" >Car Info</h1>-->


<?php if($dtype==1)
{
?> 

<p style="margin-left:13%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',1)">
    <?php
    $sql = "select distinct hmodelxref.cplMake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($make!=''){?> style="display:block;" <?php } ?> >
</p>

<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',2)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%; margin-top:3%; ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',3)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php
		 }
	}
	?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%; margin-top:3%; margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>

<!--model make part-->
<?php } elseif($dtype==2)
{
?>

<p style="margin-left:13%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',1)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
	?>
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',2)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>



<p style="margin-left:13%; margin-top:3%;">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',3)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php
        }
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%; margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>




<!--model part make-->
<?php } elseif($dtype==3)
{
?>
<p style="margin-left:13%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',1)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%; margin-top:3%;">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',2)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php
		 }
	}
	?>
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',3)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%;margin-top:3%; margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>


<!--make part model-->

<?php } elseif($dtype==4)
{
?>
<p style="margin-left:13%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',1)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%; margin-top:3%; ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',2)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',3)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>


<!--part make model-->

<?php } elseif($dtype==5)
{
?>

<p style="margin-left:13%;  ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',1)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php
        }
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%; margin-top:3%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',2)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',3)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>


<!--part model make-->

<?php } elseif($dtype==6)
{
?>

<p style="margin-left:13%;  ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',1)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where  ModelNm = '".modelxref($model)."' order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$ptype = trim($row['ptype']);
		$pdesc =  trim($row['pdesc']);
		?>
		<option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',2)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>



<p style="margin-left:13%; margin-top:3%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',3)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>



<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>


<!--make part-->

<?php } elseif($dtype==7)
{
?>
<p style="margin-left:13%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',1)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%; margin-top:3%; ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',2)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType order by pdesc asc" ;
    
    $result = mysql_query($sql,$mlink);
    while ($row = mysql_fetch_array($result))
    {
    $ptype = trim($row['ptype']);
    $pdesc =  trim($row['pdesc']);
    ?>
    <option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
    <?php }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>

<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'year',3)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
    ?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>



<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>

<!--part make -->

<?php } elseif($dtype==8)
{
?>

<p style="margin-left:13%;  ">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',1)">
    <option value=""></option> <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType  order by pdesc asc" ;
    
    $result = mysql_query($sql,$mlink);
    while ($row = mysql_fetch_array($result))
    {
    $ptype = trim($row['ptype']);
    $pdesc =  trim($row['pdesc']);
    ?>
    <option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
    <?php }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%; margin-top:3%;"> 
    <select  name="make" id="make" onChange="getoption(this.value,'model',2)">
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
    $result = mysql_query($sql,$mlink);
    
    while ($row = mysql_fetch_array($result))
    {
    $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="2c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>



<p style="margin-left:13%;margin-top:3%;">
    <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',3)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
    $result = mysql_query($sql,$mlink);
    if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		}
	}
	?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>


<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    
    </select> <img src="img/correct.png" class="imgco" id="4c">
</p>
      
      
       <!--make-->
        
<?php } elseif($dtype==9)
  {
  ?>

<p style="margin-left:13%;"> 
   <select  name="make" id="make" onChange="getoption(this.value,'model',1)">
   <?php
   $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd   order by make" ;
   $result = mysql_query($sql,$mlink);
   while ($row = mysql_fetch_array($result))
   {
	   $rmake = trim($row['make']);
   ?>
   <option value="<?php echo $rmake;?>" <?php if($make==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
   <?php
   }
   ?>
   </select> <img src="img/correct.png" class="imgco" id="1c" <?php if($make!=''){?> style="display:block;" <?php } ?>>
</p>
  
 

<p style="margin-left:13%;margin-top:3%;">
	<select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',2)">
	<option value=""></option>
	<?php
	$sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make'  order by Model" ;
	$result = mysql_query($sql,$mlink);
	if(mysql_num_rows($result)>0)
	{
		while ($row = mysql_fetch_array($result))
		{
		$rmodel = trim($row['model']);
		?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model){?> selected <?php }?> ><?php echo $rmodel;?></option>
	   <?php 
		}
	}
	?>
	</select> <img src="img/correct.png" class="imgco" id="2c" <?php if($model!=''){?> style="display:block;" <?php } ?>>
</p>
   
   
<p style="margin-left:13%; margin-top:3%;">
    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'year',3)">
    <option value=""></option>
    <?php
    $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType order by pdesc asc" ;
    $result = mysql_query($sql,$mlink);
    while ($row = mysql_fetch_array($result))
    {
    $ptype = trim($row['ptype']);
    $pdesc =  trim($row['pdesc']);
    ?>
    <option value="<?php echo $ptype; ?>" <?php if($pdesc==$part){?> selected <?php }?> ><?php echo $pdesc;?></option>
    <?php }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="3c" <?php if($part!=''){?> style="display:block;" <?php } ?>>
</p>             
					 
  
   
<p style="margin-left:13%;margin-top:3%;margin-bottom:3%;">
    <select name="year" id="year" onChange="getoption(this.value,'partoption0',4)" >
    <option value=""></option>
    <?php
    for  ($i=$highval;$i>=$lowval;$i--)	
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="4c">

</p>


<!--Default-->
<?php }else{?> 


<p style="margin-left:13%;"> <select name="year" id="year" onChange="getoption(this.value,'make',1)" >
    <option value=""></option>
    <?php
    for($i=$highval;$i>=$lowval;$i--)
    {
    ?>
    <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
    <?php
    }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="1c">
</p>
            
<p style="margin-left:13%;margin-top:3%;">
    <select  name="make" id="make" onChange="getoption(this.value,'model',2)">
    <option value=""></option>
    <?php
    $sql = "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". $year1. " order by make" ;
    $result = mysql_query($sql,$mlink);
    while ($row = mysql_fetch_array($result))
    {
      $rmake = trim($row['make']);
    ?>  
    <option value="<?php echo $rmake;?>" <?php if($make1==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
    <?php 
    }
    ?>
    </select> <img src="img/correct.png" class="imgco" id="2c">
</p>
            
 <p style="margin-left:13%;margin-top:3%;">
     <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part',3)">
     <option value=""></option>
     <?php
     $sql = "select distinct hmodelxref.cplmodel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.cplmake = '$make1' and carline.CarLineYear = '$year1' order by Model" ;
     $result = mysql_query($sql,$mlink);
     if(mysql_num_rows($result)>0)
	 {
		 while ($row = mysql_fetch_array($result))
		 {
		 $rmodel = trim($row['model']);
		 ?>
		<option value="<?php echo $rmodel; ?>" <?php if($rmodel==$model1){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		 }
	 }
     ?>
     </select> <img src="img/correct.png" class="imgco" id="3c">
 </p>
            
 <p style="margin-left:13%; margin-top:3%; margin-bottom:3%;">
     <select class="slectBox select_box populate select2-offscreen" name="part" id="part" onChange="getoption(this.value,'partoption0',4)">
     <option value=""></option>
     <?php		
     $sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where $year1 between beginyear and endyear and ModelNm = '".modelxref($model1)."' order by pdesc asc" ;
     $result = mysql_query($sql,$mlink);
	 if(mysql_num_rows($result)>0)
	 {
		 while ($row = mysql_fetch_array($result))
		 {
		  $ptype = trim($row['ptype']);
		  $pdesc =  trim($row['pdesc']);
		 ?>
		 <option value="<?php echo $ptype; ?>" <?php if($ptype==$part1){?> selected <?php }?> ><?php echo $pdesc;?></option>
		 <?php
		 }
	 }
     ?>
     </select><img src="img/correct.png" class="imgco" id="4c">
 </p>
  
<?php } ?>
        
         
         
         
         
                    </div>
                    <div class="part_2 form_part">
                    <p><br/></p>
                     <!--<img src="img/content-img.png" class="imgcl">
					<h1 class="formTittle small"><img src="img/selectpart.png" >Part option</h1> -->
                    <p class="go_back" id="go_back"></p>
                    <p style="margin-left:13%;"> <select class="slectBox select_box"  name="partoption0" id="partoption0" onChange="getoption(this.value,'partoption1',5)">
                     <option value=''>Select Part Option</option>
                        
                    </select> <img src="img/correct.png" class="imgco" id="5c">
                    </p>
                    
                    <?php for($a=1; $a<11; $a++ )
				   {$b=$a+1;
				   $c=$a+5
					?>
                   
                   <div style="display:none;margin-left:13%;margin-top:3%;" id="s<?php echo $c;?>">  <select class="slectBox select_box"  name="partoption<?php echo $a;?>" id="partoption<?php echo $a;?>" onChange="getoption(this.value,'partoption<?php echo $b;?>',<?php echo $c;?>)" >
                        <option value="">Part Option <?php echo $a;?></option>
                     </select> <img src="img/correct.png" class="imgco" id="<?php echo $c;?>c">

                     </div>
                   
                    <?php }?>
                    <br>
                    </div>
                    <div class="part_3 form_part">
		    <p><br/></p>
                    <!--<img src="img/content-img.png" class="imgcl">
                    <h1 class="formTittle small"><img src="img/contactUs.png" >Contact Info</h1>-->
                    <p class="go_back" id="go_back1" ></p>
                    <!-- <input type="text" name="phone" id="phone" class="inputbox" placeholder="Phone Number" required="true" >-->
                     <input type="email" name="email" id="email" class="inputbox" placeholder="Email Address"  required="true">
                     <input type="text" name="zip" id="zip" class="inputbox" placeholder="Zip Code" required ><br/>
                   <input type="checkbox" name="mechanics" id="mechanics" class="checkbox" placeholder="Mechanics" required checked="true">Receive offers on installation
		     <input type="hidden" name="fs" id="fs" value="1">
                     <input type="hidden" value="" name="interchange" id="interchange"/>
		     <input type="hidden" value="" name="application" id="application"/>
                     <input type="hidden" id="partname" name="partname" value=""/>
                     <input type="hidden" name="cttt" id="cttt">
                     <input type="image" src="img/inputbg.png" style="display:none;">
                     <p class="part_3_Para"><button class="button" type="submit" onClick="return submitform();">Submit</button></p>
                    </div>
                    <div align="center" class="form_button">
                    	<a href="part_1" id="part1"  class="activeicon"  onClick="document.location.hash= '#1'"  ></a>
                        <a href="part_2" id="part2"  class="blockp" onClick="document.location.hash= '#2'" ></a>
                        <a href="part_3" id="part3" class="blockp" onClick="document.location.hash= '#3'"></a>
                        
                        
                        
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
  <div class="foot"><span> &copy; Copyright - Car Parts Locator - Enfold Theme by Kriesi</span> 
    <span style="float: right;margin-right: 35px;margin-top: -14px;">FAQ | Terms & Conditions | Privacy Policy | Contact</span></div>  
   
</body>


<script type="text/javascript">
$(function(){
	
	var gb = $(".go_back");
	gb.click(function(){
		if($(".form_part:visible").hasClass("part_2")){
			$(".form_part").hide();
			document.location.hash= '#1';
			document.getElementById('part2').className = 'blockp';
			document.getElementById('part1').className = 'activeicon showp';
			$(".part_1").show();
			}
			else if($(".form_part:visible").hasClass("part_3")){
			$(".form_part").hide();
			document.location.hash= '#2';
			document.getElementById('part3').className = 'blockp';
			document.getElementById('part2').className = 'activeicon showp';
			$(".part_2").show();
			
			}
	});


		
	
	var icon= $(".form_button a");
	icon.click(function(){
		icon.removeClass("activeicon");
		$(this).addClass("activeicon")
		})
		
		
	var a = $(".form_button a");
	a.click(function(e){
		var error = false;
		e.preventDefault();
		var b = $(this).attr("href");
		$(".form_part").hide().fadeIn('slow');
		$("."+b).show();
		});
	});



$(window).on('hashchange', function() {
  
  if(document.location.hash=='')
  {
	  $(".form_part").hide();
	  document.getElementById('part1').className = 'activeicon showp';
	  document.getElementById('part2').className = 'showp';
	  document.getElementById('part3').className = 'showp';
	  $(".part_1").show();
  }
  if(document.location.hash=='#1')
  {
	  $(".form_part").hide();
	  document.getElementById('part1').className = 'activeicon showp';
	  document.getElementById('part2').className = 'showp';
	  document.getElementById('part3').className = 'showp';
	  $(".part_1").show();
  }
  if(document.location.hash=='#2')
  {
	  $(".form_part").hide();
	  document.getElementById('part2').className = 'activeicon showp';
	  document.getElementById('part1').className = 'showp';
	  document.getElementById('part3').className = 'showp';
	  $(".part_2").show();
  }
  if(document.location.hash=='#3')
  {
	  $(".form_part").hide();
	  document.getElementById('part3').className = 'activeicon showp';
	  document.getElementById('part1').className = 'showp';
	  document.getElementById('part2').className = 'showp';
	  $(".part_3").show();
  }
  
  
});	
	
</script>
<script type="text/javascript">

$(function(){

var hei = $(document).height();
$(".popup_wrapper").height(hei);
$(".upload_design").click(function(e){
e.preventDefault();
$(".popup_wrapper").slideDown();	
});
$(".popup_wrapper .cross").click(function(){
$(".popup_wrapper").slideUp();
});
});


function IsEmail(val)
{
	val1=document.getElementById(val).value
	//this is a regular expression
	var u = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var c=u.test(val1);	
	if(c)
	{
	 Highlight(val,'#BBBBBB');
	return true;
	}
	else
	{
		Highlight(val,'red');
	return false;
	}
}
function selectcon(obj)
{
	if(document.getElementById(obj).value=='')
	{
		Highlight(obj,'red');

		return false;
	}
	else
	{
		Highlight(obj,'#BBBBBB');

		return true;
	}
}
function Highlight(obj,col)
{
	document.getElementById(obj).style.border = col+' 1px solid';
	
}


function submitform(thisform)
{
	
var er=0;
var foc ='';

	if (IsEmail('email')==false)
		{ 
			
			if(er==0)
			foc = 'email';
			er=1;
		}
		if (selectcon('zip')==false)
		{ 
			
			if(er==0)
			foc = 'zip';
			er=1;
		}
		if(er==1)
		{
				
				document.getElementById(foc).focus();
				return false;
		}
			
		else
		{	
	
			var coptions = "";
			
			for (var i=0;i<=11;i++)
			{
			var option = 'partoption'+i;
			var obj = eval('{document.form1.' + option + '}');
			if (typeof(obj) == "object")
			{
			if(obj.options[obj.selectedIndex].value!='')
			{
			if (i==0)
			{
			coptions = "[" + obj.options[obj.selectedIndex].text;	
			}else
			{
			coptions = coptions + ", " + obj.options[obj.selectedIndex].text;
			}
			}
			
			}
			}
			
			coptions = coptions + "]";
			document.form1.partname.value = document.form1.part.options[document.form1.part.selectedIndex].text;
			document.getElementById('application').value=coptions;
			document.forms["form1"].submit();
			return true;
		
		}
}


</script>



</html>

 </div>   

<script>
$(document).bind(
'touchmove',
function(e) {
e.preventDefault();
}
);
</script>
 
 <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2096092-53']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  
  <!-- Google Code for IUAP Lead Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1070872026;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "9khiCNzOuggQ2uvQ_gM";
var google_remarketing_only = false;
/* ]]> */
</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>

<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1070872026/?label=9khiCNzOuggQ2uvQ_gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


</script>

 
</body>
</html>
