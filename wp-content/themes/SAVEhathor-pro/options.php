<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
$number_array = array("1" => "One","2" => "Two","3" => "Three","4" => "Four","5" => "Five", "6" => "Six","7" => "Seven","8" => "Eight","9" => "Nine","10" => "Ten");
$numberfront_array = array("1" => "One","2" => "Two","3" => "Three","4" => "Four","5" => "Five", "6" => "Six","7" => "Seven","8" => "Eight","9" => "Nine","10" => "Ten","11" => "Eleven", "12" => "Twelve");

	
	
	// Test data
	$slider_array = array("nivo" => "Nivo Slider","noslider" => "No Slider");
	
	// slider effect  
	$effcet_array= array("sliceDown"=>"sliceDown","sliceDownLeft"=>"sliceDownLeft","sliceUp"=>"sliceUp","sliceUpLeft"=>"sliceUpLeft","sliceUpDown"=>"sliceUpDown","fold"=>"fold","fade"=>"fade","random"=>"random","slideInRight"=>"slideInRight","slideInLeft"=>"slideInLeft","boxRandom"=>"boxRandom","boxRain"=>"boxRain","boxRainReverse"=>"boxRainReverse","boxRainGrow"=>"boxRainGrow","boxRainGrowReverse"=>"boxRainGrowReverse");
	
	// Test data
		$related_array = array("categories" => "Related by categories","tags"=> "Related by tags");
	
	// Test data
	$block_array = array("service" => "style1","service2" => "style2","service3" => "style3");
	
	
	// Test data
		$head_array = array("head1" => "Head1","head2"=> "Head2","head3"=>"Head3","head4"=>"Head4");
	
	// Test data
		$footer_array = array("footer1" => "Full width","footer2"=> "Box");
		
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// Editor Defaults
		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'media_buttons' => 'true',
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	
	// Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
        foreach ($options_categories_obj as $category) {
                $options_categories[$category->cat_ID] = $category->cat_name;
        }
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/admin/images/';
	
	
	
		
	
	
	
	$options = array();
	
	
	
	
	
	$options[] = array( "name" => __('Front Page', 'hathor'),
						"type" => "heading");
	
	
						
	$options[] = array( "name" => __('Latest Post Layout', 'isis'),
						"desc" => "Select a front page layout",
						"id" => "layout1_images","layout2_images",
						"std" => "layout1",
						"type" => "images",
						"options" => array(
							'layout1' => $imagepath.'layout1.png',
							'layout2' => $imagepath.'layout2.png',
							'layout3' => $imagepath.'layout3.png',
							'layout4' => $imagepath.'layout4.png',
							
							
							));
							
							
	$options[] = array( "name" => __('Select header style', 'hathor'),
						"desc" => "Select a header layout",
						"id" => "head_select",
						"std" => "head1",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $head_array);
						
	$options[] = array( "name" => __('Select footer style', 'hathor'),
						"desc" => "Select a footer layout",
						"id" => "footer_select",
						"std" => "footer1",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $footer_array);
						
						
	 $options[] = array( "name" => __('Call us number and Address', 'isis'),
						"desc" => "",
						"id" => "call_num",
						"std" => "<b>Call us number:</b>  +00 123 456 789",
						"type" => "editor",	
						'settings' => $wp_editor_settings);	
							
$options[] = array( "name" => __('Custom logo image', 'hathor'),
						"desc" => __('You can upload custom image for your website logo (optional).', 'hathor'),
						
						"id" => "hathor_logo_image",
						"type" => "upload");
						
