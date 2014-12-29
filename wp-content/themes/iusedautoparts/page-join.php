<?php
/*
Template Name: Page Join
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'banner', 'content' ); ?>

<section id="content">
  <div class="wrap alt">
    <div class="container">
    	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; else: ?>
      <p>
        <?php _e('Sorry, no posts matched your criteria.'); ?>
      </p>
      <?php endif; ?>
      <?php
        if($_GET['mail']=="true") {
      //$admin_email = "dbmathewes@gmail.com";
      $headers = 'From: New ARO Trial Request <noreply@autorecyclersonline.com>';
      $admin_email = "admin@autorecyclersonline.com";
	  //$admin_email = "rtanner22@gmail.com";
      $subject = "New ARO Trial!";
      
	  $body = 
	  "Name: " . $_POST['contact_name'] . " \n\n".
	  "Company Name: ".$_POST['contact_company']." \n\n".
	  "Address 1: ".$_POST['contact_address1']." \n\n".
	  "Address 2: ".$_POST['contact_address2']." \n\n".
	  "City: ".$_POST['contact_zip']." \n\n".
	  "State: ".$_POST['contact_state']." \n\n".
	  "Zip: ".$_POST['contact_zip']." \n\n".
	  "Phone: ".$_POST['contact_phone']." \n\n".
	  "Fax: ".$_POST['contact_fax']." \n\n".
	  "Email: ".$_POST['contact_email']." \n\n".	  
	  "Inventory: ".$_POST['inventorysystem']." \n\n".	  
	  "Message: ".$_POST['contact_message'] ;  
	  
	  
	  
        mail($admin_email, $subject, $body,$headers);
        echo "Thank you! You will be contacted shortly to get your trial setup.<br><br>";
      }else
	  {echo "Getting started is easy. We offer a free trial for 30 days with no contract.  Just fill out the form below and we’ll contact you the same business day.<br><br>";}
  		?>
		
		
      <form action="?mail=true" method="post">
        <div class="form-group">
            <input type="text" name="contact_name" value="" placeholder="Contact name" class="form-control" />
        </div>
		
		
		<div class="form-group">
			<input type="text" name="contact_company"  value="" placeholder="Company Name" class="form-control" />
		</div>
        

		<div class="form-group">
			<input type="text" name="contact_address1"  value="" placeholder="Address 1" class="form-control" />
		</div>

		
		<div class="form-group">
			<input type="text" name="contact_address2"  value="" placeholder="Address 2" class="form-control" />
		</div>

		<div class="form-group">
			<input type="text" name="contact_city"  value="" placeholder="City" class="form-control" />
		</div>

		<div class="form-group">
			<input type="text" name="contact_state"  value="" placeholder="State" class="form-control" />
		</div>

		<div class="form-group">
			<input type="text" name="contact_zip"  value="" placeholder="Zip" class="form-control" />
		</div>

		<div class="form-group">
			<input type="text" name="contact_phone"  value="" placeholder="Phone" class="form-control" />
		</div>

		<div class="form-group">
			<input type="text" name="contact_fax"  value="" placeholder="Fax" class="form-control" />
		</div>

		
		
		<div class="form-group">
			<input type="text" name="contact_email"  value="" placeholder="Email" class="form-control" />
		</div>
        
		<div class="form-group">
		<select name="inventorysystem" class="form-control">
			<option selected="selected">Powerlink</option>
			<option>Checkmate</option>
			<option>Pinnacle</option>
		</select>
		</div>


        <div class="form-group">
          <textarea name="contact_message" id="message" placeholder="Additional Notes" cols="70" rows="10" class="form-control"></textarea>
        </div>
        
		
		<button id="submit-contact" type="submit" class="btn btn-orange">Submit</button>
		</form>
	</div>
    
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        	<ul id="sidebar">
				<?php get_sidebar (); ?>
            </ul>
        </div>
        </div>
  </div>
</section>
<?php get_footer(); ?>
