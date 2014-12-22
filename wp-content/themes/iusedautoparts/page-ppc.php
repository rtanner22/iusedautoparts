<?php
/*
Template Name: Page PPC
*/

if(file_exists('testing/inc/rb.phar'))
	require 'testing/inc/rb.phar';
R::setup('mysql:host=192.168.200.100;dbname=iusedparts',
    'iusedparts','5huYvRDH');
?>
<?php get_header(); ?>
<?php get_template_part( 'banner', 'ppc' ); ?>
<?php
	if($_REQUEST['model'] && !$_REQUEST['make']) {
		$result = R::getAll( "select distinct hmodelxref.cplmake as make from carline inner join hmodelxref on hmodelxref.HMakeCode = carline.MfrCd where cplmodel LIKE '".$_REQUEST['model']."' order by make" );
		$_REQUEST['make'] = $result[0]['make'];
	}
	if($_REQUEST['part']) {
	    $part = R::getAll( "select distinct ptype.Description as pdesc, ptype.Description_long as pdesclong,image from ptype where ptype.parttype = '".$_REQUEST['part']."' order by pdesc asc" );
	}
	$partdesc = $part[0][pdesc];
    $result = R::getAll("select * from hmodelxref where HMake LIKE '".$_REQUEST['make']."' AND HModel LIKE '".$_REQUEST['model']."' ");
	//$result = R::getAll("select * from hmodelxref ");
?>
<section id="content">
  <div class="wrap alt">
    <div class="container">
    	<h1 id="getvalue"><?php echo $_REQUEST['make'] . " " . $_REQUEST['model'] . " " .  $part[0]['pdesc'];?></h1><br>
		<p>
		<?php echo $part[0]['pdesclong']; ?><br><br><br>
		<img src="<?php echo $part[0]['image']; ?>"/>
</p>
    </div>
 </div>
</section>
<?php get_footer(); ?>
