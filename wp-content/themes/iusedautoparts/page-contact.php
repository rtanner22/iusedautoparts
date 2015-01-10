<?php
/*
Template Name: Page Contact
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
      $headers = 'From: ARO Contact Form <noreply@autorecyclersonline.com>';
      $admin_email = "admin@drivetrainleads.com";
      $subject = "Message from Autorecyclersonline.com";
      $body = "Name: " . $_POST['contact_name'] . " \n\nEmail: ".$_POST['contact_email']." \n\nMessage: ";
      $body .= $_POST['contact_message'];
        mail($admin_email, $subject, $body,$headers);
        echo "Your message has been sent.";
      }
  		?>
      <form action="?mail=true" method="post">
        <div class="form-group">
            <input type="text" name="contact_name" value="" placeholder="Your name" class="form-control" />
          </div>
  <div class="form-group">
    <input type="text" name="contact_email"  value="" placeholder="Your email" class="form-control" />
  </div>
        
        <div class="form-group">
          <textarea name="contact_message" id="message" placeholder="Your message" cols="70" rows="10" class="form-control"></textarea>
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
