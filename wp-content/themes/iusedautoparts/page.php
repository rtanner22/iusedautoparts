<?php get_header(); ?>
<?php get_template_part( 'banner' ); ?> 
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
</section>
<?php get_footer(); ?>