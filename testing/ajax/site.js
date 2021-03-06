$(function(){
    window.cars ={
        selectedManufacture:"",
        selectedCarYear:"",
        selectedModel:"",
        selectedPart:"",
        selectedOption:"",


        init : function(){
            var params = { carYears:1 };
            var data = this.getCarsData( params );
            if( data )
            {
                this.carYears( data );
            }
        },
        prepareData : function(data,sourceId,name){
            this.source[sourceId].items = [];
            var newData = JSON.parse(data);
            for (var d in newData)
                this.source[sourceId].items.push({label:""+newData[d][name]});
            this.render();
        },
        carYears : function(years)
        {
            var newYears = JSON.parse(years);
            var yearsList = $('#box-year');
            yearsList.empty();
            for (var y in newYears)
            {
                if(newYears[y].CarlineYear==$('#preload-year').val())
                yearsList.append('<option selected="selected"><a href="#">'+newYears[y].CarlineYear+'</a></option>')
        else
                  yearsList.append('<option><a href="#">'+newYears[y].CarlineYear+'</a></option>');
            }
        },
        carMakes : function(){
            var makers = this.getCarsData({label:this.selectedCarYear});
            if(makers)
            {
                var makersList = $('#box-make');
                makersList.empty();
                makers = JSON.parse(makers);
                for(var m in makers)
                {
                      makersList.append('<option><a href="#">'+makers[m].manufacture+'</a></option>')

                }
                $('#group-make .select2-chosen').text("Make");
                $('#group-model .select2-chosen').text("Model");
                $('#group-part .select2-chosen').text("Part");
            $('#box-make').select2('open');
            }
        },
        carModel : function(data){
            var models = this.getCarsData({ manufacture:this.selectedManufacture, year:this.selectedCarYear});
            if(models)
            {
                var modelsList = $('#box-model');
                modelsList.empty();
                models = JSON.parse(models);
                for(var m in models)
                {
                    modelsList.append('<option><a href="#">'+models[m].model+'</a></option>')
                }
                console.log(models);
                $('#group-model .select2-chosen').text("Model");
                $('#group-part .select2-chosen').text("Part");
            $('#box-model').select2('open');

            }
        },
        carPart: function(){
            console.log(this)
            var parts = this.getCarsData({carModel:this.selectedModel, year:this.selectedCarYear});
            if(parts)
            {
                console.log(parts);
                var partsList = $('#box-part');
                partsList.empty();
                parts = JSON.parse(parts);
                for(var p in parts)
                {
                    partsList.append('<option value="'+parts[p].part.id+'"><a data-part_id="'+parts[p].part.id+'" href="#">'+parts[p].part.desc+'</a></option>');
                }
                $('#group-part .select2-chosen').text("Part");
            $('#box-part').select2('open');

            }
        },
        getOptions: function(){
        var options = this.getCarsData({partOptions:1,year:this.selectedCarYear, model:this.selectedModel, part:this.selectedPart});
            if( options )
            {
                console.log( options );
                var optionsList = $('#group-options .dropdown-menu');
                optionsList.empty();

                options = JSON.parse(options);

                // prepare the data
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'id' },
                        { name: 'parentid' },
                        { name: 'text' },
                        { name: 'value' }
                    ],
                    id: 'id',
                    localdata: options
                };
                //$('#optionvalue').jqxTree('destroy');
                // create data adapter.
                var dataAdapter = new $.jqx.dataAdapter(source);
                // perform Data Binding.
                dataAdapter.dataBind();
                // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents
                // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter
                // specifies the mapping between the 'text' and 'label' fields.
                var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);

                $('#optionvalue').jqxTree({ source: records});

        $(".jqx-tree-item").mouseenter(function (event) {
          var item = $('#optionvalue').jqxTree('getItem', $(event.target.parentElement)[0]);
          if (item.hasItems == true) {
            $(event.target).removeClass("jqx-fill-state-hover");
            $(event.target).removeClass("jqx-fill-state-hover-" + theme);
          }
        });
            }
        },
        getCarsData : function(params){
            var that = this;
            var response ="";

            $.ajax({
                async:false,
                type:'post',
                url:"http://www.iusedautoparts.dev.gbksoft.net/testing/ajax/index.php",
                data: params,
                success:function(resp){
                    if(resp)
                    {
                        response = resp;
                    }
                    else response = false;
                }
            });
            return response;
        }
    }
    cars.init();

  InitPrimarySearch();
  InitSecondarySearch();
  ShowProgress();
  ResetStates();
  //preload();

  $("#btn-change-search").click(function() { // preloading form values triggered by opening the "CHANGE SEARCH" box on the /inventory page
    $( this ).find('.fa').toggleClass('fa-chevron-up fa-chevron-down');
            $("#banner #group-options .btn-dropdown").addClass("active");
            $("#banner #group-options").slideDown("slow");
            $("#banner #group-options .btn-group").addClass("open");
      preload_year();
      preload_make();
      preload_model();
      preload_part();

  });

  if($("#preload-ppc").val()=="true") { // preloading form values upon initial page load when needed
    var preloads= [];
    if ($('#preload-year').val()!=undefined&&$('#preload-year').val()!="") {
      create_yearbox();
      $("#box-year").select2({placeholder: "Year"});
      preload_year();
    } else { preloads[preloads.length] = "year"; }
    if ($('#preload-make').val()!=undefined&&$('#preload-make').val()!="") {
      create_makebox();
      $("#box-make").select2({placeholder: "Make"});
      preload_make();
    } else { preloads[preloads.length] = "make"; }
    if ($('#preload-model').val()!=undefined&&$('#preload-model').val()!="") {
      create_modelbox();
      $("#box-model").select2({placeholder: "Model"});
      preload_model();
    } else { preloads[preloads.length] = "model"; }
    if ($('#preload-part').val()!=undefined&&$('#preload-part').val()!="") {
      create_partbox();
      $("#box-part").select2({placeholder: "Part"});
      preload_part();
    } else { preloads[preloads.length] = "part"; }


    $("#step1").append('<div id="group-button-option" class="form-group"><button id="btn-choose" type="submit" class="btn btn-orange btn-block" data-target="#search-form" data-slide-to="1">CHOOSE OPTIONS <i class="fa fa-arrow-right"></i></button></div>');
  }

});

