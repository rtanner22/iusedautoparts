
    <footer id="footer">
    <section class="footer-nav">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          		<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 
											'container'       => 'ul',			
											'menu_class' => 'footer-links',
											'depth' => 1 ) ); ?>
            
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <ul class="footer-socials pull-right">
              <li><a href="https://www.facebook.com/iusedautoparts/" class="facebook" target="_blank">FACEBOOK</a></li>
              <li><a href="https://twitter.com/" class="twitter" target="_blank">TWITTER</a></li>
             <!-- <li><a href="https://plus.google.com/" class="google" target="_blank">GOOGLE+</a></li>
              <li><a href="https://www.pinterest.com/" class="pinterest" target="_blank">PINTEREST</a></li>
              <li><a href="http://instagram.com/" class="instagram" target="_blank">INSTAGRAM</a></li>-->
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <p class="copy">&copy; COPYRIGHT AutoRecyclersOnline.com <?php echo date("Y") ?>. ALL RIGHTS RESERVED.</p>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-copy', 
											'container'       => 'ul',			
											'menu_class' => 'footer-links pull-right',
											'depth' => 1 ) ); ?>
            
          </div>
        </div>
      </div>
    </section>
  </footer>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.loader.js"></script>
    <link href="<?php bloginfo('template_url'); ?>/js/jquery.loader.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/scripts/demos.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxtree.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/select2.js"></script>
    
<script>
$(document).ready(function(){
	$("#box-year").select2({placeholder: "Year",selectOnBlur:false});
	$("#box-make").select2({placeholder: "Make",selectOnBlur:false});
	$("#box-model").select2({placeholder: "Model",selectOnBlur:false});
	$("#box-part").select2({placeholder: "Part",selectOnBlur:false});
	$("#partoption0").select2({placeholder: "Part Option",selectOnBlur:false});
	for(a=1; a<12; a++)
	{
	  $("#partoption"+a).select2({placeholder: "Part Option " +a});
	}
});

</script>
<script src="<?php bloginfo('template_url'); ?>/js/site.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2096092-10', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
