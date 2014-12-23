<?php
	global $avia_config;

	$style 		= $avia_config['box_class'];
	$responsive	= avia_get_option('responsive_layout','responsive');
	$blank 		= isset($avia_config['template']) ? $avia_config['template'] : "";
	$headerS	= !$blank ? avia_header_setting() : "";
	$headerMenu = $responsive ? avia_get_option('header_menu','mobile_drop_down') : "";

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo " html_$style ".$responsive." ".$headerS;?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php if(function_exists('avia_set_title_tag')) { echo avia_set_title_tag(); } ?></title>
<!-- page title, displayed in your browser bar -->

<?php

	/*
	 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
	 * located in framework/php/function-set-avia-frontend.php
	 */
	 if (function_exists('avia_set_follow')) { echo avia_set_follow(); }


	 /*
	 * outputs a favicon if defined
	 */
	 if (function_exists('avia_favicon'))    { echo avia_favicon(avia_get_option('favicon')); }

?>


<!-- add feeds, pingback and stuff-->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> RSS2 Feed" href="<?php avia_option('feedburner',get_bloginfo('rss2_url')); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<!-- mobile setting -->
<?php

if( strpos($responsive, 'responsive') !== false ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';

?>


<?php

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */

	wp_head();
?>
</head>

<body>

<header itemtype="http://schema.org/WPHeader" itemscope="itemscope" role="banner" class="header_color light_bg_color mobile_drop_down" id="header">

            


            <div class="container_wrap container_wrap_logo" id="header_main">

                    
                    <div class="container" style="height: 88px; line-height: 88px;">

                        <strong class="logo bg-logo" style="max-width: 170px; width: auto;"><a href="http://www.carpartslocator.com/test/"><img title="Car Parts Locator Test" alt="Car Parts Locator Test" src="http://www.carpartslocator.com/test/wp-content/themes/enfold/images/layout/logo.png" style="max-width: 170px; width: auto;"></a></strong><nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation" data-selectname="Select a page" class="main_menu"><div class="avia-menu"><ul class="menu" id="avia-menu"><li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent active-parent-item dropdown_ul_available" id="menu-item-755"><a href="http://www.kriesi.at/themes/enfold/" style="padding-right: 13px; padding-left: 13px; height: 88px; line-height: 88px;"><span class="avia-bullet"></span>Home<span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span><span class="dropdown_available"></span></a>


<ul class="sub-menu" style="display: block; opacity: 0; visibility: hidden;">
	<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-734 current_page_item" id="menu-item-2285"><a href="http://www.carpartslocator.com/test/"><span class="avia-bullet"></span>Home v1: Landing Page Style</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2292"><a href="http://www.carpartslocator.com/test/homepage/home-v2-3-col-images-contact/"><span class="avia-bullet"></span>Home v2: 3 Col + Contact</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2286"><a href="http://www.carpartslocator.com/test/homepage/home-v3-3-column-with-blog/"><span class="avia-bullet"></span>Home v3: 3 Column with Blog</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2291"><a href="http://www.carpartslocator.com/test/homepage/home-v4-small-slider/"><span class="avia-bullet"></span>Home v4: Small Slider</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2288"><a href="http://www.carpartslocator.com/test/homepage/home-v5/"><span class="avia-bullet"></span>Home v5: Portfolio Style</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2287"><a href="http://www.carpartslocator.com/test/homepage/home-v6-classic-4-column/"><span class="avia-bullet"></span>Home v6: Classic 4 Column</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2289"><a href="http://www.carpartslocator.com/test/homepage/home-v7-one-page-portfolio/"><span class="avia-bullet"></span>Home v7: One Page Portfolio</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2208"><a href="http://www.carpartslocator.com/test/homepage/home-v8-frontpage-shop/"><span class="avia-bullet"></span>Home v8: Frontpage Shop</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page dropdown_ul_available" id="menu-item-2272"><a href="http://www.carpartslocator.com/test/portfolio/" style="padding-right: 13px; padding-left: 13px; height: 88px; line-height: 88px;"><span class="avia-bullet"></span>Portfolio<span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span><span class="dropdown_available"></span></a>


<ul class="sub-menu" style="display: block; opacity: 0; visibility: hidden;">
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2273"><a href="http://www.carpartslocator.com/test/portfolio/portfolio-2-column/"><span class="avia-bullet"></span>Portfolio 2 Column</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2274"><a href="http://www.carpartslocator.com/test/portfolio/portfolio-3-column/"><span class="avia-bullet"></span>Portfolio 3 Column</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2276"><a href="http://www.carpartslocator.com/test/portfolio/"><span class="avia-bullet"></span>Portfolio 4 Column</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-portfolio" id="menu-item-2277"><a href="http://www.carpartslocator.com/test/portfolio-item/slider-two-third/"><span class="avia-bullet"></span>Single Portfolio: 2/3 Slider</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2290"><a href="http://www.carpartslocator.com/test/portfolio/portfolio-ajax/"><span class="avia-bullet"></span>Portfolio Ajax</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-portfolio" id="menu-item-2278"><a href="http://www.carpartslocator.com/test/portfolio-item/lorem-ipsum/"><span class="avia-bullet"></span>Single Portfolio: 2/3 Gallery</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-portfolio" id="menu-item-2279"><a href="http://www.carpartslocator.com/test/portfolio-item/portfolio-big/"><span class="avia-bullet"></span>Single Portfolio: Big Slider</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-portfolio" id="menu-item-2280"><a href="http://www.carpartslocator.com/test/portfolio-item/vimeo-video/"><span class="avia-bullet"></span>Single Portfolio: Fullscreen Slider</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page dropdown_ul_available" id="menu-item-2271"><a href="http://www.carpartslocator.com/test/blog/" style="padding-right: 13px; padding-left: 13px; height: 88px; line-height: 88px;"><span class="avia-bullet"></span>Blog<span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span><span class="dropdown_available"></span></a>


<ul class="sub-menu" style="display: block; opacity: 0; visibility: hidden;">
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2306"><a href="http://www.carpartslocator.com/test/blog/blog-grid/"><span class="avia-bullet"></span>Blog Grid</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2284"><a href="http://www.carpartslocator.com/test/blog/blog-multi-author/"><span class="avia-bullet"></span>Blog Multi Author</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2283"><a href="http://www.carpartslocator.com/test/blog/blog-single-small/"><span class="avia-bullet"></span>Blog Single Author Small</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2282"><a href="http://www.carpartslocator.com/test/blog/blog-single-author-big/"><span class="avia-bullet"></span>Blog Single Author Big</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2281"><a href="http://www.carpartslocator.com/test/blog/blog-single-author-full/"><span class="avia-bullet"></span>Blog Single Author Fullwidth</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page dropdown_ul_available" id="menu-item-2293"><a href="http://www.carpartslocator.com/test/pages/" style="padding-right: 13px; padding-left: 13px; height: 88px; line-height: 88px;"><span class="avia-bullet"></span>Pages<span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span><span class="dropdown_available"></span></a>


<ul class="sub-menu" style="display: block; opacity: 0; visibility: hidden;">
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2295"><a href="http://www.carpartslocator.com/test/pages/about-us/"><span class="avia-bullet"></span>About Us</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2299"><a href="http://www.carpartslocator.com/test/pages/blank/"><span class="avia-bullet"></span>Blank Pages</a>
	<ul class="sub-menu" style="display: block; opacity: 0; visibility: hidden;">
		<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2302"><a href="http://www.carpartslocator.com/test/pages/blank/"><span class="avia-bullet"></span>What is a Blank Page?</a></li>
		<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2300"><a href="http://www.carpartslocator.com/test/pages/blank/maintenance-mode/"><span class="avia-bullet"></span>Maintenance Mode</a></li>
		<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2301"><a href="http://www.carpartslocator.com/test/pages/blank/coming-soon/"><span class="avia-bullet"></span>Coming Soon</a></li>
	</ul>
</li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2297"><a href="http://www.carpartslocator.com/test/pages/contact/"><span class="avia-bullet"></span>Contact</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2303"><a href="http://www.carpartslocator.com/test/pages/faq/"><span class="avia-bullet"></span>FAQ</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2298"><a href="http://www.carpartslocator.com/test/pages/help/"><span class="avia-bullet"></span>Help</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2305"><a href="http://www.carpartslocator.com/test/pages/landing-page/"><span class="avia-bullet"></span>Landing Page</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2294"><a href="http://www.carpartslocator.com/test/pages/team/"><span class="avia-bullet"></span>Meet the Team</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2296"><a href="http://www.carpartslocator.com/test/pages/pricing/"><span class="avia-bullet"></span>Pricing</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2304"><a href="http://www.carpartslocator.com/test/pages/services/"><span class="avia-bullet"></span>Services</a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page" id="menu-item-2275"><a href="http://www.carpartslocator.com/test/shortcodes/" style="padding-right: 13px; padding-left: 13px; height: 88px; line-height: 88px;"><span class="avia-bullet"></span>Shortcodes<span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span></a></li>
<li class="noMobile menu-item menu-item-search-dropdown" id="menu-item-search"><a data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" data-avia-search-tooltip="

&lt;form action=&quot;http://www.carpartslocator.com/test/&quot; id=&quot;searchform&quot; method=&quot;get&quot; class=&quot;&quot;&gt;
	&lt;div&gt;
		&lt;input type=&quot;submit&quot; value=&quot;&quot; id=&quot;searchsubmit&quot; class=&quot;button avia-font-entypo-fontello&quot; /&gt;
		&lt;input type=&quot;text&quot; id=&quot;s&quot; name=&quot;s&quot; value=&quot;&quot; placeholder='Search' /&gt;
			&lt;/div&gt;
&lt;/form&gt;" href="" style="padding-right: 0px; padding-left: 13px; height: 88px; line-height: 88px;"></a></li></ul></div></nav>                    <!-- end container-->
                    </div>



            <!-- end container_wrap-->
            </div>

            <div class="header_bg"></div>

        <!-- end header -->
        </header>



</body>
</html>
