<?php get_header(); ?>
<?php get_template_part( 'banner','content' ); ?> 
<section id="content">
  <div class="wrap">
    <div class="container">
    	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			  <?php the_content(); ?>
              <?php endwhile; else: ?>
              <p>
                <?php _e('Sorry, no posts matched your criteria.'); ?>
              </p>
              <?php endif; ?>
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