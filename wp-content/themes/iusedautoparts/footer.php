
    <footer id="footer">
    <section class="footer-nav">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <ul class="footer-links">
              <li><a href="<?php bloginfo('url'); ?>/">HOME</a></li>
              <li><a href="<?php bloginfo('url'); ?>/about">ABOUT US</a></li>
              <li><a href="<?php bloginfo('url'); ?>/partslist">PARTS LIST</a></li>
              <li><a href="<?php bloginfo('url'); ?>/">BLOG</a></li>
              <li><a href="<?php bloginfo('url'); ?>/contact">CONTACT</a></li>
            </ul>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <ul class="footer-socials pull-right">
              <li><a href="https://www.facebook.com/" class="facebook" target="_blank">FACEBOOK</a></li>
              <li><a href="https://twitter.com/" class="twitter" target="_blank">TWITTER</a></li>
              <li><a href="https://plus.google.com/" class="google" target="_blank">GOOGLE+</a></li>
              <li><a href="https://www.pinterest.com/" class="pinterest" target="_blank">PINTEREST</a></li>
              <li><a href="http://instagram.com/" class="instagram" target="_blank">INSTAGRAM</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <p class="copy">&copy; COPYRIGHT IUSEDAUTOPARTS <?php echo date("Y") ?>. ALL RIGHTS RESERVED.</p>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <ul class="footer-links pull-right">
              <li><a href="<?php bloginfo('url'); ?>/terms-and-conditions">TERMS OF USE</a></li>
              <li><a href="<?php bloginfo('url'); ?>/privacy">PRIVACY STATEMENT</a></li>
              
            </ul>
          </div>
        </div>
      </div>
    </section>
  </footer>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxtree.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/scripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/scripts/demos.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqwidgets/jqwidgets/jqxtree.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/select2.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.validate.min.js"></script>
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
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/site.js"></script>
</body>
</html>