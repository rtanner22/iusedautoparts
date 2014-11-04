
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

</script>

<select name="year" id="year" onChange="getoption(this.value,'make',1)" >
    </select>
