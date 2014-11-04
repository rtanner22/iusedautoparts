// JavaScript Document
// @Developer : Vikas Rana
// @website:http://www.ranaji.in

$(document).ready(function(){
	$("#year").select2({placeholder: "Year"});
	$("#make").select2({placeholder: "Make"});
	$("#model").select2({placeholder: "Model"});
	$("#part").select2({placeholder: "Part"});
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

function getoption(obj,type,uno)
{
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
	  
	  
	  document.getElementById(type).innerHTML=xmlhttp.responseText;
	  $("#"+type).select2("open");
	  }
  }
  
  xmlhttp.open("GET","getdetail.php?obj="+obj+'&type='+type+'&dtype='+<?php echo $dtype;?>+'&cyear='+cyear+'&make='+make+'&model='+model+'&part='+part,true);
  xmlhttp.send();
  
  
}