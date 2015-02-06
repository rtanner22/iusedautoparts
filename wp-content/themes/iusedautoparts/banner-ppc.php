<section id="banner" class="content">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
        <h1>Thousands Of quality used OEM <? echo $_REQUEST['make']." ". $_REQUEST['model']; ?> parts</h1>
        <ul class="bullets">
          <li>Quick Quotes that save you money</li>
            <li>Save over 50% off dealer prices</li>
            <li>Fast delivery to your home or mechanic</li>
            <li>We service all major makes</li>
        </ul>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-2">
        <div class="form-search" style="display: block;">
          <div id="step1-title">
<?php
  if($_REQUEST['model'] && !$_REQUEST['make']) {

    $result = R::getAll( "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd where cplmodel LIKE '".$_REQUEST['model']."' order by make" );
    $_REQUEST['make'] = $result[0]['make'];
  }

  if($_REQUEST['part']) {
      $part = R::getAll( "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where indexlist.parttype = '".$_REQUEST['part']."' order by pdesc asc" );
  }
  //echo "select distinct ptype.Description as pdesc,indexlist.parttype as ptype from indexlist inner join ptype on ptype.PartType = indexlist.PartType where indexlist.parttype = '".$_REQUEST['part']."' order by pdesc asc";
  $partdesc = $part[0][pdesc];
  //echo "Model: ". $_REQUEST['model'];
  //$lcsql ="select * from hmodelxref where HMake LIKE '".$_REQUEST['make']."' AND HModel LIKE '".$_REQUEST['model']."' ";
//echo $lcsql;
  $result = R::getAll("select * from hmodelxref where cplmake = '".$_REQUEST['make']."' AND cplmodel = '".$_REQUEST['model']."' ");
?>
            <h2>What is the <u>YEAR</u> for your  <font color="red"><?php echo $_REQUEST['make'] . " " . $_REQUEST['model']; ?></font>?</h2>
            <p>Please provide the year of your vehicle so we can get you a price for your <? echo $partdesc;?> or <a href="http://www.autorecyclersonline.com">start a new search.</a></p>
          </div>
          <div id="step2-title" style="display: none;">
            <h2></h2>
          </div>
            <div id="group-slog">
                <div>Almost finished...</div>
                <div>Only two steps away to parts utopia!</div>
                <div class="little">(if we have the part in stock of course)</div>
            </div>
          <form action="/inventory" method="POST" name="searchform">
         <input type="hidden" name="reqid" id="reqid" value="" />
          <input type="hidden" name="openyear" id="openyear" value="true" />
          <input type="hidden" name="preload-ppc" id="preload-ppc" value="true" />
          <input type="hidden" name="preload-year" id="preload-year" value="<?php echo $_REQUEST[myear]; ?>" />
          <input type="hidden" name="preload-make" id="preload-make" value="<?php echo $_REQUEST[make]; ?>" />
          <input type="hidden" name="preload-model" id="preload-model" value="<?php echo $_REQUEST[model]; ?>" />
          <input type="hidden" name="preload-part" id="preload-part" value="<?php echo $_REQUEST[part]; ?>" />
<!--          <input type="hidden" name="preload-partname" id="preload-partname" value="<?php echo $partdesc; ?>" />-->
          <input type="hidden" name="showStep2" id="showStep2" value="true" />
            <div class="step1">
          <div id="group-year" class="form-group">
                <label for="year">Your vehicle’s model year:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
        <select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" >
        <option value="">Year</option> </select>
                  </div>
                </div>
              </div>
              <!--
              <div id="group-make" class="form-group">
                <label for="make">Your vehicle’s manufacturer:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake">
          <option>Make</option>
                 </select>
                  </div>
                </div>
              </div>
              <div id="group-model" class="form-group">
                <label for="model">Your vehicle’s model:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel">
          <option>Model</option>
                  </select>
                  </div>
                </div>
              </div>
              <div id="group-part" class="form-group">
                <label for="part">The part you're looking for:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart">
          <option>Part</option>
                  </select>
                  <input type="hidden" id="partname" name="partname" />
                  </div>
                </div>
              </div>
              <div id="group-button-option" class="form-group">
                <button id="btn-choose" type="submit" class="btn btn-orange btn-block" data-target="#search-form" data-slide-to="1">CHOOSE OPTIONS <i class="fa fa-arrow-right"></i></button>
              </div>-->

            </div>
            <div class="step2" style="display: none;">
              <div id="group-options" class="form-group">
                <div class="btn-group btn-group-justified" id="optionsbox">
                <label>Choose your option from the list below:</label>
                  <div class="btn-group" >
                  <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle active" data-toggle="dropdown"> <span class="selection">Select Options</span> <span class="caret"></span> </button>
                  <div class="dropdown-menu" size="10" role="menu" name="optionvalue" id="optionvalue" ></div>
                  <input type="hidden" name="hollanderoption" id="hollanderoption" />
                  </div>
                </div>
              </div>
              <div id="group-zip" class="form-group" style="display: none;">
                <label>Enter your Zip Code so we can find stock near you:</label>
                <input id="zip" type="text" class="form-control input-lg" placeholder="Enter Zip Code" />
                <label>(For quotes near your area)</label>
                <input id="email_ppc" type="email" class="form-control input-lg" placeholder="Enter your email to receive your quote" />
              </div>
              <div  id="group-button-check" class="form-group text-center" style="display: none;">
                <button id="btn-check" type="submit" class="btn btn-orange">CHECK STOCK <i class="fa fa-arrow-right"></i></button>
              </div>

            </div>



          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-progress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body center-block">
        <h3>Please wait while we search for inventory from our vendors..</h3>
        <div class="progress">
          <div class="progress-bar progress-bar-success bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