function InitPrimarySearch() {

  $("#banner #group-year .btn-dropdown").addClass("active");

  //Select Year
  $('#box-year').click(function(e){
          cars.selectedCarYear = $(this).val();
    $("#banner #group-year .btn-dropdown").removeClass("active");

    $("#banner #group-make .btn-dropdown").addClass("active");
        cars.carMakes();
  });

  //Select Make
  $("#box-make").click(function(e){
            e.preventDefault();
            cars.selectedManufacture = $(this).val();
            $("#banner #group-make .btn-dropdown").removeClass("active");
            $("#banner #group-model .btn-dropdown").addClass("active");
            cars.carModel();

  });

  //Select Model
  $("#box-model").click(function(e){

            e.preventDefault();
            cars.selectedModel = $(this).val();
            console.log("selectedModel");
            console.log($(e.target).text());
             // $(this).parents(".btn-group").find('.selection').text($(e.target).text());
             // $(this).parents(".btn-group").find('.selection').val($(e.target).text());
            $("#banner #group-model .btn-dropdown").removeClass("active");

            $("#banner #group-part .btn-dropdown").addClass("active");
            cars.carPart();
  });

  //Select Part
  $("#box-part").click(function(e){
            e.preventDefault();

            $("#banner #group-part .btn-dropdown").removeClass("active");
            $("#step1-title").slideUp();
            var year = $("#box-year").val().toUpperCase();
            var make = $("#box-make").val().toUpperCase();
            var model = $("#box-model").val().toUpperCase();

            var part = $("#box-part option:selected").html().toUpperCase();

            $("#step2-title").html("<h2><span class='text-orange'>" + part + "</span> for a <span class='text-orange'>" + year + "</span> <span class='text-orange'>" + make + "</span> <span class='text-orange'>" + model + "</span></h2>");
            $("#step2-title").slideDown("slow");

            $("#banner #group-options .btn-dropdown").addClass("active");
            $("#banner #group-options").slideDown("slow");
            $("#banner #group-options .btn-group").addClass("open");

            //Indicator
            $(".line-indicator").removeClass("step1").addClass("step2");
            $(".indicators li:first-child").removeClass("active");
            $(".indicators  li:nth-child(2)").addClass("active");
            //cars.selectedPart = $(e.target).data('part_id');
            cars.selectedPart = document.getElementById('box-part').value;
      document.getElementById('partname').value  = part;
            cars.getOptions();

  });

  //Select Options

var selection = null;
  $('#optionvalue').on('select', function (e) {
            e.preventDefault();
    var htmlElement = e.args.element;
    var item = $('#optionvalue').jqxTree('getItem', htmlElement);
    if (item.hasItems == true) {
      $('#optionvalue').jqxTree('selectItem', selection);
                    if (item.isExpanded == true) {
                        $("#optionvalue").jqxTree('collapseItem', item);
                    } else {
                  $("#banner #group-options .btn-group").addClass("open");
                        $("#optionvalue").jqxTree('expandItem', item);
                    }
    } else {
      selection = item;
            e.preventDefault();
            $("#banner #group-options .btn-dropdown").removeClass("active");
            $("#optionvalue").slideUp("slow");

            $("#banner #group-zip").slideDown("slow");

    var optvalue = $("#optionvalue").val();
    var hoption;
    hoption = optvalue.label;
    interchange = optvalue.value;
    if(optvalue.parentElement) {

      var parent= $('#optionvalue').jqxTree('getItem', optvalue.parentElement);
      hoption += "," +  parent.label;
      if(parent.parentElement) {
        var grandparent= $('#optionvalue').jqxTree('getItem', parent.parentElement);
        hoption = grandparent.label +  "," + hoption;
        if(grandparent.parentElement) {
          var greatgrandparent= $('#optionvalue').jqxTree('getItem', grandparent.parentElement);
          hoption = greatgrandparent.label + "," + hoption;
        }
      }
    }

    document.getElementById('hollanderoption').value = hoption;
              $(this).parents(".btn-group").find('.selection').text(hoption);
              $(this).parents(".btn-group").find('.selection').val($(e.target).text());
        $("#optionvalue").val(interchange);
            //Indicator
            $(".line-indicator").removeClass("step2").addClass("step3");
            $(".indicators li:nth-child(2)").removeClass("active");
            $(".indicators  li:last-child").addClass("active");
            cars.selectedOption = $(e.target).data('value');
    }
  });

  $("#banner #group-options .btn-dropdown").click(function(e){

         if($("#optionvalue").css('display') == "none") {
           $("#optionvalue").slideDown("slow");
     } else {
           $("#optionvalue").slideUp("slow");
     }

  });

  $( "#zip" ).focus(function() {
    $("#banner #group-button").slideDown("slow");
  });

  $("#btn-check").click(function(e) {
    e.preventDefault();
    if(document.getElementById('zip').value.length != 5) {
      alert("Please provide a five-digit zip code.");
    } else {
      $('#modal-progress').modal({
        backdrop: 'static',
        show: true
      });
    }
  });
}