$options[] = array(     'name' => __('Upload a Favicon', 'options_framework_theme'),     
                        'desc' => __('Upload a favicon on your theme, size must be 16px by 16px', 'osiris'),     
						'id' => 'favicon_uploader',     
						'type' => 'upload');	
						
	
	$options[] = array(
         'name' => __('Latest Blog Title', 'hathor'),
		'desc' => __('Title For the Latest Blog', 'hathor'),
		'id' => 'latest_blog',
		'std' => 'Latest Blog',
		'type' => 'text');
				
						
	$options[] = array( "name" => __('Enable Latest Posts', 'hathor'),
						"desc" => "Enable the posts under the blocks on homepage. You can only use options below when this option is tick.",
						"id" => "latstpst_checkbox",
						"std" => "1",
						"type" => "checkbox");
						
	
	
	$options[] = array( "name" => __('Footer Content', 'hathor'),
						"desc" => "Footer Text.",
						"id" => "footer_textarea",
						"std" => "Theme By Imon themes",
						"type" => "editor",
						'settings' => $wp_editor_settings); 
						
		//Callout and welcome Section
		
	$options[] = array( "name" => __('Callout & welcome', 'hathor'),
						"type" => "heading");	
	
	$options[] = array( "name" => __('Enable Home Page callout section 1', 'isis'),
						"desc" => "Enable the Home Page callout section. You can only use options below when this option is tick.",
						"id" => "callout1_enable",
						"std" => "1",
						"type" => "checkbox");				
						
		 $options[] = array( "name" => __('Home Page Callout section 1', 'isis'),
						"id" => "isis_call1",
                         "desc" => "Appear under Service Block section ",
						"std" => "<h5>Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe Nam nec rhoncus. </h5>",
						"type" => "editor", 
						
						'settings' => $wp_editor_settings);	
						
	$options[] = array( 
						"desc" => "Callout section 1 Link",
						"id" => "call1_link",
						"std" => "",
						"type" => "text");	
						
			$options[] = array( 
						"desc" => "Callout section 1 Link name",
						"id" => "call1_linkname",
						"std" => "Download",
						"class" => "mini",
						"type" => "text");	
						
		
		$options[] = array( "name" => __('Enable Home Page callout section 2', 'isis'),
						"desc" => "Enable the Home Page callout section. You can only use options below when this option is tick.",
						"id" => "callout2_enable",
						"std" => "0",
						"type" => "checkbox");
			
		 $options[] = array( "name" => __('Home Page Callout section 2', 'isis'),
		                 "desc" => "Appear under Client section ",
						"id" => "isis_call2",
                 
						"std" => "<h5>Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe Nam nec rhoncus. </h5>",
						"type" => "editor", 
						
						'settings' => $wp_editor_settings);	
						
	$options[] = array( 
						"desc" => "Callout section 2 Link",
						"id" => "call2_link",
						"std" => "",
						"type" => "text");	
						
			$options[] = array( 
						"desc" => "Callout section 2 Link name",
						"id" => "call2_linkname",
						"std" => "Download",
						"class" => "mini",
						"type" => "text");	
						
			$options[] = array( "name" => __('Enable Home Page callout section 3', 'isis'),
						"desc" => "Enable the Home Page callout section. You can only use options below when this option is tick.",
						"id" => "callout3_enable",
						"std" => "0",
						"type" => "checkbox");			
						
		 $options[] = array( "name" => __('Home Page Callout section 3', 'isis'),
		                 "desc" => "Appear under Slider ",
						"id" => "isis_call3",
                 
						"std" => "<h5>Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe Nam nec rhoncus. </h5>",
						"type" => "editor", 
						
						'settings' => $wp_editor_settings);	
						
	$options[] = array( 
						"desc" => "Callout section 3 Link",
						"id" => "call3_link",
						"std" => "",
						"type" => "text");	
						
			$options[] = array( 
						"desc" => "Callout section 3 Link name",
						"id" => "call3_linkname",
						"std" => "Buy Now",
						"class" => "mini",
						"type" => "text");	
		
	$options[] = array( "name" => __('Enable Home Page Welcome section 1', 'isis'),
						"desc" => "Enable Home Page Welcome section 1. You can only use options below when this option is tick.",
						"id" => "welcome1_enable",
						"std" => "1",
						"type" => "checkbox");		
						
						
	 $options[] = array( "name" => __('Home Page Welcome section', 'hathor'),
						"id" => "hathor_welcome",
                        "desc" => __('<b>Appear Under Recent Work</b> ','hathor'),
						"std" => "<h1>Welcome!</h1><h2>You need to configure your Home Page! </h2>Please visit Theme Options Page",
						"type" => "editor", 
						
						'settings' => $wp_editor_settings);
						
						
		$options[] = array( "name" => __('Enable Home Page Welcome section 2', 'isis'),
						"desc" => "Enable Home Page Welcome section 2. You can only use options below when this option is tick.",
						"id" => "welcome2_enable",
						"std" => "0",
						"type" => "checkbox");					
			
			 $options[] = array( "name" => __('Home Page Welcome section 2', 'hathor'),
						"id" => "hathor1_welcome",
                        "desc" => __('<b>Appear Under Slider</b> ','hathor'),
						"std" => "<h1>Welcome!</h1><h2>You need to configure your Home Page! </h2>Please visit Theme Options Page",
						"type" => "editor", 
						
						'settings' => $wp_editor_settings);
						

     //Color & Font
		
	$options[] = array( "name" => __('Color & Font', 'hathor'),
						"type" => "heading");
						
						
	$options[] = array(
		'name' => __('Color & Font', 'hathor'),
		'type' => 'info');
		
				
						
	$options[] = array( "name" => __('Font import link', 'hathor'),
						"desc" => 'font import link, for example: @import url(http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz);
 all available fonts can be found at <a target="_blank" style=" color:#10a7d1;" href="https://www.google.com/fonts">Google fonts</a>.',
						"id" => "Font_text",
						"std" => " @import url(http://fonts.googleapis.com/css?family=Raleway);",
						"type" => "text");

	$options[] = array( "name" => __('Font family', 'hathor'),
						"desc" => "for example:Yanone Kaffeesatz ",
						"id" => "font2_text",
						"std" => "Raleway",
						"class" => "mini",
						"type" => "text");					
	
	$options[] = array( "name" => __('secondary background color', 'hathor'),
						"desc" => "
Change secondary background color of theme
",
						"id" => "sec_colorpicker",
						"std" => "#fff",
						"type" => "color");
						
		$options[] = array( 
		                 "name" => __('All element text  color', 'hathor'),
						"desc" => "All element text  color",
						"id" => "text_colorpicker",
						"std" => "#000",
						"type" => "color");

