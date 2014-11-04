<?php
session_start();
$year1= @$_GET['year1'];
$make1= @$_GET['make1'];
$model1= @$_GET['model1'];
$part1= @$_GET['part1'];

$_SESSION['cyear']=$year1;
$_SESSION['cmake']=$make1;
$_SESSION['cmodel']=$model1;
$_SESSION['cpart']=$part1;

$mdb_username = "rtanner2_38";
$mdb_password = "BHeFVC7i";
$mdb_database = "rtanner2_cpl";
$mdb_host="qs3505.pair.com" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

$sql = "select max(CarlineYear) as high,min(CarLineYear) as low from carline";
        $result = mysql_query($sql);
  	  	$row = mysql_fetch_array($result);
		$lowval = $row['low'];
		$highval = $row['high'];


if(isset($_POST['fs']))
{   
	extract($_POST);
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$source = "";
	
	$sql = "insert into requests (date,year,make,model,part,hnumber,hollanderoption,phone,zip,email,source,referrer,kw,se,ip) values('$date',$year,'$make','$model','$partname','$interchange','$application','$phone','$zip','$email','$source','$_SESSION[referrer]','$_SESSION[kw]','$_SESSION[se]','$ip')";
	
	echo "<script>alert('Thanks!! We will contact you soon.')</script>";
	echo "<script>window.location.href='/'</script>";	
	
}
function modelxref($aphmodel)
{
	$lcsql = "select distinct HModel from hmodelxref where AphModel = '$aphmodel' limit 1";
	$result = mysql_query($lcsql);
	$row = mysql_fetch_array($result);
	return $row['HModel'];
}

?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car parts locator</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<script>
function getoption(obj,type)
{
document.getElementById(type).innerHTML = '<option value="">Loading...</option>';



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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    // alert(xmlhttp.responseText);
	 returnxml=xmlhttp.responseText
	 
	if(type=='partoption0')
	{
		
		document.getElementById("part2").className = "activeicon showp";
	}
	
	else if(returnxml=="<option value=''>Select Part Option 1</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 2</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 3</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 4</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 5</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 6</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 7</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 8</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 9</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 10</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else if(returnxml=="<option value=''>Select Part Option 11</option>")
	{
		document.getElementById('part3').click();
		document.location.hash= '#3';
		document.getElementById('part3').className = 'activeicon showp';
	}
	else
	{
		document.getElementById(type).style.display='block';
	}
	
		var coptions = obj.split("|");
		var interchange = coptions.slice(2,3);
		if (interchange != "")
		{
		document.getElementById('interchange').value=interchange;
		}
	
	 document.getElementById(type).innerHTML=xmlhttp.responseText;
	 if(xmlhttp.responseText !="<option value=''>Make</option>")
	 {
	 runThis(type)
	 }
	 
    }
  }
