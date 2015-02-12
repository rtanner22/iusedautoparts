<section id="banner" class="home">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
        <div class="steps hidden-xs hidden-sm">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div class="step">Step 1: Select Parts</div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div class="step text-center">Step 2: Choose Options</div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div class="step text-right">Step 3: Finish</div>

            </div>
          </div>
          <div class="row">
          	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             	<div class="line-indicator step1">
                </div>
             </div>
          </div>
        </div>
        <div class="hero">
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
          <div id="group-form" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-year" class="btn-group btn-group-justified">
                <div class="btn-group">
				<select class="btn btn-dropdown btn-lg dropdown-toggle" name="box-year" id="box-year" role="menu" tabindex="-1" >
				<option value="">Year</option> </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-make" class="btn-group btn-group-justified">
                <div class="btn-group">
                  <select id="box-make" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu" name="carmake" tabindex="-1">
					<option>Make</option>
                 </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-model" class="btn-group btn-group-justified">
                <div class="btn-group">
                  <select id="box-model" class="btn btn-dropdown btn-lg dropdown-toggle" role="menu" name="carmodel" tabindex="-1">
					<option>Model</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <div id="group-part" class="btn-group btn-group-justified">
                <div class="btn-group">
                  <select id="box-part" class="btn btn-dropdown btn-lg dropdown-toggle"  role="menu"  name="carpart" tabindex="-1">
					<option>Part</option>
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
                  <input type="hidden" name="hollanderoption" id="hollanderoption" />
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="zipbox">
              <div id="group-zip" style="display: none;">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-6">
                        <input id="firstname" type="text" class="form-control input-lg" placeholder="Enter your First Name" name="firstname" />
                    </div>
                    <div class="col-xs-6">
                        <input id="phonenumber" type="text" name="phonenumber" class="form-control input-lg" placeholder="Enter your Phone Number" />
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-6">
                        <input id="email_ppc" type="email" name="email_ppc" class="form-control input-lg" placeholder="Enter your email to receive your quote" />
                    </div>
                    <div class="col-xs-6">
                        <input id="zip" type="text" class="form-control input-lg" placeholder="Enter Zip Code" name="zipcode" />
                    </div>
                </div>  
              </div>
            </div>
          </div>
          <div  id="group-button-check" class="form-group text-center" style="display: none;">
            <button id="btn-check" type="submit" class="btn btn-orange">CHECK STOCK <i class="fa fa-arrow-right"></i></button>
          </div>
          <ol class="indicators">
            <li class="active"></li>
            <li></li>
            <li></li>
          </ol>
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