$options[] = array( "name" => __('Header,Footer and Menu color ', 'hathor'),
						);

    $options[] = array( 
						"desc" => "Header background color",
						"id" => "header_colorpicker",
						"std" => "#fff",
						"type" => "color");
	 $options[] = array( 
						"desc" => "title   color",
						"id" => "titel_colorpicker",
						"std" => "#000000",
						"type" => "color");
		
		$options[] = array( 
						"desc" => "menu text color",
						"id" => "menutext_colorpicker",
						"std" => "#000000",
						"type" => "color");
		
		$options[] = array( 
						"desc" => "menu  color (header 2,header 3)",
						"id" => "menu_colorpicker",
						"std" => "#cecece",
						"type" => "color");
			
		$options[] = array( 
						"desc" => "Sub Menu Background color",
						"id" => "submenu_colorpicker",
						"std" => "#373737",
						"type" => "color");
		
		$options[] = array( 
						"desc" => "Sub menu text color",
						"id" => "submanu_colorpicker",
						"std" => "#e5e5e5",
						"type" => "color");
						
		$options[] = array( 
						"desc" => "Footer Background  color",
						"id" => "footer_colorpicker",
						"std" => "#272727",
						"type" => "color");
		$options[] = array( 
						"desc" => "Footer widget Background  color",
						"id" => "widfooter_colorpicker",
						"std" => "#373737",
						"type" => "color");
		
		$options[] = array( 
						"desc" => "Footer widget text  color",
						"id" => "widtext_colorpicker",
						"std" => "#fff",
						"type" => "color");

   $options[] = array( "name" => __('page title  or banner background  Color', 'hathor'),
						"desc" => "page title  or banner background color",
						"id" => "pagetitel_colorpicker",
						"std" => "#26AE90",
						"type" => "color");
	
	$options[] = array( 
						"desc" => "page title  or banner text  Color",
						"id" => "pagetext_colorpicker",
						"std" => "#CCC",
						"type" => "color");
	
	$options[] = array( "name" => __('flavor Color', 'hathor'),
						"desc" => "Change flavor color",
						"id" => "flavour_colorpicker",
						"std" => "#26AE90",
						"type" => "color");
							
	 $options[] = array( "name" => __('Hover Color', 'hathor'),
						"desc" => "Change all element hover color",
						"id" => "hover_colorpicker",
						"std" => "#ff4533",
						"type" => "color");
				
     $options[] = array( "name" => __('Service block ', 'hathor')
						);
						
	 $options[] = array( 
						"desc" => "Service block background color",
						"id" => "servbg_colorpicker",
						"std" => "#fff",
						"type" => "color");
	 $options[] = array( 
						"desc" => "Service block text color",
						"id" => "servtext_colorpicker",
						"std" => "#000000",
						"type" => "color");	
						
	 $options[] = array( "name" => __('welcome block background  Color', 'hathor'),
						"desc" => "welcome block background  Color",
						"id" => "wellbg_colorpicker",
						"std" => "#F0F0F0",
						"type" => "color");	
						
	 $options[] = array( "name" => __('call out background  Color', 'hathor'),
						"desc" => "call out background  Color  Color",
						"id" => "callbg_colorpicker",
						"std" => "#FAFAFA",
						"type" => "color");					
										
//slider
	
		
						
	$options[] = array( "name" => __('Sliders', 'hathor'),
						"type" => "heading");
						
	
	$options[] = array(
		'name' => __('Slider', 'options_framework_theme'),
		'desc' => __('<b> For best results Upload every slider images in same size.  images of size 1000px * ____px</b>', 'hathor'),
		'type' => 'info');	
						
	$options[] = array( "name" => __('Select Slider', 'hathor'),
						"desc" => "",
						"id" => "slider_select",
						"std" => "nivo",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $slider_array);
						
	$options[] = array( "name" => __('Select Slider effect  (nivo)', 'isis'),
						"desc" => "",
						"id" => "effcet_select",
						"std" => "random",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => 	$effcet_array);
	
	$options[] = array(
         'name' => __('Link', 'hathor'),
		'desc' => __('Link  of the slider', 'hathor'),
		'id' => 'sliderlink2',
		'std' => 'Read More',
		"class" => "mini",
		'type' => 'text');
						
						
	$options[] = array( "name" => __('Slider Speed', 'hathor'),
						"desc" => "milliseconds",
						"id" => "sliderspeed_text",
						"std" => "6000",
						"class" => "mini",
						"type" => "text");	
						
