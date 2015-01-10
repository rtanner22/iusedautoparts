<?php

    //$result = R::getAll("select * from requests where id = '".$_REQUEST['reqid']."' ");

?>

<section id="banner" class="content">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
        <h3>We’re automotive industry veterans. We’ve dedicated our time and talents to building a huge resource online for car parts. We feel we’ve done that successfully. We’re tired of hearing customers tell us they can’t find parts locally. Our Car Parts Locator tool was built to bridge the gap between sellers and buyers.</h3>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-2">
        <div class="form-search" style="display: block;">
          <div id="step1-title" class="headers">
            <h1>PICK YOUR PART NOW!</h1>
            <h2>IT'S QUICK, EASY, AND PAINLESS</h2>
          </div>
          <div id="step2-title" style="display: none;">
            <h2></h2>
          </div>
          <form action="/inventory" method="POST" name="searchform">
          <input type="hidden" name="reqid" id="reqid" value="" />
          <input type="hidden" name="openyear" id="openyear" value="false" />
          <input type="hidden" name="preload-year" id="preload-year" value="<?php echo $_REQUEST[year]; ?>" />
          <input type="hidden" name="preload-make" id="preload-make" value="<?php echo $_REQUEST[make]; ?>" />
          <input type="hidden" name="preload-model" id="preload-model" value="<?php echo $_REQUEST[model]; ?>" />
          <input type="hidden" name="preload-part" id="preload-part" value="<?php echo $_REQUEST[part]; ?>" />
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
              <div id="group-make" class="form-group" style="display: none;">
                <label for="year">Your vehicle’s manufacturer:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake">
					<option>Make</option>
                 </select>
                  </div>
                </div>
              </div>
              <div id="group-model" class="form-group" style="display: none;">
                <label for="year">Your vehicle’s model:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel">
					<option>Model</option>
                  </select>
                  </div>
                </div>
              </div>
              <div id="group-part" class="form-group" style="display: none;">
                <label for="year">The part you're looking for:</label>
                <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                  <select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart">
					<option>Part</option>
                  </select>
                  <input type="hidden" id="partname" name="partname" />
                  </div>
                </div>
              </div>
              <div id="group-button-option" class="form-group" style="display: none;">
                <button id="btn-choose" type="submit" class="btn btn-orange btn-block" data-target="#search-form" data-slide-to="1">CHOOSE OPTIONS <i class="fa fa-arrow-right"></i></button>
              </div>
            </div>
            <div class="step2" style="display: none;">
			  <div id="group-go-back" class="form-group">
					<a id="btn-go-back"> <span class="selection"> GO BACK</span> </a>
			  </div>
              <div id="group-options" class="form-group">
                <div class="btn-group btn-group-justified" id="optionsbox">
                <label>Choose your option from the list below:</label>


                  <div class="btn-group">
                    <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle active" data-toggle="dropdown"> <span class="selection">Select Options</span> <span class="caret"></span> </button>
                    <div class="dropdown-menu" size="10" role="menu" name="optionvalue" id="optionvalue" style="background-color:#ffffff" ></div>
                    <input type="hidden" name="hollanderoption" id="hollanderoption" />
                  </div>
                </div>
              </div>
              <div id="group-zip" class="form-group" style="display: none;">
                <label>Enter your Zip Code so we can find stock near you:</label>
                <input id="zip" type="text" class="form-control input-lg" placeholder="e.g. 10003" />
              </div>
              <div  id="group-button" class="form-group text-center" style="display: none;">
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
      	<h3>Please wait while we search for inventory from our vendor..</h3>
        <div class="progress">
          <div class="progress-bar progress-bar-success bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