function InitSecondarySearch() {

  $("#banner #group-year .btn-dropdown").addClass("active");

  //Select Year
  $('#box-year').click(function(e){
      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
    $("#banner.content #group-year .btn-dropdown").removeClass("active");

    $("#banner.content #group-make .btn-dropdown").addClass("active");
    $("#banner.content #group-make").slideDown("slow");
  });

  //Select Make
  $("#box-make").click(function(e){

      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
    $("#banner.content #group-make .btn-dropdown").removeClass("active");

    $("#banner.content #group-model .btn-dropdown").addClass("active");
    $("#banner.content #group-model").slideDown("slow");
  });

  //Select Model
  $("#box-model").click(function(e){

      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
    $("#banner.content #group-model .btn-dropdown").removeClass("active");

    $("#banner.content #group-part .btn-dropdown").addClass("active");
    $("#banner.content #group-part").slideDown("slow");
  });

  //Select Part
  $("#box-part").click(function(e){

      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
    $("#banner.content #group-part .btn-dropdown").removeClass("active");

    //$("#banner.content #group-button .btn-dropdown").addClass("active");
    $("#banner.content #group-button-option").slideDown("slow");
  });


  $("#btn-choose").click(function(e) {
    e.preventDefault();
    $(".step1").slideUp("slow");
    $(".step2").slideDown("slow");
  });


  //Select Options
  $("#banner.content #group-options .dropdown-menu li a").click(function(e){
    e.preventDefault();
      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
    $("#banner #group-options .btn-dropdown").removeClass("active");
    document.getElementById('hollanderoption').value = $(this).text();
    $("#banner #group-zip").slideDown("slow");

    //Indicator
    $(".line-indicator").removeClass("step2").addClass("step3");
    $(".indicators li:nth-child(2)").removeClass("active");
    $(".indicators  li:last-child").addClass("active");
  });
}