xmlhttp.open("GET","/testdemo/getdetail.php?obj="+obj+'&type='+type,true);
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
	<div class="wrapperheader">
    	<div class="inwrap">
        	<div align="center" class="header-img">
            	<img src="/testdemo/img/car-parts-locator.png" alt="img"  />
            </div>
        </div>
    </div>
    <div class="wrapperbody">
    	<div class="inwrap">
        	<div class="contentbar-1">
            	<p>Find Parts Now.</p>
                <p class="easyPainless">It's quick, easy, and painless!</p>
            </div>
            
            <div class="selection-box">
            	<!--<p class="go_back">< back to Make Select</p>-->
                <p class="carinfo"></p>
                <form method="post" action="" name="form1" id="form1">
                
                	<div class="part_1 form_part" <?php if($part1!=''){?> style="display:none;" <?php }?>>
                    <h1 class="formTittle small"><img src="/testdemo/img/carInfo.png" >Car Info</h1>
                    <select class="slectBox select_box year_1" name="year" id="year" onChange="getoption(this.value,'make')">
                        <option value="">Year</option>
                        <?php
						for  ($i=$highval;$i>=$lowval;$i--)	
						{
						?>
                        <option value="<?php echo $i;?>" <?php if($year1==$i){?> selected <?php }?>><?php echo $i;?></option>
						<?php
                        }
						?>
    
                    </select> 
                    
                    <select class="slectBox select_box" name="make" id="make" onChange="getoption(this.value,'model')">
                         <?php if($part1==''){?> <option value="">Make</option> <?php }else{
							 
				 $sql = "select distinct hmodelxref.AphMake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd  where carline.CarlineYear = ". $year1. " order by make" ;
    		  $result = mysql_query($sql,$mlink);
			  echo"<option value=''>Select Make</option>";
			  while ($row = mysql_fetch_array($result))
			  {
				  $rmake = trim($row['make']);
			?>  
				 <option value=<?php echo $rmake;?> <?php if($make1==$rmake){?> selected <?php }?> ><?php echo $rmake ?></option>
			<?php 
			  }
			  }?>
                       
                    </select> 
                    
                     <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part')">
                         <?php if($part1==''){?> <option value="">Model</option> <?php }else{
							 
							 
							 $sql = "select distinct hmodelxref.AphModel as model from carline inner join hmodelxref on hmodelxref.Hmodel = carline.ModelNm where hmodelxref.AphMake = '$make1' and carline.CarLineYear = '$year1' order by Model" ;
         $result = mysql_query($sql,$mlink);
         echo"<option value=''>Select Model</option>";
		 while ($row = mysql_fetch_array($result))
         {
         $rmodel = trim($row['model']);
		 ?>
		<option value=<?php echo $rmodel; ?> <?php if($rmodel==$model1){?> selected <?php }?> ><?php echo $rmodel;?></option>
		<?php 
		 }
							 
							  }?>
                        
                       
                    </select> 
                    
                    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'partoption0'),document.getElementById('part2').click(),document.location.hash= '#2'">
                        <?php if($part1==''){?> <option value="">Part</option> <?php }else{ 
						
						$sql = "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where $year1 between beginyear and endyear and ModelNm = '".modelxref($model1)."' order by pdesc asc" ;
		 echo"<option value=''>Select Part</option>";
		 $result = mysql_query($sql,$mlink);
         while ($row = mysql_fetch_array($result))
         {
          $ptype = trim($row['ptype']);
          $pdesc =  trim($row['pdesc']);
		 ?>
         <option value=<?php echo $ptype; ?> <?php if($ptype==$part1){?> selected <?php }?> ><?php echo $pdesc;?></option>
		 
		 
         <?php }
						
						}?>
                        
                                           </select> 
                    </div>
                    <div class="part_2 form_part" <?php if($part1!=''){?> style="display:block;" <?php }?>>
					<h1 class="formTittle small"><img src="/testdemo/img/selectpart.png" >Part option</h1> 
                    <select class="slectBox select_box"  name="partoption0" id="partoption0" onChange="getoption(this.value,'partoption1')">
                         <?php if($part1==''){?> <option value="Part option">Part Option</option> <?php }else{ 
						 
						 echo "<option value=''>Select Part Option</option>";
                         
						 $sql2 ="select indexlistapp.* from indexlist inner join indexlistapp on indexlist.IndexListId = indexlistapp.indexlistid where ".$year1." between indexlist.beginyear and indexlist.endyear and indexlist.modelnm = '".modelxref($model1)."' and indexlist.parttype = '$part1' and indexlistapp.treelevel =1;" ;
         $result = mysql_query($sql2);
		 
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
                         
                         
                         
                         }?>
                        
                    </select> 
                    
                    
                    <?php for($a=1; $a<11; $a++ )
				   {$b=$a+1;
					?>
                     <select class="slectBox select_box"  name="partoption<?php echo $a;?>" id="partoption<?php echo $a;?>" onChange="getoption(this.value,'partoption<?php echo $b;?>')" style="display:none;">
                        <option value="">Part Option <?php echo $a;?></option>
                     </select>
                   
                    <?php }?>
                    
                    </div>
                    <div class="part_3 form_part">
                    <h1 class="formTittle small"><img src="/testdemo/img/contactUs.png" >Contact Info</h1>
                    <!-- <input type="text" name="phone" id="phone" class="inputbox" placeholder="Phone Number" required="true" >-->
                     <input type="email" name="email" id="email" class="inputbox" placeholder="Email Address"  required="true">
                     <input type="text" name="zip" id="zip" class="inputbox" placeholder="Zip Code" required="true" >
                     <input type="hidden" name="fs" id="fs" value="1">
                     <input type="hidden" value="" name="interchange" id="interchange"/>
		             <input type="hidden" value="" name="application" id="application"/>
                     <input type="hidden" id="partname" name="partname" value=""/>
                     <input type="image" src="/testdemo/img/inputbg.png" style="display:none;">
                     <p class="part_3_Para"><button class="button" type="submit">Submit</button></p>
                    </div>
                    <div align="center" class="form_button">
                    	<a href="part_1"  <?php if($part1!=''){?> class="activeicon" <?php }else{?> class="activeicon" <?php }?> onClick="document.location.hash= '#1'"  ></a>
                        <a href="part_2" id="part2" <?php if($part1!=''){?> class="activeicon" <?php }else{?> class="blockp" <?php }?>onClick="document.location.hash= '#2'" ></a>
                        <a href="part_3" id="part3" class="blockp" onClick="document.location.hash= '#3'"></a>
                        
                        
                        
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</body>


<script type="text/javascript">
$(function(){
	
	var gb = $(".go_back");
	gb.click(function(){
		if($(".form_part:visible").hasClass("part_2")){
			$(".form_part").hide();
			$(".part_1").show();
			}else if($(".form_part:visible").hasClass("part_3")){
			$(".form_part").hide();
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
		$(".form_part").hide();
		$("."+b).show();
		});
	});
	
	
</script>
<script type="text/javascript">

$(function(){
	//PlaceholderFix();
	$(".select_box").selectBox({
		mobile: true
		});
		
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
	
	function submitform()
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
	}



function showDropdown(element) {
    var event;
    event = document.createEvent('MouseEvents');
    event.initMouseEvent('mousedown', true, true, window);
    element.dispatchEvent(event);
};

// This isn't magic.
function runThis(obj) { 
    var dropdown = document.getElementById(obj);
    showDropdown(dropdown);
};



</script>


</html>
