<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
  
 <?php wp_title('-',true,'left'); ?>

</title>

<?php echo of_get_option('google_textarea'); ?>
		 


<?php  if(of_get_option('favicon_uploader')) { ?>        
       <link rel="icon" type="image/png" href="<?php echo of_get_option('favicon_uploader'); ?>" />         <?php } ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />	
	<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>


<!--HEADER START-->


 
 <?php get_template_part(''.$head = of_get_option('head_select', 'header').''); ?>