function ResetStates() {
  $(".btn-dropdown").click(function(){

    //$(".btn-dropdown").removeClass("active");
    //$(this).addClass("active");
  });
}

function preload_year() {
  var params = { carYears:1 };
  var data = cars.getCarsData( params );
  if( data )
  {
    cars.carYears( data );
  }
  cars.selectedCarYear = $("#preload-year").val();
  var newYears = JSON.parse(data);
  var yearsList = $('#box-year');
  yearsList.empty();
  for (var y in newYears)
  {
    if(newYears[y].CarlineYear==$('#preload-year').val())
      yearsList.append('<option selected="selected"><a href="#">'+newYears[y].CarlineYear+'</a></option>')
    else
      yearsList.append('<option><a href="#">'+newYears[y].CarlineYear+'</a></option>');
  }
  $('#group-year .select2-chosen').text(cars.selectedCarYear);

}

function preload_make() {
  if(cars.selectedCarYear)
    var makers = cars.getCarsData({label:cars.selectedCarYear});
  else {
    var makers = cars.getCarsData({makes:1});
  }
  alert(makers);
  if(makers!=[])
  {
    var makersList = $('#box-make');
    makersList.empty();
    makers = JSON.parse(makers);
    for(var m in makers)
    {
      if(makers[m].manufacture==$('#preload-make').val())
        makersList.append('<option selected="selected"><a href="#">'+makers[m].manufacture+'</a></option>')
      else
        makersList.append('<option><a href="#">'+makers[m].manufacture+'</a></option>')
    }
  }
  $('#group-make .select2-chosen').text($('#preload-make').val());

}

function preload_model() {

  if(cars.selectedManufacture && cars.selectedCarYear )
    var models = cars.getCarsData({ manufacture:cars.selectedManufacture, year:cars.selectedCarYear});
  else if(cars.selectedManufacture)
    var models = cars.getCarsData({models:1, manufacture:cars.selectedManufacture});

  var preloadmake = $('#preload-make').val();
  cars.selectedManufacture = $("#preload-make").val();
  var models = cars.getCarsData({ manufacture:cars.selectedManufacture, year:cars.selectedCarYear});
  if(models!="[]")
  {
    var modelsList = $('#box-model');
    modelsList.empty();
    models = JSON.parse(models);
    for(var m in models)
    {
      if(models[m].model==$('#preload-model').val())
        modelsList.append('<option selected="selected"><a href="#">'+models[m].model+'</a></option>')
      else
        modelsList.append('<option><a href="#">'+models[m].model+'</a></option>')
    }
  } else {
    $('#group-make .select2-chosen').text(preloadmake);
  }
}

