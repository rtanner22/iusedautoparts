<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?php if(is_home()) { echo bloginfo("name"); echo " - "; echo bloginfo("description"); } else { echo wp_title(" - ", false, right); echo bloginfo("name"); } ?></title>



<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('template_url'); ?>/css/select2.css" rel="stylesheet"/>
<link href="<?php bloginfo('template_url'); ?>/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_url'); ?>/css/site.css" rel="stylesheet" type="text/css" >
<script src="<?php bloginfo('template_url'); ?>/js/detect.js"></script>
<script>
 SA.redirection_mobile ({
    mobile_url : "www.iusedautoparts.com/search/",
  });
</script>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="page">
  <section id="mobile-nav" class="visible-xs">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="iUsedAutoParts"/></a> </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php bloginfo('url'); ?>/about-us">ABOUT US</a></li>

            <li class="dropdown"> <a href="/partslist" class="dropdown-toggle" data-toggle="dropdown">PARTS LIST <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php bloginfo('url'); ?>/water-pump">Water Pump</a></li>
              </ul>
            </li>
            <li><a href="<?php bloginfo('url'); ?>/contact">CONTACT</a></li>
          </ul>


        </div>
      </div>
    </nav>
  </section>
  <header id="header">
    <div class="container">
      <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <ul class="nav nav-pills nav-justified">
            <li><a href="<?php bloginfo('url'); ?>/about-us">ABOUT US</a></li>
            <li>
            	<a href="/partslist">PARTS LIST</a>

            </li>
          </ul>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <div class="logo text-center"><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="iUsedAutoParts"/></a></div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <ul class="nav nav-pills nav-justified">
            <li><a href="<?php bloginfo('url'); ?>/contact">CONTACT</a></li>
            <li><a href="https://www.twitter.com/" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li>
            <li><a href="https://www.facebook.com/iusedautoparts" target="_blank"><i class="fa fa-facebook fa-lg"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

