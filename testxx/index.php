<?php
$mdb_username = "iusedparts";
$mdb_password = "5huYvRDH";
$mdb_database = "iusedparts";
$mdb_host="192.168.200.100" ;
$mlink = mysql_connect($mdb_host,$mdb_username,$mdb_password);
mysql_select_db("$mdb_database", $mlink);

$sql = "select max(CarlineYear) as high,min(CarLineYear) as low from carline";
        $result = mysql_query($sql);
  	  	$row = mysql_fetch_array($result);
		$lowval = $row['low'];
		$highval = $row['high'];


if(isset($_POST['fs']))
{   extract($_POST);
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$sql = "insert into requests (date,year,make,model,part,hollanderoption,phone,zip,email,ip) values('$date','$year','$make','$model','$part','$partoption','$phone','$zip','$email','$ip')";
	$result = mysql_query($sql);
	
	echo "<script>alert('Thanks!! We will contact you soon.')</script>";
	echo "<script>window.location.href='/'</script>";	
	
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
	if(type=='partoption')
	{
		
		document.getElementById("part2").className = "activeicon showp";
	}
	 document.getElementById(type).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getdetail.php?obj="+obj+'&type='+type,true);
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
            	<img src="img/car-parts-locator.png" alt="img"  />
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
                
                	<div class="part_1 form_part">
                    <h1 class="formTittle small"><img src="img/carInfo.png" >Car Info</h1>
                    <select class="slectBox select_box year_1" name="year" id="year" onChange="getoption(this.value,'make')">
                        <option value="">Year</option>
                        <?php
						for  ($i=$highval;$i>=$lowval;$i--)	
						{
						?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
						<?php
                        }
						?>
    
                    </select> 
                    
                    <select class="slectBox select_box" name="make" id="make" onChange="getoption(this.value,'model')">
                        <option value="">Make</option>
                       
                    </select> 
                    
                     <select class="slectBox select_box" name="model" id="model" onChange="getoption(this.value,'part')">
                        <option value="">Model</option>
                       
                    </select> 
                    
                    <select class="slectBox select_box" name="part" id="part" onChange="getoption(this.value,'partoption'),document.getElementById('part2').click()">
                        <option value="">Part</option>
                                           </select> 
                    </div>
                    <div class="part_2 form_part">
					<h1 class="formTittle small"><img src="img/selectpart.png" >Part option</h1> 
                    <select class="slectBox select_box"  name="partoption" id="partoption" onChange="document.getElementById('part3').click(),document.getElementById('part3').className = 'activeicon showp';">
                        <option value="Part option">Part Option</option>
                       
                    </select> 
                    
                    </div>
                    <div class="part_3 form_part">
                    <h1 class="formTittle small"><img src="img/contactUs.png" >Contact Info</h1>
                     <input type="text" name="phone" id="phone" class="inputbox" placeholder="Phone Number" required="true" >
                     <input type="email" name="email" id="email" class="inputbox" placeholder="Email Address"  required="true">
                     <input type="text" name="zip" id="zip" class="inputbox" placeholder="Zip Code" required="true" >
                     <input type="hidden" name="fs" id="fs" value="1">
                     <input type="image" src="img/inputbg.png" style="display:none;">
                     <p class="part_3_Para"><button class="button" type="submit">Submit</button></p>
                    </div>
                    <div align="center" class="form_button">
                    	<a href="part_1" class="activeicon"  ></a>
                        <a href="part_2" id="part2" class="blockp" ></a>
                        <a href="part_3" id="part3" class="blockp"></a>
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
/*function PlaceholderFix(){
if(!('placeholder'in document.createElement("input"))){
$('[placeholder]').focus(function() {
  var input = $(this);
  if (input.val() == input.attr('placeholder')) {
    input.val('');
    input.removeClass('placeholder');
  }
}).blur(function() {
  var input = $(this);
  if (input.val() == '' || input.val() == input.attr('placeholder')) {
    input.addClass('placeholder');
    input.val(input.attr('placeholder'));
  }
}).blur();
	
}	
}	*/	

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
		document.forms["form1"].submit();
	}
</script>
</html>