function preload_part() {
  if (cars.selectedCarPart!=undefined) {
    //cars.selectedCarPart = $('#preload-part').val();
    if($.isNumeric($('#preload-part').val())) {
      var response;
      var partNum = cars.selectedCarPart;
      var params;
      params = { PartType:partNum };
      $.ajax({
        async:false,
        type:'post',
        url:"http://www.iusedautoparts.dev.gbksoft.net/testing/ajax/index.php",
        data: params,
        success:function(resp){
          if(resp)
          {
            response = resp;
          }
          else response = false;
        }
      });
      var partName = response;

    } else { var partName = $('#preload-part').val(); }
    var options = cars.getCarsData({partOptions:1,year:cars.selectedCarYear, model:cars.selectedCarModel, part:cars.selectedCarPart});
    if( options !="" )
    {
      console.log( options );
      var optionsList = $('#group-options .dropdown-menu');
      optionsList.empty();

      options = JSON.parse(options);

      // prepare the data
      var source =
      {
        datatype: "json",
        datafields: [
          { name: 'id' },
          { name: 'parentid' },
          { name: 'text' },
          { name: 'value' }
        ],
        id: 'id',
        localdata: options
      };
      //$('#optionvalue').jqxTree('destroy');
      // create data adapter.
      var dataAdapter = new $.jqx.dataAdapter(source);
      // perform Data Binding.
      dataAdapter.dataBind();
      // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents
      // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter
      // specifies the mapping between the 'text' and 'label' fields.
      var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);

      $('#optionvalue').jqxTree({ source: records});

      $(".jqx-tree-item").mouseenter(function (event) {
        var item = $('#optionvalue').jqxTree('getItem', $(event.target.parentElement)[0]);
        if (item.hasItems == true) {
          $(event.target).removeClass("jqx-fill-state-hover");
          $(event.target).removeClass("jqx-fill-state-hover-" + theme);
        }
      });
    } else {
      $('#group-part .select2-chosen').text(partName);
    }
  }
}


/*
function preload_year() {
  
  if ($('#preload-year').val()!=undefined&&$('#preload-year').val()!="") {
    cars.selectedCarYear = $("#preload-year").val();
    var makers = cars.getCarsData({label:cars.selectedCarYear});
    if(makers!=[])
    {
      var makersList = $('#box-make');
      makersList.empty();
      makers = JSON.parse(makers);
      for(var m in makers)
      {
        if(makers[m].manufacture==$('#preload-make').val())
          makersList.append('<option selected="selected"><a href="#">'+makers[m].manufacture+'</a></option>')
        else
          makersList.append('<option><a href="#">'+makers[m].manufacture+'</a></option>')
      }
    }
  }
}

function preload_make() {
  if ($('#preload-make').val()!=undefined) {

    var preloadmake = $('#preload-make').val();
    cars.selectedManufacture = $("#preload-make").val();
    var models = cars.getCarsData({ manufacture:cars.selectedManufacture, year:cars.selectedCarYear});
    if(models!="[]")
    {
      var modelsList = $('#box-model');
      modelsList.empty();
      models = JSON.parse(models);
      for(var m in models)
      {
        if(models[m].model==$('#preload-model').val())
          modelsList.append('<option selected="selected"><a href="#">'+models[m].model+'</a></option>')
        else
          modelsList.append('<option><a href="#">'+models[m].model+'</a></option>')
      }
    } else {
      $('#group-make .select2-chosen').text(preloadmake);
    }

  }
}

function preload_model() {
  if ($('#preload-model').val()!=undefined&&cars.selectedCarYear!=undefined) {

    cars.selectedCarModel = $("#preload-model").val();
    var parts = cars.getCarsData({carModel:cars.selectedCarModel, year:cars.selectedCarYear});
    if(parts!="")
    {
      console.log(parts);
      var partsList = $('#box-part');
      partsList.empty();
      parts = JSON.parse(parts);
      for(var p in parts)
      {
        if(parts[p].part.desc.toUpperCase()==$('#preload-part').val()) {
          partsList.append('<option value="'+parts[p].part.id+'" selected="selected"><a data-part_id="'+parts[p].part.id+'" href="#">'+parts[p].part.desc+'</a></option>');
          cars.selectedCarPart = parts[p].part.id;
        }
        else
          partsList.append('<option value="'+parts[p].part.id+'"><a data-part_id="'+parts[p].part.id+'" href="#">'+parts[p].part.desc+'</a></option>');
      }
    } else {
      $('#group-model .select2-chosen').text($("#preload-model").val());
    }
  }
}

function preload_part() {
  if (cars.selectedCarPart!=undefined) {
    //cars.selectedCarPart = $('#preload-part').val();
    if($.isNumeric($('#preload-part').val())) {
      var response;
      var partNum = cars.selectedCarPart;
      var params;
      params = { PartType:partNum };
      $.ajax({
        async:false,
        type:'post',
        url:"http://www.iusedautoparts.dev.gbksoft.net/testing/ajax/index.php",
        data: params,
        success:function(resp){
          if(resp)
          {
            response = resp;
          }
          else response = false;
        }
      });
      var partName = response;

    } else { var partName = $('#preload-part').val(); }
    var options = cars.getCarsData({partOptions:1,year:cars.selectedCarYear, model:cars.selectedCarModel, part:cars.selectedCarPart});
    if( options !="" )
    {
      console.log( options );
      var optionsList = $('#group-options .dropdown-menu');
      optionsList.empty();

      options = JSON.parse(options);

      // prepare the data
      var source =
      {
        datatype: "json",
        datafields: [
          { name: 'id' },
          { name: 'parentid' },
          { name: 'text' },
          { name: 'value' }
        ],
        id: 'id',
        localdata: options
      };
      //$('#optionvalue').jqxTree('destroy');
      // create data adapter.
      var dataAdapter = new $.jqx.dataAdapter(source);
      // perform Data Binding.
      dataAdapter.dataBind();
      // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents
      // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter
      // specifies the mapping between the 'text' and 'label' fields.
      var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);

      $('#optionvalue').jqxTree({ source: records});

      $(".jqx-tree-item").mouseenter(function (event) {
        var item = $('#optionvalue').jqxTree('getItem', $(event.target.parentElement)[0]);
        if (item.hasItems == true) {
          $(event.target).removeClass("jqx-fill-state-hover");
          $(event.target).removeClass("jqx-fill-state-hover-" + theme);
        }
      });
    } else {
      $('#group-part .select2-chosen').text(partName);
    }
  }
}
*/

