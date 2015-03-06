<?php
//if(file_exists('testing/inc/rb.phar'))
//	require 'testing/inc/rb.phar';

//R::setup('mysql:host=qs3505.pair.com;dbname=rtanner2_cpl',    'rtanner2_38','BHeFVC7i');
    global $mainresult;
	$mainresult = R::getAll("select * from requests where id = '".$_REQUEST['reqid']."' ");
    $zipcode = $mainresult[0][zip];
?>
<section id="banner" class="inventory">
<div class="mascot">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
        <div class="hero">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" >
            	<div id="change-search-title">
              <h4>You're searching for a(n) <span><?php echo $mainresult[0][part]; ?></span> for a <span><?php echo $mainresult[0][year]; ?> <?php echo $mainresult[0][make]; ?> <?php echo $mainresult[0][model]; ?> </span> <!--with <span>7 OPTIONS SELECTED</span> --></h4>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">  <a id="btn-change-search" href="#" class="btn btn-orange btn-block btn-sm" data-toggle="collapse" data-target="#search-form"><span id="loading" style="display:none"><img src="<?php bloginfo('template_url'); ?>/images/SpinningWheel2.gif" width='18px' height='18px'></span> CHANGE SEARCH <i class="fa fa-chevron-down"></i></a> </div>
          </div>
          <div id="search-form" class="collapse">
          <form action="/inventory" method="POST" name="searchform" class="formsubmit">
          <input type="hidden" name="reqid" id="reqid" value="<?php echo $_REQUEST['reqid']; ?>" />
          <input type="hidden" name="openyear" id="openyear" value="false" />

          <input type="hidden" name="preload-year" id="preload-year" value="<?php echo $mainresult[0][year]; ?>" />
          <input type="hidden" name="preload-make" id="preload-make" value="<?php echo $mainresult[0][make]; ?>" />
          <input type="hidden" name="preload-model" id="preload-model" value="<?php echo $mainresult[0][model]; ?>" />
          <input type="hidden" name="preload-part" id="preload-part" value="<?php echo substr($mainresult[0][hnumber], 0,3); ?>" />
          <input type="hidden" name="preload-part" id="preload-chpartname" value="<?php echo $mainresult[0][part]; ?>" />
          <input type="hidden" name="preload-option" id="preload-option" value="<?php echo $mainresult[0][hollanderoption]; ?>" />
          <div id="group-form" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-year" class="btn-group btn-group-justified">
                <div class="btn-group">
<!--                  <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" data-toggle="dropdown"> <span class="selection">Year</span> <span class="caret"></span> </button>-->
                 <!-- <div class="dropdown-menu">-->
				<select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" >
				<option value="<?php echo $mainresult[0][year]; ?>" selected="selected"><?php echo $mainresult[0][year]; ?></option> </select>

                 <!-- </div> -->
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-make" class="btn-group btn-group-justified">
                <div class="btn-group">
     <!--             <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle" data-toggle="dropdown"> <span class="selection">Make</span> <span class="caret"></span> </button>-->
                  <select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake">
					<option value="<?php echo $mainresult[0][make]; ?>" selected="selected"><?php echo $mainresult[0][make]; ?></option>
                 </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-model" class="btn-group btn-group-justified">
                <div class="btn-group">
        <!--          <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle" data-toggle="dropdown"> <span class="selection">Model</span> <span class="caret"></span> </button>-->
                  <select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel">
					<option value="<?php echo $mainresult[0][model]; ?>" selected="selected"><?php echo $mainresult[0][model]; ?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-part" class="btn-group btn-group-justified">
                <div class="btn-group">
        <!--          <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle" data-toggle="dropdown" id="part-name"> <span class="selection">Part</span> <span class="caret"></span> </button>-->
                  <select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart">
					<option value="<?php echo $mainresult[0][part]; ?>" selected="selected"><?php echo $mainresult[0][part]; ?></option>
                  </select>
                  <input type="hidden" id="partname" name="partname" />
                </div>
              </div>
            </div>
          </div>
          <div id="group-options" class="row" style="display: none;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="optionsbox">
              <label>Choose your option from the list below:</label>
              <div class="btn-group btn-group-justified">
                <div class="btn-group">
                </div>
                  <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle active" data-toggle="dropdown"> <span class="selection">Select Options</span> <span class="caret"></span> </button>
                  <div class="menu select2-drop" size="10" role="menu" name="optionvalue" id="optionvalue" ></div>
                  <input type="hidden" name="hollanderoption" id="hollanderoption" value="<?php echo $mainresult[0]['hnumber']; ?>" />
              </div>
<!--              <div class="btn-group btn-group-justified">
                <div class="btn-group">
                  <button type="button" class="btn btn-dropdown btn-lg dropdown-toggle active" data-toggle="dropdown"> <span class="selection">Select Options</span> <span class="caret"></span> </button>
                  <div class="dropdown-menu" size="10" role="menu" name="optionvalue" id="optionvalue" ></div>
                  <input type="hidden" name="hollanderoption" id="hollanderoption" />
                </div>
              </div>-->
            </div>
            <div class="col-xs-12 " id="zipbox">
                <div id="group-zip" style="display: none;">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-6">
                        <input id="firstname" type="text" class="form-control input-lg" placeholder="Enter your First Name" name="firstname" value="<?php echo $_POST['firstname']; ?>"/>
                    </div>
                    <div class="col-xs-6">
                        <input id="phonenumber" type="text" name="phonenumber" class="form-control input-lg" placeholder="Enter your Phone Number (Optional)" value="<?php echo array_key_exists('phonenumber', $_POST) ? $_POST['phonenumber']: ''; ?>" />
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-6">
                        <input id="email_ppc" type="email" name="email_ppc" class="form-control input-lg" placeholder="Enter your email to receive your quote" value="<?php echo $_POST['email_ppc']; ?>"/>
                    </div>
                    <div class="col-xs-6">
                        <input id="zip" type="text" class="form-control input-lg" placeholder="Enter Zip Code" name="zipcode" value="<?php echo $mainresult[0][zip]; ?>"/>
                    </div>
                </div>  
              </div>
            </div>
          </div>
          <div  id="group-button" class="form-group text-center" style="display: none;">
            <button id="btn-check" type="submit" class="btn btn-orange">CHECK STOCK <i class="fa fa-arrow-right"></i></button>

          </div>
          </form>
          </div>
          </div>
        </div>
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
