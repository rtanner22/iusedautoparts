<?php
/*
Template Name: Page Home
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'banner', 'home' ); ?> 
<section id="content">
  <div class="wrap">
    <div class="container">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; else: ?>
      <p>
        <?php _e('Sorry, no posts matched your criteria.'); ?>
      </p>
      <?php endif; ?>
    </div>
  </div>
  <div class="wrap alt">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="panel panel-custom">
              <div class="panel-body">
                <div class="text-center">
                  <p><img src="<?php bloginfo('template_url'); ?>/images/vehicle.png" alt="POPULAR VEHICLES"/></p>
                  <p><a href="#" class="btn btn-custom">POPULAR VEHICLES</a></p>
                  <p>Specify your part, select year, make, model & name the autopart., model and name of the autopart</p>
                </div>
                <div class="row">
                	<div class="col-sm-4">
                    	<ul>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                        </ul>
                    </div>
                	<div class="col-sm-4">
                    	<ul>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                    	<ul>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                          <li><a href="#">Acura</a></li>
                        </ul>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="panel panel-custom">
              <div class="panel-body">
                <div class="text-center">
                  <p><img src="<?php bloginfo('template_url'); ?>/images/parts.png" alt="POPULAR PARTS"/></p>
                  <p><a href="#" class="btn btn-custom">POPULAR PARTS</a></p>
                  <p>Below is a list of the most popular parts searched for. Click <a href="http://www.iusedautoparts.com/partslist/">here</a> for a complete list.</p>
                </div>
                <div class="row">
                	<div class="col-sm-12" >
                    	<ul>
                          <li><a href="http://www.iusedautoparts.com/partslist/engine_assembly/">Engine</a></li>
                          <li><a href="http://www.iusedautoparts.com/partslist/side_view_mirror/">Door Mirror</a></li>
                          <li><a href="http://www.iusedautoparts.com/partslist/transmission/">Transmission</a></li>
                          <li><a href="http://www.iusedautoparts.com/partslist/ac_compressor/">AC Compressor</a></li>
                          <li><a href="http://www.iusedautoparts.com/partslist/air_flow_meter/">Air Flow Meter</a></li>
                          <li><a href="http://www.iusedautoparts.com/partslist/front_lower_control_arm/">Front Lower Control Arm</a></li>
						  <li><a href="http://www.iusedautoparts.com/partslist/spindle_knuckle/">Spindle Knuckle</a></li>
						  <li><a href="http://www.iusedautoparts.com/partslist/steering_column/">Steering Column</a></li>
						  <li><a href="http://www.iusedautoparts.com/partslist/window_regulator/">Window Regulator</a></li>
						  
						  
                        </ul>
						</div>
						 
                    </div>
                	
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<?php get_footer(); ?>