function create_yearbox() {
  $(".step1").append('<div id="group-year" class="form-group">                <label for="year">Your vehicle�s model year:</label>               <div class="btn-group btn-group-justified">                  <div class="btn-group">        <select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" >        <option value="">Year</option> </select>                  </div>            </div>              </div>');

}

function create_makebox() {

  $('.step1').append('<div id="group-make" class="form-group"><label for="year">Your vehicle\'s manufacturer:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake"><option>Make</option></select></div></div></div>');

}
function create_modelbox() {
  $(".step1").append('<div id="group-model" class="form-group"><label for="year">Your vehicle\'s model:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel"><option>Model</option></select></div></div></div>');

}
function create_partbox() {
  $(".step1").append('<div id="group-part" class="form-group"><label for="year">The part you\'re looking for:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart"><option>Part</option></select><input type="hidden" id="partname" name="partname" /></div></div></div>');
}

function ShowProgress() {

  $('#modal-progress').on('shown.bs.modal', function () {

    var params;

    var optvalue = $("#optionvalue").val();
    var hoption;
    hoption = optvalue.label;
    if(optvalue.parentElement) {

      var parent= $('#optionvalue').jqxTree('getItem', optvalue.parentElement);
      hoption += "," +  parent.label;
      if(parent.parentElement) {
        var grandparent= $('#optionvalue').jqxTree('getItem', parent.parentElement);
        hoption = grandparent.label +  "," + hoption;
        if(grandparent.parentElement) {
          var greatgrandparent= $('#optionvalue').jqxTree('getItem', grandparent.parentElement);
          hoption = greatgrandparent.label + "," + hoption;
        }
      }
    }
    params = {
      year:document.getElementById("box-year").value,
      make:document.getElementById("box-make").value,
      model:document.getElementById('box-model').value,
      partname:document.getElementById('partname').value,
      interchange:optvalue.value,
      hollanderoption:hoption,
      zip:document.getElementById('zip').value };
    var response;
    $.ajax({
      async:false,
      type:'post',
      url:"/scripts/request.php",
      data: params,
      success:function(resp){
        if(resp)
        {
          response = resp;
        }
        else response = false;
      }
    });
    var reqid = response;
    document.getElementById('reqid').value= reqid;

    var progress = setInterval(function() {
    var $bar = $('.bar');

    if ($bar.width()>500) {

        //window.location.href = "/inventory";

      window.searchform.submit();
      clearInterval(progress);
      $('.progress').removeClass('active');
      $('#modal-progress').modal('hide');
      $bar.width(0);

    } else {


      $bar.width($bar.width()+50);
    }

    $bar.text($bar.width()/5 + "%");
    }, 800);


  })
}


