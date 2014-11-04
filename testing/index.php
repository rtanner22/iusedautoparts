<html>
<head>
    <!-- add the jQuery script -->
    <link rel="stylesheet" href="jq-widgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="jq-widgets/scripts/jquery-1.10.2.min.js"></script>

    <script type="text/javascript" src="jq-widgets/scripts/demos.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxtree.js"></script>
    <script type="text/javascript" src="jq-widgets/jqwidgets/jqxexpander.js"></script>
</head>
<body class='default'>
<div id='jqxWidget'>
    <div id='jqxExpander'>
        <div>
            Cars parts
        </div>
        <div style="overflow: hidden;">
            <div style="border: none;" id='jqxTree'>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        window.cars ={
            selectedManufacture:"",
            selectedCarYear:"",
            selectedModel:"",
            source : [
                {
                    id:"carYear", icon: "jq-widgets/images/mailIcon.png", label: "Year", expanded: false, items: [
                        {icon: "jq-widgets/images/folder.png", label: "Loading..."}
                    ]
                }
            ],

            carYears : function(years)
            {
                var newYears = JSON.parse(years);
                this.source[0].items = [];
                for (var y in newYears)
                {
                    this.source[0].items.push({id:"carMake_"+newYears[y].CarlineYear, label:""+newYears[y].CarlineYear, items:[
                            {icon: "jq-widgets/images/folder.png", label: "Loading..."}
                        ]
                    });
                }
                this.render();
            },

            init : function(){
                var params = { carYears:1 };
                var data = this.getCarsData( params );

                if( data )
                {
                    this.carYears( data );
                }
            },

            render : function(){
                var that = this;
                var tree = $('#jqxTree');
                tree.on('expand', function (event) {
                    var label = tree.jqxTree('getItem', event.args.element).label;
                    var $element = $(event.args.element);
                    var loader = false;
                    var loaderItem = null;
                    var params = {};
                    var children = $element.find('ul:first').children();

                    $.each(children, function () {
                        var item = tree.jqxTree('getItem', this);
                        if (item && item.label == 'Loading...') {
                            loaderItem = item;

                            if( loaderItem.parentId.indexOf("carMake") + 1 )
                            {
                                params.label = loaderItem.parentId.split('_')[1];
                                that.selectedCarYear = params.label;
                            }

                            if( loaderItem.parentId.indexOf("manuf") + 1 )
                            {
                                params.manufacture = loaderItem.parentId.split('_')[1];
                                that.selectedManufacture = params.manufacture;
                            }

                            if( loaderItem.parentId.indexOf("model") + 1 )
                            {
                                params.carModel = loaderItem.parentId.split('_')[1];
                                params.year = that.selectedCarYear;
                                that.selectedModel = params.carModel;
                            }

                            loader = true;
                            return false;
                        };
                    });
                    if (loader) {
                        $.ajax({
                            type:'post',
                            url: window.location.href+"ajax/index.php",
                            data: params,
                            success: function (data, status, xhr) {
                                var items = jQuery.parseJSON(data);
                                console.log(items);
                                tree.jqxTree('addTo', items, $element[0]);
                                tree.jqxTree('removeItem', loaderItem.element);
                            }
                        });
                    }
                });

                $('#jqxTree').jqxTree({ source: this.source, width: '100%', height: '100%'});
                var hasThreeStates = $('#jqxTree').jqxTree('hasThreeStates');
                console.log('hasThreeStates');
                console.log(hasThreeStates);
                //$('#jqxTree').jqxTree('selectItem', null);
                // Create jqxExpander
                //$('#jqxExpander').jqxExpander({ showArrow: false, toggleMode: 'none', width: '400px', height: '500px'});
                // Create jqxTree

                /*$('#jqxTree').on('select',function (event)
                {
                    var args = event.args;
                    var item = $('#jqxTree').jqxTree('getItem', args.element);
                    var label = item.label;
                    item.selected = true;
                    console.log('select event'+label+" "+item+" "+args);
                    console.log(item);
                    console.log(args);

                    if(item.parentId == "carYear")
                    {
                        that.selectedCarYear = label;
                        var params = {label:label};
                        var data = that.getCarsData(params);
                        {
                            if(data)
                            {
                                that.carMakes(data);
                            }
                        }
                    }

                    if(item.parentId == "carMake"){
                        that.selectedManufacture = label;
                        var params = {manufacture:label};
                        var data = that.getCarsData(params);
                        {
                            if(data)
                            {
                                that.carModel(data);
                            }
                        }
                    }

                    if(item.parentId == "carModel"){
                        that.selectedModel = label;
                        var params = { carModel:label };
                        var data = that.getCarsData( params );
                        {
                            if( data )
                            {
                                that.carModel( data );
                            }
                        }
                    }
                });*/
            },
            prepareData : function(data,sourceId,name){
                this.source[sourceId].items = [];
                var newData = JSON.parse(data);
                for (var d in newData)
                    this.source[sourceId].items.push({label:""+newData[d][name]});
                this.render();
            },
            carModel : function(data){
                this.prepareData(data, 2, "ModelNm");
            },
            carMakes : function(data){
                this.prepareData(data, 1, "MfrName");
            },
            getCarsData : function(params){
                var that = this;
                var response ="";
                $.ajax({
                    async:false,
                    type:'post',
                    url:window.location.href+"ajax/index.php",
                    data:params,
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
    });


</script>

</body>
</html>
