$(document).on('click', '.jqx-item', function(){
    $('input[name=zipcode]').focus();
});
$(document).on('keydown', '.form-control', function(event){
  if(event.keyCode === 9){$('#btn-check').focus();}
});
$( document ).ready(function() {
  if($('.bs-example-modal-lg').css('display','block')){
    $('.form-control').focus();
  }
  if($('#getvalue').text().length > 0  ){
    var el = $('#getvalue').text();
    $('title').text(el);
  }

  // $('.table-hide').find('tr:not(:first)').hide();
  // $("#btn-show").click(function () {
  //   $('.table-hide').find('tr:not(:first)').show();
  //   $("#btn-show").hide();
  //   $("#btn-hide").show();
  // });
  // $('#btn-hide').click(function () {
  //   $('.table-hide').find('tr:not(:first)').hide();
  //   $("#btn-show").show();
  //   $("#btn-hide").hide();
  // });

    $(".vehicle").click(function () { 
        var req = $(this).data('request');
        req['addres'] = 'addres';
        req['yardid'] = $(this).data('id');
//        var _self = $(this).parents('td').parent('tr');
        $.post( "/testing/ajax/add_result.php", req, function( data ) {
                var namevendor = $(data).find('.namevendor:first').text();
                $('#data').find('.modal-body').html(data);
                $('#data').find('#myModalLabel span').text(namevendor);
                $('#data').modal('show');
        });  
    });        
});