$options[] = array( "name" => __('Number of Slides', 'hathor'),
						"desc" => "",
						"id" => "number_select",
						"std" => "5",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $number_array);						
						
	$options[] = array( "name" => __('Slider Content', 'hathor'),
						"desc" => "Show Slider text",
						"id" => "sldrtxt_checkbox",
						"std" => "1",
						"type" => "checkbox");	
	$options[] = array( 
						"desc" => "Show Slider Title",
						"id" => "sldrtitle_checkbox",
						"std" => "1",
						"type" => "checkbox");	
	
	$options[] = array( 
						"desc" => "Show Slider Description ",
						"id" => "sldrdes_checkbox",
						"std" => "1",
						"type" => "checkbox");	
	
						
	$options[] = array( 
						"desc" => "Slider title  font size",
						"id" => "titels_colorpicker",
						"std" => "24px",
						"class" => "mini",
						"type" => "text");	
						
	$options[] = array( 
						"desc" => "Slider caption font size",
						"id" => "caption_colorpicker",
						"std" => "16px",
						"class" => "mini",
						"type" => "text");	
						
 $options[] = array( "name" => __('slider title   background  Color', 'hathor'),
						"desc" => "slider title   background  Color",
						"id" => "slidertitel_colorpicker",
						"std" => "#26AE90",
						"type" => "color");
		
 $options[] = array( 
						"desc" => "slider title  text  Color",
						"id" => "slidertext_colorpicker",
						"std" => "#fff",
						"type" => "color");
						
$options[] = array( "name" => __('slider Excerpt  background  Color', 'hathor'),
						"desc" => "slider Excerpt  background  Color",
						"id" => "sliderdsc_colorpicker",
						"std" => "#fff",
						"type" => "color");
		
 $options[] = array( 
						"desc" => "slider Excerpt text  Color",
						"id" => "sliderdsct_colorpicker",
						"std" => "#000000",
						"type" => "color");
		
$options[] = array( "name" => __('slider button background  Color', 'hathor'),
						"desc" => "slider button background  Color",
						"id" => "sliderbutton_colorpicker",
						"std" => "#26AE90",
						"type" => "color");		
	//Services Bloks	
		
$options[] = array( "name" => __('Services Bloks', 'hathor'),
						"type" => "heading");		
		
$options[] = array( "name" => __('Enable Blocks', 'hathor'),
						"desc" => "Enable the homepage blocks.",
						"id" => "blocks_checkbox",
						"std" => "1",
						"type" => "checkbox");
						
$options[] = array( "name" => __('Open link in new tab', 'hathor'),
						"desc" => "Enable Open link in new tab.",
						"id" => "newtab_checkbox",
						"std" => "0",
						"type" => "checkbox");	
											
$options[] = array(
         'name' => __('Link', 'hathor'),
		'desc' => __('Link  of the service block', 'hathor'),
		'id' => 'servicelink2',
		'std' => 'Show Me Details',
		"class" => "mini",
		'type' => 'text');
						
$options[] = array( "name" => __('Select service block style', 'hathor'),
						"desc" => "",
						"id" => "block_select",
						"std" => "service",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $block_array);
						

						
    $options[] = array( "name" => __('Block 1 Logo', 'hathor'),
						"desc" => 'Icon name, for example: fa-heart
List of all available icons and their names can be found at <a target="_blank" style=" color:#10a7d1;" href="http://fontawesome.io/cheatsheet/">FontAwesome</a>.',
						"id" => "block1_logo",
						"std" => "fa-heart",
						"class" => "mini",
						"type" => "text");
						
						
$options[] = array( "name" => __('Custom image block 1(style1)', 'hathor'),
						"desc" => __('You can upload custom image for your service block 1', 'hathor'),
						'std' =>get_template_directory_uri().'/images/demo/1.jpg',
						"id" => "block1_image",
						"type" => "upload");	
						
	$options[] = array( "name" => __('Block 1 Heading', 'hathor'),
						"desc" => "",
						"id" => "block1_text",
						"std" => "We Work Efficiently",
						"type" => "text");
							
	$options[] = array( "name" => __('Block 1 Text', 'hathor'),
						"desc" => "",
						"id" => "block1_textarea",
						"std" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibendum ac.",
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('Block 1 Link', 'hathor'),
						"desc" => "",
						"id" => "block1_link",
						"std" => "http://wordpress.org/",
						"type" => "text");
						
						
			
	
	  $options[] = array( "name" => __('Block 2 Logo', 'hathor'),
						"desc" => 'Icon name, for example:  fa-heart
List of all available icons and their names can be found at <a target="_blank" style=" color:#10a7d1;" href="http://fontawesome.io/cheatsheet/">FontAwesome</a>.',
						"id" => "block2_logo",
						"std" => " fa-volume-up",
						"class" => "mini",
						"type" => "text");		
						
						
