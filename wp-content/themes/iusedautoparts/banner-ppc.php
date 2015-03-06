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
              <h2><span class="text-blue-h2" id="yearInfo"></span> <span class="text-blue-h2" id="modelInfo"></span> <span class="text-blue-h2" id="makeInfo"></span><span class="text-blue-span" id="partInfo"> <?php echo $partdesc; ?></span></h2>
          </div>
            <div id="group-slog">
                <div>Almost finished...</div>
                <div>Only two steps away to parts utopia!</div>
                <div class="little">(if we have the part in stock of course)</div>
            </div>
         <form action="/inventory" method="POST" name="searchform" class="formsubmit formsubmit-content">
          <input type="hidden" name="reqid" id="reqid" value="" />
          <input type="hidden" name="openyear" id="openyear" value="true" />
          <input type="hidden" name="preload-ppc" id="preload-ppc" value="true" />
          <input type="hidden" name="preload-year" id="preload-year" value="<?php echo $_REQUEST[myear]; ?>" />
          <input type="hidden" name="preload-make" id="preload-make" value="<?php echo $_REQUEST[make]; ?>" />
          <input type="hidden" name="preload-model" id="preload-model" value="<?php echo $_REQUEST[model]; ?>" />
          <input type="hidden" name="preload-part" id="preload-part" value="<?php echo $_REQUEST[part]; ?>" />
          <input type="hidden" name="preload-partname" id="preload-partname" value="<?php echo $partdesc; ?>" />
          <input type="hidden" name="showStep2" id="showStep2" value="true" />
        <div class="step1">
            <div id="group-year" class="form-group">
                <label for="year">Your vehicle’s model year:</label>
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" >
                            <option value="">Year</option> 
                        </select>
                    </div>
                </div>
            </div>
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
                <input id="firstname" style="margin-bottom: 15px;" type="text" class="form-control input-lg" placeholder="Enter your First Name" name="firstname" />
                <input id="phonenumber" style="margin-bottom: 15px;" type="text" name="phonenumber" class="form-control input-lg" placeholder="Enter your Phone Number (Optional)" />
                <input id="email_ppc" style="margin-bottom: 15px;display: inline;" type="email" name="email_ppc" class="form-control input-lg" placeholder="Enter your email to receive your quote" />
                <input style="width: 50%;float:left;" id="zip" type="text" class="form-control input-lg" placeholder="Enter Zip Code" />
                <label class="label-ppc">(For quotes near your area)</label>
              </div>
              <div  id="group-button-check" class="form-group text-center task">
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