$(function () {
    window.cars = {
        selectedManufacture: "",
        selectedCarYear: "",
        selectedModel: "",
        selectedPart: "",
        selectedOption: "",
        init: function () {
            var loaded = false;
            //if($("#preload-ppc").val()!="true") {

            if (($('#preload-year').val() != undefined && $('#preload-year').val() != ""))
                var params = {carYears: 1};
            else if (($('#preload-model').val() != undefined && $('#preload-model').val() != ""))
                var params = {carYears: 1, carYearsModel: encodeURI($('#preload-model').val())};
            else if (($('#preload-make').val() != undefined && $('#preload-make').val() != ""))
                var params = {carYears: 1, carYearsMake: $('#preload-make').val()};
            else
                var params = {carYears: 1};
            var data = this.getCarsData(params);
            if (data) {
                this.carYears(data);
            }
            //}
        },
        prepareData: function (data, sourceId, name) {
            this.source[sourceId].items = [];
            var newData = JSON.parse(data);
            for (var d in newData)
                this.source[sourceId].items.push({label: "" + newData[d][name]});
            this.render();
        },
        carYears: function (years) {
            var newYears = JSON.parse(years);
            var yearsList = $('#box-year');
            yearsList.empty();
            for (var y in newYears) {
                if (newYears[y].CarlineYear == $('#preload-year').val())
                    yearsList.append('<option selected="selected"><a href="#">' + newYears[y].CarlineYear + '</a></option>')
                else
                    yearsList.append('<option><a href="#">' + newYears[y].CarlineYear + '</a></option>');
            }
            if (document.getElementById("openyear").value == "true") {
                $('#box-year').select2('open');
            }
            document.getElementById("box-year").selectedIndex = -1;
        },
        carMakes: function () {

            var makers = this.getCarsData({label: this.selectedCarYear});
            if (makers) {
                var makersList = $('#box-make');
                makersList.empty();
                makers = JSON.parse(makers);
                for (var m in makers) {
                    makersList.append('<option><a href="#">' + makers[m].manufacture + '</a></option>')

                }
                $("#step1-title").slideDown();
                $("#step2-title").slideUp();
                $("#banner #group-options").slideUp("slow");
                $("#banner #group-button").slideUp("slow");
                $("#banner #group-options .btn-dropdown").removeClass("active");
                $("#banner #group-options .btn-group").removeClass("open");
                $("#banner #group-options .btn-dropdown .selection").text("Select Options");
                $('#group-make .select2-chosen').text("Make");
                $('#group-model .select2-chosen').text("Model");
                $('#group-part .select2-chosen').text("Part");
                var modelsList = $('#box-model');
                modelsList.empty();
                var partsList = $('#box-part');
                partsList.empty();
                $('#box-make').select2('open');
                document.getElementById("box-make").selectedIndex = -1;
            }
        },
        carModel: function (data) {
            var models = this.getCarsData({manufacture: this.selectedManufacture, year: this.selectedCarYear});
            if (models) {
                var modelsList = $('#box-model');
                modelsList.empty();
                models = JSON.parse(models);
                //modelsList.append('<option> </option>');
                for (var m in models) {
                    modelsList.append('<option><a href="#">' + models[m].model + '</a></option>')
                }
                console.log(models);
                $("#step1-title").slideDown();
                $("#step2-title").slideUp();
                $("#change-search-title").slideUp();
                $("#banner #group-options").slideUp("slow");
                $("#banner #group-button").slideUp("slow");
                $("#banner #group-options .btn-dropdown").removeClass("active");
                $("#banner #group-options .btn-group").removeClass("open");
                $("#banner #group-options .btn-dropdown .selection").text("Select Options");
                $('#group-model .select2-chosen').text("Model");
                $('#group-part .select2-chosen').text("Part");
                var partsList = $('#box-part');
                partsList.empty();
                $('#box-model').select2('open');
                document.getElementById("box-model").selectedIndex = -1;

            }
        },
        carPart: function () {
            console.log(this)
            var parts = this.getCarsData({carModel: this.selectedModel, year: this.selectedCarYear});
            if (parts) {
                console.log(parts);
                var partsList = $('#box-part');
                partsList.empty();
                parts = JSON.parse(parts);
                //partsList.append('<option> </option>');
                for (var p in parts) {
                    partsList.append('<option value="' + parts[p].part.id + '|' + parts[p].part.desc + '"><a data-part_id="' + parts[p].part.id + '" href="#">' + parts[p].part.desc + '</a></option>');
                }
                $("#step1-title").slideDown();
                $("#step2-title").slideUp();
                $("#change-search-title").slideUp();
                $("#banner #group-options").slideUp("slow");
                $("#banner #group-button").slideUp("slow");
                $("#banner #group-options .btn-dropdown").removeClass("active");
                $("#banner #group-options .btn-group").removeClass("open");
                $("#banner #group-options .btn-dropdown .selection").text("Select Options");
                $("#preload-part").val("");
                $("#preload-option").val("");

                $('#group-part .select2-chosen').text("Part");
                $('#box-part').select2('open');
                document.getElementById("box-part").selectedIndex = -1;

            }
        },
        getOptions: function () {

            $("#preload-option").val("");
            var options = this.getCarsData({
                partOptions: 1,
                year: this.selectedCarYear,
                model: this.selectedModel,
                part: this.selectedPart
            });

            if (options) {
                $("#banner #group-options .btn-dropdown .selection").text("Select Options");
                $("#banner #group-button").slideUp("slow");

                console.log(options);
                var optionsList = $('#optionvalue');
                //optionsList.empty();
                options = JSON.parse(options);

                //alert(options.length);
                if (options.length > 1) {
                    // show the options tree
                    // prepare the data
                    var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id'},
                            {name: 'parentid'},
                            {name: 'text'},
                            {name: 'value'}
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
                    var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{
                        name: 'text',
                        map: 'label'
                    }]);

                    $('#optionvalue').jqxTree({source: records});

                    $(".jqx-tree-item").mouseenter(function (event) {
                        var item = $('#optionvalue').jqxTree('getItem', $(event.target.parentElement)[0]);
                        if (item.hasItems == true) {
                            $(event.target).removeClass("jqx-fill-state-hover");
                            $(event.target).removeClass("jqx-fill-state-hover-" + theme);
                        }
                    });
                    var noshow = false;
                    document.getElementById("optionsbox").style.display = "block";

                    if ($("#preload-option") && $("#preload-option").val() != undefined && $("#preload-option").val() != "" && $("#preload-part").val() == this.selectedPart) {
                        $("#banner #group-options .btn-dropdown .selection").text($("#preload-option").val());
                        var selectedNode = $('#optionvalue').jqxTree("getItem", $('li.1')[0]);
                        //alert($("#preload-option").val());
                        $('#optionvalue').jqxTree("selectItem", selectedNode);
                        var noshow = true;
                        //alert("noshow");
                    } else {
                        $("#optionvalue").slideDown("slow");
                    }
                } else if (options.length <= 1) {
                    //alert(options[0].value + " " + options[0].parentid + " " + options[0].text);
                    //$(this).parents(".btn-group").find('.selection').text("");

                    if (options[0]) {
                        document.getElementById('optionvalue').value = options[0].value;
                        document.getElementById('hollanderoption').value = options[0].value;
                    } else
                        document.getElementById('hollanderoption').value = "";
                    $("#banner #group-options .btn-dropdown").removeClass("active");
                    if (document.getElementById("optionsbox")) {
                        document.getElementById("optionsbox").style.display = "none";
                    } else {

                        document.getElementById("group-options").style.display = "none";
                        var noshow = true;
                    }
                    $("#optionvalue").slideUp("slow");
                    $("#banner #group-zip").slideDown("slow");
                    if (document.getElementById('zip').value.length == 5) {
                        $("#banner #group-button").slideDown("slow");
                    }
                }
                if (!noshow) {
                    $("#banner #group-options .btn-dropdown").addClass("active");
                    $("#banner #group-options").slideDown("slow");
                    $("#banner #group-options .btn-group").addClass("open");
                }
                if (document.getElementById('zip').value.length != 5) {
                    $("#banner #group-button").slideUp("slow");
                }
            }
        },
        getCarsData: function (params) {
            var that = this;
            var response = "";

            $.ajax({
                async: false,
                type: 'post',
                url: "/testing/ajax/index.php",
                data: params,
                success: function (resp) {
                    if (resp) {
                        response = resp;
                    }
                    else
                        response = false;
                }
            });
            return response;
        }
    }
    //preload();

    $("#btn-change-search").click(function () { // preloading form values triggered by opening the "CHANGE SEARCH" box on the /inventory page
        $("#loading").show();
        if (cars.loaded == true) {
        }
        else {
            preload_year();
            preload_make();
            preload_model();
            preload_part();
            cars.loaded = true;
        }
        if ($("#change-search-title").css('display') == "none")
            $("#change-search-title").slideDown();
        else
            $("#change-search-title").slideUp();
        $("#banner #group-options .btn-dropdown").addClass("active");
        $("#banner #group-options").slideDown("slow");
        $("#banner #group-zip").slideDown("slow");
        $("#banner #group-options .btn-group").addClass("open");
        if (document.getElementById('zip').value.length == 5) {
            $("#banner #group-button").slideDown("slow");
        }
        //$('#box-year').select2('open');
        $(this).find('.fa').toggleClass('fa-chevron-up fa-chevron-down');
        $("#loading").hide();

    });

    if ($("#preload-ppc").val() == "true") { // preloading form values upon initial page load when needed
        var preloads = [];
        if ($('#preload-year').val() != undefined && $('#preload-year').val() != "") {
            //create_yearbox();
            //preload_year();
            cars.selectedCarYear = $('#preload-year').val();
        } else {
            preloads[preloads.length] = "year";
        }
        if ($('#preload-make').val() != undefined && $('#preload-make').val() != "") {
            cars.selectedManufacture = $('#preload-make').val();
        } else {
            preloads[preloads.length] = "make";
        }
        if ($('#preload-model').val() != undefined && $('#preload-model').val() != "") {
            cars.selectedModel = $('#preload-model').val();
            if ($('#preload-make').val() == undefined || $('#preload-make').val() == "") {
                cars.selectedManufacture = cars.getCarsData({getMake: 1, carMakeModel: $('#preload-model').val()});
                $('#preload-make').val(cars.selectedManufacture);
                //create_makebox();
                //preload_make();
                var preload_index = preloads.indexOf("make");
                preloads.splice(preload_index, 1);
            }

            //create_modelbox();
            //preload_model();
        } else {
            preloads[preloads.length] = "model";
        }
        if ($('#preload-part').val() != undefined && $('#preload-part').val() != "") {
            cars.selectedPart = $('#preload-part').val();
            //create_partbox();
            //preload_part();
        } else {
            preloads[preloads.length] = "part";
        }
        for (var p in preloads) {

            if (preloads[p] == "year") {
                //create_yearbox();
                //  if  (($('#preload-make').val()!=undefined&&$('#preload-make').val()!="")|| ($('#preload-model').val()!=undefined&&$('#preload-model').val()!="") )
                //  {
                //    preload_year();
                //  }
                //  else {
                cars.init();
                //  }
            }
            if (preloads[p] == "make") {
                create_makebox();
                if ($('#preload-year').val() != undefined && $('#preload-year').val() != "") {
                    preload_make();
                }
            }
            if (preloads[p] == "model") {
                create_modelbox();
                if ($('#preload-make').val() != undefined && $('#preload-make').val() != "") {
                    preload_model();
                }
            }
            if (preloads[p] == "part") {
                create_partbox();
                if ($('#preload-model').val() != undefined && $('#preload-model').val() != "") {
                    preload_part();
                }
            }
            highlight_box(preloads[p]);
        }

        //$(".step1").append('<div id="group-button-option" class="form-group"><button id="btn-choose" type="submit" class="btn btn-orange btn-block" data-target="#search-form" data-slide-to="1">CHOOSE OPTIONS <i class="fa fa-arrow-right"></i></button></div>');
        //$(".step1").append('<div  id="group-button" class="form-group text-center"><div>- OR -</div><button id="btn-new-search" class="btn btn-orange">START A NEW SEARCH <i class="fa fa-arrow-right"></i></button></div>');

    }


    cars.init();
    InitSecondarySearch();
    InitPrimarySearch();
    ShowProgresss();
    ResetStates();
});