$options[] = array( "name" => __('Custom image block 2(style1)', 'hathor'),
						"desc" => __('You can upload custom image for your service block 2', 'hathor'),
						
						"id" => "block2_image",
						"type" => "upload");				
						
	$options[] = array( "name" => __('Block 2 Heading', 'hathor'),
						"desc" => "",
						"id" => "block2_text",
						"std" => "24/7 Live Support",
						"type" => "text");
							
	$options[] = array( "name" => __('Block 2 Text', 'hathor'),
						"desc" => "",
						"id" => "block2_textarea",
						"std" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibendum ac. Sed ultrices leo.",
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('Block 2 Link', 'hathor'),
						"desc" => "",
						"id" => "block2_link",
						"std" => "",
						"type" => "text");
						
						
	$options[] = array( "name" => __('Block 3 Logo', 'hathor'),
						"desc" => 'Icon name, for example:  fa-heart
List of all available icons and their names can be found at <a target="_blank" style=" color:#10a7d1;" href="http://fontawesome.io/cheatsheet/">FontAwesome</a>.',
						"id" => "block3_logo",
						"std" => "fa-fighter-jet",
						"class" => "mini",
						"type" => "text");		
						
						
	$options[] = array( "name" => __('Custom image block 3(style1)', 'hathor'),
						"desc" => __('You can upload custom image for your service block 3', 'hathor'),
						
						"id" => "block3_image",
						"type" => "upload");	
						

	$options[] = array( "name" => __('Block 3 Heading', 'hathor'),
						"desc" => "",
						"id" => "block3_text",
						"std" => "Confide",
						"type" => "text");
							
	$options[] = array( "name" => __('Block 3 Text', 'hathor'),
						"desc" => "",
						"id" => "block3_textarea",
						"std" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibendum ac. ",
						"type" => "textarea");
						
	$options[] = array( "name" => __('Block 3 Link', 'hathor'),
						"desc" => "",
						"id" => "block3_link",
						"std" => "",
						"type" => "text");
	
	
	$options[] = array( "name" => __('Block 4 Logo', 'hathor'),
						"desc" => 'Icon name, for example: fa-heart
List of all available icons and their names can be found at <a target="_blank" style=" color:#10a7d1;" href="http://fontawesome.io/cheatsheet/">FontAwesome</a>.',
						"id" => "block4_logo",
						"std" => "fa-cogs",
						"class" => "mini",
						"type" => "text");	
						
						
$options[] = array( "name" => __('Custom image block 4(style1)', 'hathor'),
						"desc" => __('You can upload custom image for your service block 4', 'hathor'),
						
						"id" => "block4_image",
						"type" => "upload");		

	$options[] = array( "name" => __('Block 4 Heading', 'hathor'),
						"desc" => "",
						"id" => "block4_text",
						"std" => "Gurantee Like No Other",
						"type" => "text");
							
	$options[] = array( "name" => __('Block 4 Text', 'hathor'),
						"desc" => "",
						"id" => "block4_textarea",
						"std" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum.",
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('Block 4 Link', 'hathor'),
						"desc" => "",
						"id" => "block4_link",
						"std" => "",
						"type" => "text");		
		
		
//Recent work

$options[] = array( "name" => __('Recent work', 'hathor'),
					
						"type" => "heading");


$options[] = array( "name" => __('Enable Recent work', 'hathor'),
						"desc" => "Enable the homepage recent work.image size 300X222 px",
						"id" => "recentwork_checkbox",
						"std" => "1",
						
						"type" => "checkbox");
						
$options[] = array( "name" => __('Open link in new tab', 'hathor'),
						"desc" => "Enable Open link in new tab.",
						"id" => "newtab2_checkbox",
						"std" => "0",
						"type" => "checkbox");	
						
$options[] = array(
         'name' => __('Title', 'hathor'),
		'desc' => __('Title of the recent work slider', 'hathor'),
		'id' => 'recent_work',
		'std' => 'Showcase Our Work',
		'type' => 'text');


$options[] = array(
         'name' => __('Tagline', 'hathor'),
		'desc' => __('Tagline of the recent work slider', 'hathor'),
		'id' => 'recent_work2',
		'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit, sapien non placerat tempor, tortor sapien molestie dui, ut bibendum
enim pretium augue. Morbi gravida urna quis lectus vestibulum auctor id sapien dignissim et convallis est rhoncus.',
		'type' => 'text');
		
$options[] = array(
         'name' => __('Link name', 'hathor'),
		'desc' => __('Link  of the recent work slider', 'hathor'),
		'id' => 'recentlink2',
		'std' => 'Read More',
		"class" => "mini",
		'type' => 'text');

		
$options[] = array(
		'name' => __('Image 1', 'hathor'),
		'desc' => __('First image', 'hathor'),
		'id' => 'recent1',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/bg2.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle1',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc1',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl1',
		'std' => '',
		'type' => 'text');	


$options[] = array(
		'name' => __('Image 2', 'hathor'),
		'desc' => __('2nd image', 'hathor'),
		'id' => 'recent2',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/bg4.png',
		'type' => 'upload');

	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle2',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc2',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Image 3', 'hathor'),
		'desc' => __('3rd image', 'hathor'),
		'id' => 'recent3',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/bg5.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle3',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc3',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl3',
		'std' => '',
		'type' => 'text');		
		
		
	
	
	
	$options[] = array(
		'name' => __('Image 4', 'hathor'),
		'desc' => __('4th image', 'hathor'),
		'id' => 'recent4',
		'std' =>get_template_directory_uri().'/images/demo/bg5.png',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle4',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc4',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl4',
		'std' => '',
		'type' => 'text');		
		
		
	
	$options[] = array(
		'name' => __('Image 5', 'hathor'),
		'desc' => __('5th image', 'hathor'),
		'id' => 'recent5',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle5',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc5',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl5',
		'std' => '',
		'type' => 'text');	


