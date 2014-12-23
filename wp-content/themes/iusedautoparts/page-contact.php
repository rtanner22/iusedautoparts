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
      $headers = 'From: IUAP Contact Form <noreply@autorecyclersonline.com>';
      $admin_email = "admin@drivetrainleads.com";
      $subject = "Message from autorecyclersonline.com";
      $body = "Name: " . $_POST['contact_name'] . " \n\nEmail: ".$_POST['contact_email']." \n\nMessage: ";
      $body .= $_POST['contact_message'];
        mail($admin_email, $subject, $body,$headers);
        echo "Your message has been sent.";
      }
  ?>
  <form action="?mail=true" method="post">
        <p>
        <input type="text" name="contact_name" value="" placeholder="Your name" />
        </p>
      <p>
      <input type="text" name="contact_email"  value="" placeholder="Your email" />
      </p>
        <p>
        <textarea name="contact_message" id="message" placeholder="message" cols="70" rows="10"></textarea>
      </p>
      <button id="submit-contact" type="submit" class="btn btn-orange">Submit</button>
      </form>
    </div>
  </div>
</section>
<?php get_footer(); ?>