function InitPrimarySearch() {

    if ($("#preload-ppc").val() != "true") {
        $("#banner #group-year .btn-dropdown").addClass("active");
    }

    //Select Year
    $("#box-year").click(function (e) {
        cars.selectedCarYear = $(this).val();
        $("#banner #group-year .btn-dropdown").removeClass("active");
        $("#banner #group-make .btn-dropdown").addClass("active");

        if ($('#reqid').val() != undefined && $('#reqid').val() != "") {
            cars.carMakes();
        } else if ($('#preload-make').val() == undefined || $('#preload-make').val() == "") {
            cars.carMakes();
        } else if ($('#preload-model').val() == undefined || $('#preload-model').val() == "") {
            cars.carModel();
        } else if ($('#preload-part').val() == undefined || $('#preload-part').val() == "") {
            cars.carPart();
        }

    });

    //Select Make
    $("#box-make").click(function (e) {
        e.preventDefault();
        cars.selectedManufacture = $(this).val();
        $("#banner #group-make .btn-dropdown").removeClass("active");
        $("#banner #group-model .btn-dropdown").addClass("active");
        cars.carModel();

    });

    //Select Model
    $("#box-model").click(function (e) {
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
    $("#box-part").click(function (e) {
        e.preventDefault();
        $("#banner #group-part .btn-dropdown").removeClass("active");
        $("#step1-title").slideUp();
        var year = $("#box-year").val().toUpperCase();
        var make = $("#box-make").val().toUpperCase();
        var model = $("#box-model").val().toUpperCase();

        var part = $("#box-part option:selected").html().toUpperCase();

        $("#step2-title").html("<h2><span class='text-orange'>" + part + "</span> for a <span class='text-orange'>" + year + "</span> <span class='text-orange'>" + make + "</span> <span class='text-orange'>" + model + "</span></h2>");
        $("#step2-title").slideDown("slow");

        //Indicator
        $(".line-indicator").removeClass("step1").addClass("step2");
        $(".indicators li:first-child").removeClass("active");
        $(".indicators  li:nth-child(2)").addClass("active");
        //cars.selectedPart = $(e.target).data('part_id');
        cars.selectedPart = document.getElementById('box-part').value.substring(0, 3);
        document.getElementById('partname').value = part;
        //$('#preload-option').val("");
        cars.getOptions();


    });

    //Select Options

    var selection = null;
    $('#optionvalue').on('select', function (e) {
        e.preventDefault();
        var htmlElement = e.args.element;
        var item = $('#optionvalue').jqxTree('getItem', htmlElement);
        if (item.hasItems == true) {
            //$('#optionvalue').jqxTree('selectItem', selection);
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
            if (document.getElementById('zip').value.length == 5) {
                $("#banner #group-button").slideDown("slow");
            }
            var optvalue = $("#optionvalue").val();
            var hoption;
            hoption = optvalue.label;
            interchange = optvalue.value;
            if (optvalue.parentElement) {

                var parent = $('#optionvalue').jqxTree('getItem', optvalue.parentElement);
                hoption += "," + parent.label;
                if (parent.parentElement) {
                    var grandparent = $('#optionvalue').jqxTree('getItem', parent.parentElement);
                    hoption = grandparent.label + "," + hoption;
                    if (grandparent.parentElement) {
                        var greatgrandparent = $('#optionvalue').jqxTree('getItem', grandparent.parentElement);
                        hoption = greatgrandparent.label + "," + hoption;
                    }
                }
            }

            document.getElementById('hollanderoption').value = interchange;
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

    $("#banner #group-options .btn-dropdown").click(function (e) {

        if ($("#optionvalue").css('display') == "none") {
            //$("#optionvalue").css('display') = "block";
            $("#optionvalue").slideDown("slow");
        } else {
            //$("#optionvalue").css('display') = "none";
            $("#optionvalue").slideUp("slow");
        }

    });

    $("#zip").focus(function () {
        $("#banner #group-button").slideDown("slow");
    });

    $("#btn-check").click(function (e) {
        e.preventDefault();
        if (document.getElementById('zip').value.length != 5) {
            alert("Please provide a five-digit zip code.");
        } else {
          ShowProgress();
        }
    });
    $("#btn-new-search").click(function (e) {
        e.preventDefault();
        window.location = "/";

    });
}

function InitSecondarySearch() {

    if ($("#preload-ppc").val() != "true") {
        $("#banner #group-year .btn-dropdown").addClass("active");
    }
    //Select Year
    $('#box-year').click(function (e) {
        cars.selectedCarYear = $(this).val();
        $(this).parents(".btn-group").find('.selection').text($(this).text());
        $(this).parents(".btn-group").find('.selection').val($(this).text());
        $("#banner.content #group-year .btn-dropdown").removeClass("active");

        $("#banner.content #group-make").slideDown("slow");
        $("#banner.content #group-make .btn-dropdown").addClass("active");
        if (cars.selectedCarYear && cars.selectedModel && cars.selectedPart && $("#showStep2").val() == "true") {
            ShowStep2();
        }
    });

    //Select Make
    $("#box-make").click(function (e) {

        $(this).parents(".btn-group").find('.selection').text($(this).text());
        $(this).parents(".btn-group").find('.selection').val($(this).text());
        $("#banner.content #group-make .btn-dropdown").removeClass("active");

        $("#banner.content #group-model .btn-dropdown").addClass("active");
        $("#banner.content #group-model").slideDown("slow");
    });

    //Select Model
    $("#box-model").click(function (e) {

        $(this).parents(".btn-group").find('.selection').text($(this).text());
        $(this).parents(".btn-group").find('.selection').val($(this).text());
        $("#banner.content #group-model .btn-dropdown").removeClass("active");

        $("#banner.content #group-part .btn-dropdown").addClass("active");
        $("#banner.content #group-part").slideDown("slow");
    });

    //Select Part
    $("#box-part").click(function (e) {
        $(this).parents(".btn-group").find('.selection').text($(this).text());
        $(this).parents(".btn-group").find('.selection').val($(this).text());
        $("#banner.content #group-part .btn-dropdown").removeClass("active");
        $(".step1").slideUp("slow");
        $(".step2").slideDown("slow");
        return;
    });


    $("#btn-choose").click(function (e) {

        e.preventDefault();
        $(".step1").slideUp("slow");
        $(".step2").slideDown("slow");
        cars.getOptions();
        $("#optionvalue").slideDown("slow");
    });

    $("#btn-go-back").click(function (e) {

        e.preventDefault();
        $(".step2").slideUp("slow");
        $(".step1").slideDown("slow");
        //cars.getOptions();
        //$("#optionvalue").slideDown("slow");
    });

    //Select Options
    $("#banner.content #group-options .dropdown-menu li a").click(function (e) {
        e.preventDefault();
        $(this).parents(".btn-group").find('.selection').text($(this).text());
        $(this).parents(".btn-group").find('.selection').val($(this).text());
        $("#banner #group-options .btn-dropdown").removeClass("active");
        document.getElementById('hollanderoption').value = $(this).text();
        $("#banner #group-zip").slideDown("slow");
        if (document.getElementById('zip').value.length == 5) {
            $("#banner #group-button").slideDown("slow");
        }

        //Indicator
        $(".line-indicator").removeClass("step2").addClass("step3");
        $(".indicators li:nth-child(2)").removeClass("active");
        $(".indicators  li:last-child").addClass("active");
    });
}


function ResetStates() {
    $(".btn-dropdown").click(function () {

        //$(".btn-dropdown").removeClass("active");
        //$(this).addClass("active");
    });
}

function preload_year() {
    if (($('#preload-year').val() != undefined && $('#preload-year').val() != ""))
        var params = {carYears: 1};
    else if (($('#preload-model').val() != undefined && $('#preload-model').val() != ""))
        var params = {carYears: 1, carYearsModel: encodeURI($('#preload-model').val())};
    else if (($('#preload-make').val() != undefined && $('#preload-make').val() != ""))
        var params = {carYears: 1, carYearsMake: $('#preload-make').val()};
    else
        var params = {carYears: 1};
    var data = cars.getCarsData(params);
//  if( data )
//  {
//    cars.carYears( data );
//  }

    cars.selectedCarYear = $("#preload-year").val();
    var newYears = JSON.parse(data);
    var yearsList = $('#box-year');
    yearsList.empty();
    for (var y in newYears) {
        if (newYears[y].CarlineYear == $('#preload-year').val())
            yearsList.append('<option selected="selected"><a href="#">' + newYears[y].CarlineYear + '</a></option>')
        else
            yearsList.append('<option><a href="#">' + newYears[y].CarlineYear + '</a></option>');
    }
    if (cars.selectedCarYear)
        $('#group-year .select2-chosen').text(cars.selectedCarYear);
    else
        $('#group-year .select2-chosen').text("Year");

    if (($('#preload-year').val() == undefined || $('#preload-year').val() == ""))
        $('#box-year').select2('open');
}

function preload_make() {
    if (cars.selectedCarYear) {
        var makers = cars.getCarsData({label: cars.selectedCarYear});
    } else {
        var makers = cars.getCarsData({makes: 1});
    }
    cars.selectedManufacture = $("#preload-make").val();
    if (makers != []) {
        var makersList = $('#box-make');
        makersList.empty();
        makers = JSON.parse(makers);
        for (var m in makers) {
            if (makers[m].manufacture == $('#preload-make').val())
                makersList.append('<option selected="selected"><a href="#">' + makers[m].manufacture + '</a></option>')
            else
                makersList.append('<option><a href="#">' + makers[m].manufacture + '</a></option>')
        }
    }
    if ($('#preload-make').val() != undefined && $('#preload-make').val() != "")
        $('#group-make .select2-chosen').text($('#preload-make').val());
    else
        $('#group-make .select2-chosen').text("Make");
}

function preload_model() {
    cars.selectedModel = $('#preload-model').val();
    if (cars.selectedManufacture && cars.selectedCarYear)
        var models = cars.getCarsData({manufacture: cars.selectedManufacture, year: cars.selectedCarYear});
    else if (cars.selectedManufacture) {
        var models = cars.getCarsData({models: 1, manufacture: cars.selectedManufacture});
    }
    if (models != "[]") {
        var modelsList = $('#box-model');
        modelsList.empty();
        models = JSON.parse(models);
        for (var m in models) {
            if (models[m].model == $('#preload-model').val())
                modelsList.append('<option selected="selected"><a href="#">' + models[m].model + '</a></option>')
            else
                modelsList.append('<option><a href="#">' + models[m].model + '</a></option>')
        }
    }
    if ($('#preload-model').val() != undefined && $('#preload-model').val() != "")
        $('#group-model .select2-chosen').text(cars.selectedModel);
    else
        $('#group-model .select2-chosen').text("Model");
}

function preload_part() {
    if (cars.selectedCarYear)
        var parts = cars.getCarsData({carModel: cars.selectedModel, year: cars.selectedCarYear});
    else
        var parts = cars.getCarsData({carModel: cars.selectedModel});


    if (parts != "") {
        console.log(parts);
        var partsList = $('#box-part');
        partsList.empty();
        parts = JSON.parse(parts);
        var partName = "";
        for (var p in parts) {
            if (parts[p].part.desc.toUpperCase() == $('#preload-chpartname').val().toUpperCase()) {
                //partsList.append('<option value="'+parts[p].part.id+'" selected="selected"><a data-part_id="'+parts[p].part.id+'" href="#">'+parts[p].part.desc+'</a></option>');
                partsList.append('<option value="' + parts[p].part.id + '|' + parts[p].part.desc + '" selected="selected"><a data-part_id="' + parts[p].part.id + '" href="#">' + parts[p].part.desc + '</a></option>');

                cars.selectedPart = parts[p].part.id;
                partName = parts[p].part.desc;
            }
            else
                partsList.append('<option value="' + parts[p].part.id + '|' + parts[p].part.desc + '"><a data-part_id="' + parts[p].part.id + '" href="#">' + parts[p].part.desc + '</a></option>');
            //partsList.append('<option value="'+parts[p].part.id+'"><a data-part_id="'+parts[p].part.id+'" href="#">'+parts[p].part.desc+'</a></option>');
        }
    }
    if (partName != "")
        $('#group-part .select2-chosen').text(partName);
    else
        $('#group-part .select2-chosen').text("Part");
    cars.getOptions();

}

function highlight_box(box) {

    if ($(".step1").find('.active').length == 0) {
        $('#box-' + box).addClass("active");
    }
}


function create_yearbox() {
    $(".step1").append('<div id="group-year" class="form-group"><label for="year">  Your vehicle\'s model year:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" ><option value="">Year</option> </select></div></div></div>');
    $("#box-year").select2({placeholder: "Year"});
    cars.carMakes();
    //cars.carYears();
    //$('#box-year').select2('open');


}

function create_makebox() {

    $('.step1').append('<div id="group-make" class="form-group"><label for="year">Your vehicle\'s manufacturer:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake"><option>Make</option></select></div></div></div>');
    $("#box-make").select2({placeholder: "Make"});

}
function create_modelbox() {
    $(".step1").append('<div id="group-model" class="form-group"><label for="year">Your vehicle\'s model:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel"><option>Model</option></select></div></div></div>');
    $("#box-model").select2({placeholder: "Model"});
}
function create_partbox() {
    $(".step1").append('<div id="group-part" class="form-group"><label for="year">The part you\'re looking for:</label><div class="btn-group btn-group-justified"><div class="btn-group"><select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart"><option>Part</option></select><input type="hidden" id="partname" name="partname" /></div></div></div>');
    $("#box-part").select2({placeholder: "Part"});
}

function ShowStep2() {

    $(".step1").slideUp("slow");
    $(".step2").slideDown("slow");
    cars.getOptions();
    $("#optionvalue").slideDown("slow");
}

function ShowProgress() {
$.loader({
        className:"blue-with-image-12",
        content:'Please wait while we search for inventory from our vendors..'
    });

       LaunchProgressBar();

}
function     ShowProgresss(){
 // $('#modal-progress').on('shown.bs.modal', function () {

 //        LaunchProgressBar();

 //    })
}


function LaunchProgressBar() {

    var params;

    var optvalue = $("#optionvalue").val();
    var hoption;
    if (optvalue) {
        hoption = optvalue.label;
        if (optvalue.parentElement) {

            var parent = $('#optionvalue').jqxTree('getItem', optvalue.parentElement);
            hoption += "," + parent.label;
            if (parent.parentElement) {
                var grandparent = $('#optionvalue').jqxTree('getItem', parent.parentElement);
                hoption = grandparent.label + "," + hoption;
                if (grandparent.parentElement) {
                    var greatgrandparent = $('#optionvalue').jqxTree('getItem', grandparent.parentElement);
                    hoption = greatgrandparent.label + "," + hoption;
                }
            }
        }
    }
    else
        hoption = "";

    var optvalue = document.getElementById("hollanderoption").value;
    if (document.getElementById('preload-partname'))
        carPartName = document.getElementById('preload-partname').value;
    else if (document.getElementById('partname').value != "")
        carPartName = document.getElementById('partname').value;
    else if (document.getElementById('preload-chpartname'))
        carPartName = document.getElementById('preload-chpartname').value;
    if (cars.selectedCarYear && cars.selectedManufacture && cars.selectedModel &&
        carPartName && optvalue && document.getElementById('zip').value) {
        //alert("submitting");
        //continue;
    } else
        return false;
    params = {
        year: cars.selectedCarYear,
        make: cars.selectedManufacture,
        model: cars.selectedModel,
        partname: carPartName,
        interchange: optvalue,
        hollanderoption: hoption,
        zip: document.getElementById('zip').value
    };
    $.ajax({
        async: false,
        type: 'post',
        url: "/scripts/request.php",
        data: params,
        success: function (resp) {
            if (resp) {
                document.getElementById('reqid').value = resp;
                window.searchform.submit();
                $.loader('close');
            }
        }
    });
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone) {
    var re = /^(\([0-9]{3}\)|[0-9]{3}-)[0-9]{3}-[0-9]{4}$/;
    return re.test(phone);
}

function updateRequestContactData() {

    if (!validateEmail($("input[type=email]").val())) {
        alert("Please enter a valid email address");
        return false;
    }
    if (!validatePhone($("input[type=tel]").val())) {
        alert("Please enter a valid phone number");
        return false;
    }
}

window.onkeydown = function (e) {

//    if (e.keyCode == 9 || e.which == 9) {
//        e.preventDefault();
//        return false;
//    }
    if (e.keyCode == 13 || e.which == 13) {
        e.preventDefault();

        var optvalue = $("#optionvalue").val();
        var hoption;


        var optvalue = document.getElementById("hollanderoption").value;
        if (document.getElementById('preload-partname'))
            carPartName = document.getElementById('preload-partname').value;
        else if (document.getElementById('partname').value != "")
            carPartName = document.getElementById('partname').value;
        else if (document.getElementById('preload-chpartname'))
            carPartName = document.getElementById('preload-chpartname').value;
        if (cars.selectedCarYear && cars.selectedManufacture && cars.selectedModel &&
            carPartName && optvalue && document.getElementById('zip').value) {
            if (document.getElementById('zip').value.length != 5) {
                alert("Please provide a five-digit zip code.");
            } else {
                $.loader({
                    className:"blue-with-image-12",
                    content:'Please wait while we search for inventory from our vendors..'
                });

                   LaunchProgressBar();
            }
        } else
            return false;


        return false;

        return false;
    }
}

////////tairezzzz app
var app = angular.module('App', []);

app.controller('Controller', ['$scope', '$http', function ($scope, $http) {
    $scope.submitted = false;
    $scope.error = false;
    $scope.submit = function () {
        if ($scope.user_form.$valid) {
            $http.post("/scripts/requestupdatecontactdata.php", {
                'reqid': $scope.req.id,
                'email': $scope.req.email,
                'phone': $scope.req.phone
            })
                .success(function (data, status, headers, config) {
                    if (data == 'true') {
                        //save email adress on local storage
                        if(typeof(Storage) !== "undefined") {
                            localStorage.setItem("email", $scope.req.email);
                        }
                        if($scope.req.refresh) {
                            
                            location.replace('/inventory?reqid=' + $scope.req.id);
                            return;
                        } else {
                            $('.no-results').modal('hide');
                        }
                        $scope.submitted = true;
                    } else {
                        $scope.error = true;
                    }
                });
        } else {
            console.log("Form is not valid!");
        }
    }
}]);

$('#modalRequestSaveAll form').on('submit', function(e) {
    e.preventDefault();

    $.post($(this).attr('action'), $( this ).serializeArray(), function(rd) {
        if(rd && rd.result) {
            $('#modalRequestSaveAll form').trigger('reset');
        }

        $('#modalRequestSaveAll').modal('hide');
    }, 'json');


    return false;
});

$('#modalRequestSave form').on('submit', function(e) {
    e.preventDefault();

    $.post($(this).attr('action'), $( this ).serializeArray(), function(rd) {
        if(rd && rd.result) {
            $('#modalRequestSave form').trigger('reset');
        }

        $('#modalRequestSave').modal('hide');
    }, 'json');


    return false;
});

$('#modalRequestSend form').on('submit', function(e) {
    e.preventDefault();

    $.post($(this).attr('action'), $( this ).serializeArray(), function(rd) {
        if(rd && rd.result) {
            $('#modalRequestSend form').trigger('reset');
        }

        $('#modalRequestSend').modal('hide');
    }, 'json');


    return false;
});

$('#modalRequestSave, #modalRequestSend').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var yardid = button.data('yardid'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    //modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input[name="yardid"]').val(yardid);
});