$options[] = array(
		'name' => __('Image 6', 'hathor'),
		'desc' => __('6th image', 'hathor'),
		'id' => 'recent6',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle6',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc6',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl6',
		'std' => '',
		'type' => 'text');	
	
	
	
	$options[] = array(
		'name' => __('Image 7', 'hathor'),
		'desc' => __('7th image', 'hathor'),
		'id' => 'recent7',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle7',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc7',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl7',
		'std' => '',
		'type' => 'text');	
		
		
$options[] = array(
		'name' => __('Image 8', 'hathor'),
		'desc' => __('8th image', 'hathor'),
		'id' => 'recent8',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle8',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc8',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl8',
		'std' => '',
		'type' => 'text');	
		
		
	$options[] = array(
		'name' => __('Image 9', 'hathor'),
		'desc' => __('9th image', 'hathor'),
		'id' => 'recent9',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'recenttitle9',
		'std' => 'Beautiful Photo',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'recentdesc9',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'recenturl9',
		'std' => '',
		'type' => 'text');	
		
//Out Team

$options[] = array( "name" => __('Our Team', 'hathor'),
						"type" => "heading");




$options[] = array( "name" => __('Enable Our Team', 'hathor'),
						"desc" => "Enable the homepage Our Team.image size 300X300 px",
						"id" => "ourteam_checkbox",
						"std" => "1",
						
						"type" => "checkbox");
						
$options[] = array( "name" => __('Open link in new tab', 'hathor'),
						"desc" => "Enable Open link in new tab.",
						"id" => "newtab3_checkbox",
						"std" => "0",
						"type" => "checkbox");
						
$options[] = array(
         'name' => __('Title', 'hathor'),
		'desc' => __('Title of the Our Team slider', 'hathor'),
		'id' => 'ourteam_work',
		'std' => 'Meet The Dream Team',
		'type' => 'text');


$options[] = array(
         'name' => __('Tagline', 'hathor'),
		'desc' => __('Tagline of the Our Team slider', 'hathor'),
		'id' => 'ourteam_work2',
		'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit, sapien non placerat tempor, tortor sapien molestie dui, ut bibendum
enim pretium augue. Morbi gravida urna quis lectus vestibulum auctor id sapien dignissim et convallis est rhoncus.',
		'type' => 'text');
$options[] = array(
		'name' => __('Image 1', 'hathor'),
		'desc' => __('First image', 'hathor'),
		'id' => 'ourteam1',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/team1.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle1',
		'std' => 'Mr.ronty',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc1',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl1',
		'std' => '',
		'type' => 'text');	


$options[] = array(
		'name' => __('Image 2', 'hathor'),
		'desc' => __('2nd image', 'hathor'),
		'id' => 'ourteam2',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/team2.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle2',
		'std' => 'Mr.Monty',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc2',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Image 3', 'hathor'),
		'desc' => __('3rd image', 'hathor'),
		'id' => 'ourteam3',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/team3.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle3',
		'std' => 'ms.oly',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc3',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl3',
		'std' => '',
		'type' => 'text');		
		
		
	
	
	
	$options[] = array(
		'name' => __('Image 4', 'hathor'),
		'desc' => __('4th image', 'hathor'),
		'id' => 'ourteam4',
		'std' =>get_template_directory_uri().'/images/demo/team1.png',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle4',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc4',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl4',
		'std' => '',
		'type' => 'text');	
		
		
	$options[] = array(
		'name' => __('Image 5', 'hathor'),
		'desc' => __('5th image', 'hathor'),
		'id' => 'ourteam5',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle5',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc5',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl5',
		'std' => '',
		'type' => 'text');		
		
	
	$options[] = array(
		'name' => __('Image 6', 'hathor'),
		'desc' => __('6th image', 'hathor'),
		'id' => 'ourteam6',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle6',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc6',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl6',
		'std' => '',
		'type' => 'text');		
		
	
	$options[] = array(
		'name' => __('Image 7', 'hathor'),
		'desc' => __('7th image', 'hathor'),
		'id' => 'ourteam7',
	
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle7',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc7',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl7',
		'std' => '',
		'type' => 'text');	
		
	
	$options[] = array(
		'name' => __('Image 8', 'hathor'),
		'desc' => __('8th image', 'hathor'),
		'id' => 'ourteam8',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle8',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc8',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl8',
		'std' => '',
		'type' => 'text');		
		
		
	$options[] = array(
		'name' => __('Image 9', 'hathor'),
		'desc' => __('9th image', 'hathor'),
		'id' => 'ourteam9',
	
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle9',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc9',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl9',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Image 10', 'hathor'),
		'desc' => __('10th image', 'hathor'),
		'id' => 'ourteam10',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle10',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc10',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl10',
		'std' => '',
		'type' => 'text');
		
		
	$options[] = array(
		'name' => __('Image 11', 'hathor'),
		'desc' => __('11th image', 'hathor'),
		'id' => 'ourteam11',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle11',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc11',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl11',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Image 12', 'hathor'),
		'desc' => __('12th image', 'hathor'),
		'id' => 'ourteam12',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle12',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc12',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl12',
		'std' => '',
		'type' => 'text');		
		
		
$options[] = array(
		'name' => __('Image 13', 'hathor'),
		'desc' => __('13th image', 'hathor'),
		'id' => 'ourteam13',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle13',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc13',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl13',
		'std' => '',
		'type' => 'text');	
		
		
$options[] = array(
		'name' => __('Image 14', 'hathor'),
		'desc' => __('14th image', 'hathor'),
		'id' => 'ourteam14',
		
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'ourteamtitle14',
		'std' => 'Mr.Imon',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'ourteamdesc14',
		'std' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy.',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'ourteamurl14',
		'std' => '',
		'type' => 'text');	
						
	
	
//Our Client

$options[] = array( "name" => __('Our Client', 'hathor'),
						"type" => "heading");


$options[] = array( "name" => __('Our Client', 'hathor'),
	                   'desc' => __('Image size must be 223px*113px.', 'hathor'),
					   'type' => 'info'
						); 	
						
$options[] = array( "name" => __('Enable our client', 'hathor'),
						"desc" => "Enable the homepage Our Client",
						"id" => "ourclient_checkbox",
						"std" => "1",
						
						"type" => "checkbox");	
						
$options[] = array( "name" => __('Open link in new tab', 'hathor'),
						"desc" => "Enable Open link in new tab.",
						"id" => "newtab4_checkbox",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array(
         'name' => __('Our Client Title', 'hathor'),
		'desc' => __('Title of the Our Client', 'hathor'),
		'id' => 'our_client',
		'std' => 'Our Client',
		'type' => 'text');
							
	$options[] = array(
		'name' => __('Client One', 'hathor'),
		'desc' => __('Upload image for client one ', 'hathor'),
		'id' => 'client1',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo1.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl1',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Client 2', 'hathor'),
		'desc' => __('Upload image for client 2 ', 'hathor'),
		'id' => 'client2',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo2.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl2',
		'std' => '',
		
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Client 3', 'hathor'),
		'desc' => __('Upload image for client 3 ', 'hathor'),
		'id' => 'client3',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo3.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl3',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Client 4', 'hathor'),
		'desc' => __('Upload image for client 4 ', 'hathor'),
		'id' => 'client4',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl4',
		'std' => '',
		'type' => 'text');		
		
											
	
	$options[] = array(
		'name' => __('Client 5', 'hathor'),
		'desc' => __('Upload image for client 5 ', 'hathor'),
		'id' => 'client5',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl5',
		'std' => '',
		'type' => 'text');	
		
		
   $options[] = array(
		'name' => __('Client 6', 'hathor'),
		'desc' => __('Upload image for client 6 ', 'hathor'),
		'id' => 'client6',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl6',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Client 7', 'hathor'),
		'desc' => __('Upload image for client 7 ', 'hathor'),
		'id' => 'client7',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl7',
		'std' => '',
		'type' => 'text');	
							
	$options[] = array(
		'name' => __('Client 8', 'hathor'),
		'desc' => __('Upload image for client 8 ', 'hathor'),
		'id' => 'client8',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl8',
		'std' => '',
		'type' => 'text');
		
	
	$options[] = array(
		'name' => __('Client 9', 'hathor'),
		'desc' => __('Upload image for client 9 ', 'hathor'),
		'id' => 'client9',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl9',
		'std' => '',
		'type' => 'text');	
		
		
   $options[] = array(
		'name' => __('Client 10', 'hathor'),
		'desc' => __('Upload image for client 10 ', 'hathor'),
		'id' => 'client10',
		'class' => '',
		'std' =>get_template_directory_uri().'/images/demo/logo4.png',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'clienturl10',
		'std' => '',
		'type' => 'text');												
	
			
	$options[] = array( "name" => __('Social', 'hathor'),
						"type" => "heading");						
						
						
	$options[] = array( "name" => __('Facebook', 'hathor'),
						"desc" => "Your Facebook url",
						"id" => "fbsoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('Twitter', 'hathor'),
						"desc" => "Your Twitter url",
						"id" => "ttsoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('Google Plus', 'hathor'),
						"desc" => "Your Google Plus url",
						"id" => "gpsoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('Youtube', 'hathor'),
						"desc" => "Your Youtube url",
						"id" => "ytbsoc_text",
						"std" => "#",
						"type" => "text");
						
	
						
	$options[] = array( "name" => __('Pinterest', 'hathor'),
						"desc" => "Your Pinterest url",
						"id" => "pinsoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('vimeo', 'hathor'),
						"desc" => "Your vimeo url",
						"id" => "vimsoc_text",
						"std" => "#",
						"type" => "text");
	$options[] = array( "name" => __('LinkedIn', 'hathor'),
						"desc" => "Your LinkedIn url",
						"id" => "linsoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('flickr', 'hathor'),
						"desc" => "Your flickr url",
						"id" => "flisoc_text",
						"std" => "#",
						"type" => "text");
						
	$options[] = array( "name" => __('Rss', 'hathor'),
						"desc" => "Your RSS url",
						"id" => "rsssoc_text",
						"std" => "#",
						"type" => "text");
	
	
		
		
		//misceleneous				

	$options[] = array( "name" => __('Miscelleneous', 'hathor'),
						"type" => "heading");
						
					
	$options[] = array( "name" => __('Related Post', 'isis'),
						"desc" => "Show related articles",
						"id" => "rtl_checkbox",
						"std" => "1",
						"type" => "checkbox");
						
   $options[] = array( 
						"desc" => "Shows randomized related articles below the post",
						"id" => "related_posts",
						"std" => "categories",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $related_array);				
											
	$options[] = array( "name" => __('Right Sidebar', 'hathor'),
						"desc" => "Remove Right sidebar from all the pages and make the site full width.",
						"id" => "nosidebar_checkbox",
						"std" => "0",
						"type" => "checkbox");
						
						
	$options[] = array( "name" => __('Page Header ', 'hathor'),
						"desc" => "Enable Page Header ",
						"id" => "pagehead_checkbox",
						"std" => "1",
						"type" => "checkbox");		
  					
	$options[] = array( "name" => __('share this', 'hathor'),
						"desc" => "Enable share this",
						"id" => "share_checkbox",
						"std" => "1",
						"type" => "checkbox");
						
						
	
						
	$options[] = array( "name" => __('Category & Tags, Post Author Name', 'hathor'),
						"desc" => "Hide Post Categories ,Tags and Post Author Name",
						"id" => "disscats_checkbox",
						"std" => "0",
						"type" => "checkbox");
	
	$options[] = array( "name" => __('Google Analytics', 'isis'),
						"desc" => "Add Google Analytics code",
						"id" => "google_textarea",
						"std" => "",
						"type" => "textarea"); 
	
	
$options[] = array( "name" => __('Documentation', 'hathor'),
						"type" => "heading");	
	
$options[] = array( "name" => __('', 'isis'),
	                   'desc' => __('<b>About the theme</b> <br><p style="text-align:justify;font-size:14px;color:#000 !important;">Isis is a Simple, Clean and Responsive Retina Ready WordPress Theme which adapts automatically to your tablets and mobile devices. theme with 2 home page layouts,10 social icons,4 widget ,Slider,3 page templates – Full width page, 4 google fonts, font-awesome service icon,Upload logo option,The theme is translation ready and fully translated into all language. Isis is suitable for any types of website – corporate, portfolio, business, blog.</p></br></br>For Documentation <a target="_blank" href="http://bit.ly/documantation-hathor">Download This PDF.</a> <h4 style="text-align:center;color: #000;>About Developer</h4>
<p style="color: #000;> This Theme is designed and devloped by <a target="_blank" style=" color:#10a7d1;" href="http://www.imonthemes.com/"><span>Imon Themes</span></a><br /></p> 

<p style="color:#000;font-size: 18px;">1. Setting up the front  page</p><br>
<p style="color:#000;font-size: 14px;">				  
When you  select &ldquo;Your Latest Posts&rdquo; from Settings&gt; Reading you will be able to  display 8 frontpage elements on your site&rsquo;s frontpage. They are: <br>
<br>
i. Slider<br>
ii. Blocks<br>
iii. Welcome  Text<br>
iv. Frontpage  Posts<br>
v. Call to  Action<br>
vi. Recent work<br>
vii.Our Team<br>
viii.Our Client 
<br />
<br />
</p>
<p><p  style="color:#000;font-size: 16px;">i. Setting up the slider</p>
  From <strong>Slider => Add New</strong>  For each slide you should set: 
<p><img src="http://i.imgur.com/pHBVhNQ.png" alt="Create New Slide" width="637" height="493"></p>
  <br>
			
	<p style="color:#000;font-size: 16px;"> a.<strong>Image:</strong> Select/Upload Slide image by  clicking the Set featured image. If you are using the &ldquo;Full Width&rdquo; mode,  make sure the slider images have at least 1600px of width. If set to fixed, the  slider images should have minimum width of 1200px. If your images are bigger,  you can resize and crop them online using this application: <a target="_blank" href="http://pixlr.com/editor/">http://pixlr.com/editor/</a>. There&rsquo;s also a video tutorial on  youtube on how to resize and crop your images and save them: <a target="_blank" href="https://www.youtube.com/watch?v=WmFjvNlm1E4">https://www.youtube.com/watch?v=WmFjvNlm1E4</a><br>
  b. <strong>Title:</strong> Write a title of your  slide. This is optional; if you don&rsquo;t want to display the title of the slide  you should keep this empty.<br>
   c. <strong>Description:</strong> If you want to display a  little subtext under the title of the slide you should use this field. You can  use HTML tags.<br>
  d. <strong>Url:</strong> If you want your slide  image and title to contain a link, you should put it here.<br>	
  
   <p> 





'




, 'hathor'),
					   
					   'type' => 'info'
						); 						
		
	
	
	
						
		
	return $options;
}