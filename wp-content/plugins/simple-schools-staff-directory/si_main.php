<?php
/*
Plugin Name: Simple Schools Staff Directory
Description: Provides a simple staff directory with photos.
Plugin URI: http://www.simpleintranet.org/simple-schools
Description: Provides a simple searchable staff directory with photos, staff and away from school widgets.
Version: 1.1
Author: Simple Schools
Author URI: http://www.simpleintranet.org/simple-schools
License: GPL2

Credit goes Jake Goldman, Avatars Plugin, (http://www.10up.com/) for contributing to this code that allows for user photo uploads.

*/

add_action( 'init', 'si_create_bio_post_type' );
function si_create_bio_post_type() {

load_plugin_textdomain( 'simpleschools', false, dirname( plugin_basename( __FILE__ ) ). '/languages' ); 	
	
	$capabilities = array(
    'read_post' => 'si_read_profile',
    'publish_posts' => 'si_publish_profile',	
	'edit_post' => 'si_edit_profile',
	'edit_posts' => 'si_edit_profiles',
	'delete_post' => 'si_delete_profile',
	'delete_posts' => 'si_delete_profiles'
);
	register_post_type( 'si_profile',
		array(
			'labels' => array(
			'name' => __( 'Biographies' ),
			'singular_name' => __( 'Biography' )
			),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'public' => true,
		'show_ui'=> true,
		'capability_type'=> 'post',
		'exclude_from_search'=>true,
		'capabilities' => $capabilities,
		'menu_position' => 5,
		'has_archive' => true,
		 'rewrite' => array('slug' => 'bios','with_front' => FALSE),
		)
	);
	flush_rewrite_rules();
	$role = get_role( 'administrator' );
	$role2 = get_role( 'editor' );
				if ( is_object($role)) {
				$role->add_cap( 'si_read_profile' );
				$role->add_cap( 'si_publish_profile' );
				$role->add_cap( 'si_edit_profile' );
				$role->add_cap( 'si_edit_profiles' );
				$role->add_cap( 'si_delete_profile' );
				$role->add_cap( 'si_delete_profiles' );
			}
			if ( is_object($role2)) {
				$role2->add_cap( 'si_read_profile' );
				$role2->add_cap( 'si_publish_profile' );
				$role2->add_cap( 'si_edit_profile' );
				$role2->add_cap( 'si_edit_profiles' );
				$role2->add_cap( 'si_delete_profile' );
				$role2->add_cap( 'si_delete_profiles' );
}
}

include dirname(__FILE__) . '/avatars.php';

add_action( 'wp_enqueue_scripts', 'staff_style' );

function staff_style() {
        wp_register_style( 'staff-directory', plugins_url('/css/si_staff.css', __FILE__) );
        wp_enqueue_style( 'staff-directory' );
    }

if(is_admin()){
remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
 }

function si_add_contactmethod( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  $contactmethods['twitter'] = 'Twitter';  
  $contactmethods['facebook'] = 'Facebook';
  $contactmethods['linkedin'] = 'LinkedIn';
  $contactmethods['googleplus'] = 'Google+';
  return $contactmethods;
}
add_filter('user_contactmethods','si_add_contactmethod',10,1);

add_shortcode("staff", "si_contributors");
   
// OUT OF OFFICE DEFAULTS and CUSTOM FIELD LABELS
add_action('admin_init', 'office_text_default');

function office_text_default($defaults) {
	global $current_user,$letin ;	
     $user_id = $current_user->ID;
	 $letin=0;
	$expirytext= get_the_author_meta('expirytext', $user_id); 
	$officetext=get_the_author_meta('officenotification', $user_id); 
	if ($officetext==''){
	$out = __('Away from school.','simpleschools');
	update_user_meta( $user_id, 'officenotification', $out ); 	
	}
	if ($expirytext==''){
	$exptext = __('Back in ','simpleschools');
	update_user_meta( $user_id, 'expirytext', $exptext ); 	
	}
	return $defaults;	
	// ADD CUSTOM LABEL OPTIONS
add_option('phonelabel', 'Phone: ');
add_option('phoneextlabel', 'Extension: ');
add_option('mobilelabel', 'Mobile: ');
add_option('faxlabel', 'Fax: ');
add_option('custom1label', '');
add_option('custom2label', '');
add_option('custom3label', '');
add_option('profiledetail', '');
add_option('sroles', '');

}

// ALLOW HTML IN BIOGRAPHY

// his is to remove HTML stripping from Author Profile
remove_filter('pre_user_description', 'wp_filter_kses');
// This is to sanitize content for allowed HTML tags for post content
add_filter( 'pre_user_description', 'wp_filter_post_kses' );


//EXTRA PROFILE FIELDS 
function fb_add_custom_user_profile_fields( $user ) {
global $in_out;
?>
	<h3><?php _e('School Information', 'simpleschools'); ?></h3>
	<table class="form-table">
    <?php if(current_user_can('administrator') ) { ?>
    <tr>
			<th>
				<label for="profiledetail"><?php _e('Enable Detailed Staff Directory Page?', 'simpleschools'); ?>
			</label></th>
			<td align="left">
           
				<input type="checkbox" name="profiledetail" id="profiledetail" value="Yes"  <?php if (get_option( 'profiledetail' )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> <label for="profiledetail" ><?php _e('Check if you want to include a clickable profile page accessible by clicking on the photo or name in the Staff Directory.<br>Note, each person will have a post generated with their name as the title, and saved in the Staff category.<br>', 'simpleschools'); ?></label>
    <input type="checkbox" name="custombio" id="custombio" value="Yes"  <?php if (get_option( 'custombio' )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> Check to allow each user to create and edit a custom HTML detail/biography page. <br />
     <input type="checkbox" name="hideemail" id="hideemail" value="Yes"  <?php if (get_option( 'hideemail' )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> Check to hide all e-mails from the Staff Directory. <br />
 <blockquote>Check roles to allow access to detailed profile page; <br /><?php    

    // Get WP Roles
    global $wp_roles;
    $roles = $wp_roles->get_names();
	$savedroles = get_option('sroles');	
    // Generate HTML code
    foreach ($roles as $key=>$value) {  
	?>
    <input type="checkbox" name="savedroles[<?php echo $key;?>]" value="Yes" <?php if($savedroles[$key]=="Yes"){ 
	echo 'checked=/"checked/"';	
	} ?> /> <?php echo $value; ?><br />
<?php  
}
?>  
</blockquote>
    </td>
		</tr><?php } ?>
		
        <tr>
			<th>
				<label for="hidemyemail"><?php _e('Hide My E-mail?', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="checkbox" name="hidemyemail" id="hidemyemail" value="Yes"  <?php if (get_the_author_meta( 'hidemyemail', $user->ID )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> Check to hide your e-mail from the Staff Directory. <br />
				<span class="description"><?php _e('Choose if you want to hide your e-mail address from the Staff Directory.', 'simpleschools'); ?></span>
			</td>
		</tr>
        
        <tr>
			<th>
				<label for="company"><?php _e('Region or District', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="company" id="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your school region or district.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="department"><?php _e('School or Department', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="department" id="department" value="<?php echo esc_attr( get_the_author_meta( 'department', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your school or department.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="title"><?php _e('Title', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your teaching specialty or title.', 'simpleschools'); ?></span>
			</td>
		</tr>
        	<tr>
			<th>
				<label for="address"><?php _e('Address', 'simpleschools'); ?>
			</label></th>
			<td><textarea name="address" rows="4" class="regular-text" id="address"><?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?></textarea>
	      <br />
				<span class="description"><?php _e('Please enter your address.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="postal"><?php _e('Zip or Postal Code', 'simpleschools'); ?>
			</label></th>
			<td><input type="text" name="postal" id="postal" value="<?php echo esc_attr( get_the_author_meta( 'postal', $user->ID ) ); ?>" class="regular-text" />
	      <br />
				<span class="description"><?php _e('Please enter your zip or postal code.', 'simpleschools'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				 <?php if(current_user_can('administrator') ) { 
				_e('Phone (customize label below):', 'simpleschools'); ?>
                <input name="phonelabel" type="text" class="regular-text" id="phonelabel" value="<?php echo get_option( 'phonelabel') ; ?>" size="20" /><?php } else { 				
				$phonelabel= get_option( 'phonelabel');	
				echo $phonelabel;		
				if ($phonelabel==''){
				echo 'Phone: ';
				}
               } 			   
			   ?>
			</th>
			<td>
				<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your direct business phone #.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
					 <?php if(current_user_can('administrator') ) { 
				_e('Phone extension (customize label below):', 'simpleschools'); ?>
                <input name="phoneextlabel" type="text" class="regular-text" id="phoneextlabel" value="<?php echo get_option( 'phoneextlabel') ; ?>" size="20" /><?php } else { 				
				$phoneextlabel= get_option( 'phoneextlabel');	
				echo $phoneextlabel;		
				if ($phoneextlabel==''){
				echo 'Extension: ';
				}
               } 			   
			   ?></th>
			<td>
				<input type="text" name="phoneext" id="phoneext" value="<?php echo esc_attr( get_the_author_meta( 'phoneext', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your direct phone extension.', 'simpleschools'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				 <?php if(current_user_can('administrator') ) { 
				_e('Mobile (customize label below):', 'simpleschools'); ?>
                <input name="mobilelabel" type="text" class="regular-text" id="mobilelabel" value="<?php echo get_option( 'mobilelabel') ; ?>" size="20" /><?php } else { 				
				$mobilelabel= get_option( 'mobilelabel');	
				echo $mobilelabel;		
				if ($mobilelabel==''){
				echo 'Mobile: ';
				}
               } 			   
			   ?></th>
			<td>
				<input type="text" name="mobilephone" id="mobilephone" value="<?php echo esc_attr( get_the_author_meta( 'mobilephone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your mobile phone number.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				 <?php if(current_user_can('administrator') ) { 
				_e('Fax (customize label below):', 'simpleschools'); ?>
                <input name="faxlabel" type="text" class="regular-text" id="faxlabel" value="<?php echo get_option( 'faxlabel') ; ?>" size="20" /><?php } else { 				
				$faxlabel= get_option( 'faxlabel');	
				echo $faxlabel;		
				if ($faxlabel==''){
				echo 'Fax: ';
				}
               } 			   
			   ?></th>
			<td>
				<input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'fax', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your fax number.', 'simpleschools'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				<label for="city"><?php _e('City', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your city.', 'simpleschools'); ?></span>
			</td>
		</tr>
         <tr>
			<th>
				<label for="region"><?php _e('Region, state or province', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="region" id="region" value="<?php echo esc_attr( get_the_author_meta( 'region', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Please enter your region.', 'simpleschools'); ?></span>
			</td>
		</tr>
        
         <tr>
			<th>
				<label for="country"><?php _e('Country', 'simpleschools'); ?>
			</label></th>
			<td>
				
                <select name="country" id="country"  class="regular-text" VALUE="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>">
 <OPTION VALUE="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>"><?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>
 <OPTION VALUE="<?php _e('Select A Country','simpleschools');?>"><?php _e('Select A Country','simpleschools');?>
  <OPTION VALUE="<?php _e('Afghanistan','simpleschools');?>">Afghanistan
  <OPTION VALUE="<?php _e('Albania','simpleschools');?>">Albania
  <OPTION VALUE="<?php _e('Algeria','simpleschools');?>">Algeria
  <OPTION VALUE="<?php _e('American Samoa','simpleschools');?>">American Samoa
  <OPTION VALUE="<?php _e('Andorra','simpleschools');?>">Andorra
  <OPTION VALUE="<?php _e('Angola','simpleschools');?>">Angola
  <OPTION VALUE="<?php _e('Anguilla','simpleschools');?>">Anguilla
  <OPTION VALUE="<?php _e('Antarctica','simpleschools');?>">Antarctica
  <OPTION VALUE="<?php _e('Antigua and Barbuda','simpleschools');?>">Antigua and Barbuda
  <OPTION VALUE="<?php _e('Argentina','simpleschools');?>">Argentina
  <OPTION VALUE="<?php _e('Armenia','simpleschools');?>">Armenia
  <OPTION VALUE="<?php _e('Aruba','simpleschools');?>">Aruba
  <OPTION VALUE="<?php _e('Australia','simpleschools');?>">Australia
  <OPTION VALUE="<?php _e('Austria','simpleschools');?>">Austria
  <OPTION VALUE="<?php _e('Azerbaijan','simpleschools');?>">Azerbaijan
  <OPTION VALUE="<?php _e('Bahamas','simpleschools');?>">Bahamas
  <OPTION VALUE="<?php _e('Bahrain','simpleschools');?>">Bahrain
  <OPTION VALUE="<?php _e('Bangladesh','simpleschools');?>">Bangladesh
  <OPTION VALUE="<?php _e('Barbados','simpleschools');?>">Barbados
  <OPTION VALUE="<?php _e('Belarus','simpleschools');?>">Belarus
  <OPTION VALUE="<?php _e('Belgium','simpleschools');?>">Belgium
  <OPTION VALUE="<?php _e('Belize','simpleschools');?>">Belize
  <OPTION VALUE="<?php _e('Benin','simpleschools');?>">Benin
  <OPTION VALUE="<?php _e('Bermuda','simpleschools');?>">Bermuda
  <OPTION VALUE="<?php _e('Bhutan','simpleschools');?>">Bhutan
  <OPTION VALUE="<?php _e('Bolivia','simpleschools');?>">Bolivia
  <OPTION VALUE="<?php _e('Bosnia and Herzegovina','simpleschools');?>">Bosnia and 
              Herzegovina
  <OPTION VALUE="<?php _e('Botswana','simpleschools');?>">Botswana
  <OPTION VALUE="<?php _e('Bouvet Island','simpleschools');?>">Bouvet Island
  <OPTION VALUE="<?php _e('Brazil','simpleschools');?>">Brazil
  <OPTION VALUE="<?php _e('British Indian Ocean Territory','simpleschools');?>">
              British Indian Ocean Territory
  <OPTION VALUE="<?php _e('Brunei Darussalam','simpleschools');?>">Brunei Darussalam
  <OPTION VALUE="<?php _e('Bulgaria','simpleschools');?>">Bulgaria
  <OPTION VALUE="<?php _e('Burkina Faso','simpleschools');?>">Burkina Faso
  <OPTION VALUE="<?php _e('Burundi','simpleschools');?>">Burundi
  <OPTION VALUE="<?php _e('Cambodia','simpleschools');?>">Cambodia
  <OPTION VALUE="<?php _e('Cameroon','simpleschools');?>">Cameroon
  <OPTION VALUE="<?php _e('Canada','simpleschools');?>">Canada
  <OPTION VALUE="<?php _e('Cape Verde','simpleschools');?>">Cape Verde
  <OPTION VALUE="<?php _e('Cayman Islands','simpleschools');?>">Cayman Islands
  <OPTION VALUE="<?php _e('Central African Republic','simpleschools');?>">
             Central African Republic
  <OPTION VALUE="<?php _e('Chad','simpleschools');?>">Chad
  <OPTION VALUE="<?php _e('Chile','simpleschools');?>">Chile
  <OPTION VALUE="<?php _e('China','simpleschools');?>">China
  <OPTION VALUE="<?php _e('Christmas Island','simpleschools');?>">Christmas Island
  <OPTION VALUE="<?php _e('Cocos (Keeling Islands)','simpleschools');?>">
             Cocos (Keeling Islands)
  <OPTION VALUE="<?php _e('Colombia','simpleschools');?>">Colombia
  <OPTION VALUE="<?php _e('Comoros','simpleschools');?>">Comoros
  <OPTION VALUE="<?php _e('Congo','simpleschools');?>">Congo
  <OPTION VALUE="<?php _e('Cook Islands','simpleschools');?>">Cook Islands
  <OPTION VALUE="<?php _e('Costa Rica','simpleschools');?>">Costa Rica
  <OPTION VALUE="<?php _e('Cote D Ivoire (Ivory Coast)','simpleschools');?>">
               Cote D Ivoire (Ivory Coast)
  <OPTION VALUE="<?php _e('Croatia (Hrvatska','simpleschools');?>">Croatia (Hrvatska
  <OPTION VALUE="<?php _e('Cuba','simpleschools');?>">Cuba
  <OPTION VALUE="<?php _e('Cyprus','simpleschools');?>">Cyprus
  <OPTION VALUE="<?php _e('Czech Republic','simpleschools');?>">Czech Republic
  <OPTION VALUE="<?php _e('Denmark','simpleschools');?>">Denmark
  <OPTION VALUE="<?php _e('Djibouti','simpleschools');?>">Djibouti
  <OPTION VALUE="<?php _e('Dominican Republic','simpleschools');?>">Dominican Republic
  <OPTION VALUE="<?php _e('Dominica','simpleschools');?>">Dominica
  <OPTION VALUE="<?php _e('East Timor','simpleschools');?>">East Timor
  <OPTION VALUE="<?php _e('Ecuador','simpleschools');?>">Ecuador
  <OPTION VALUE="<?php _e('Egypt','simpleschools');?>">Egypt
  <OPTION VALUE="<?php _e('El Salvador','simpleschools');?>">El Salvador
  <OPTION VALUE="<?php _e('Equatorial Guinea','simpleschools');?>">Equatorial Guinea
  <OPTION VALUE="<?php _e('Eritrea','simpleschools');?>">Eritrea
  <OPTION VALUE="<?php _e('Estonia','simpleschools');?>">Estonia
  <OPTION VALUE="<?php _e('Ethiopia','simpleschools');?>">Ethiopia
  <OPTION VALUE="<?php _e('Falkland Islands (Malvinas)','simpleschools');?>">
                  Falkland Islands (Malvinas)
  <OPTION VALUE="<?php _e('Faroe Islands','simpleschools');?>">Faroe Islands
  <OPTION VALUE="<?php _e('Fiji','simpleschools');?>">Fiji
  <OPTION VALUE="<?php _e('Finland','simpleschools');?>">Finland
  <OPTION VALUE="<?php _e('France, Metropolitan','simpleschools');?>">France, Metropolitan
  <OPTION VALUE="<?php _e('France','simpleschools');?>">France
  <OPTION VALUE="<?php _e('French Guiana','simpleschools');?>">French Guiana
  <OPTION VALUE="<?php _e('French Polynesia','simpleschools');?>">French Polynesia
  <OPTION VALUE="<?php _e('French Southern Territories','simpleschools');?>">
              French Southern Territories
  <OPTION VALUE="<?php _e('Gabon','simpleschools');?>">Gabon
  <OPTION VALUE="<?php _e('Gambia','simpleschools');?>">Gambia
  <OPTION VALUE="<?php _e('Georgia','simpleschools');?>">Georgia
  <OPTION VALUE="<?php _e('Germany','simpleschools');?>">Germany
  <OPTION VALUE="<?php _e('Ghana','simpleschools');?>">Ghana
  <OPTION VALUE="<?php _e('Gibraltar','simpleschools');?>">Gibraltar
  <OPTION VALUE="<?php _e('Greece','simpleschools');?>">Greece
  <OPTION VALUE="<?php _e('Greenland','simpleschools');?>">Greenland
  <OPTION VALUE="<?php _e('Grenada','simpleschools');?>">Grenada
  <OPTION VALUE="<?php _e('Guadeloupe','simpleschools');?>">Guadeloupe
  <OPTION VALUE="<?php _e('Guam','simpleschools');?>">Guam
  <OPTION VALUE="<?php _e('Guatemala','simpleschools');?>">Guatemala
  <OPTION VALUE="<?php _e('Guinea-Bissau','simpleschools');?>">Guinea-Bissau
  <OPTION VALUE="<?php _e('Guinea','simpleschools');?>">Guinea
  <OPTION VALUE="<?php _e('Guyana','simpleschools');?>">Guyana
  <OPTION VALUE="<?php _e('Haiti','simpleschools');?>">Haiti
  <OPTION VALUE="<?php _e('Heard and McDonald Islands','simpleschools');?>">
            Heard and McDonald Islands
  <OPTION VALUE="<?php _e('Honduras','simpleschools');?>">Honduras
  <OPTION VALUE="<?php _e('Hong Kong','simpleschools');?>">Hong Kong
  <OPTION VALUE="<?php _e('Hungary','simpleschools');?>">Hungary
  <OPTION VALUE="<?php _e('Iceland','simpleschools');?>">Iceland
  <OPTION VALUE="<?php _e('India','simpleschools');?>">India
  <OPTION VALUE="<?php _e('Indonesia','simpleschools');?>">Indonesia
  <OPTION VALUE="<?php _e('Iran','simpleschools');?>">Iran
  <OPTION VALUE="<?php _e('Iraq','simpleschools');?>">Iraq
  <OPTION VALUE="<?php _e('Ireland','simpleschools');?>">Ireland
  <OPTION VALUE="<?php _e('Israel','simpleschools');?>">Israel
  <OPTION VALUE="<?php _e('Italy','simpleschools');?>">Italy
  <OPTION VALUE="<?php _e('Jamaica','simpleschools');?>">Jamaica
  <OPTION VALUE="<?php _e('Japan','simpleschools');?>">Japan
  <OPTION VALUE="<?php _e('Jordan','simpleschools');?>">Jordan
  <OPTION VALUE="<?php _e('Kazakhstan','simpleschools');?>">Kazakhstan
  <OPTION VALUE="<?php _e('Kenya','simpleschools');?>">Kenya
  <OPTION VALUE="<?php _e('Kiribati','simpleschools');?>">Kiribati
  <OPTION VALUE="<?php _e('Korea (North)','simpleschools');?>">Korea (North)
  <OPTION VALUE="<?php _e('Korea (South)','simpleschools');?>">Korea (South)
  <OPTION VALUE="<?php _e('Kuwait','simpleschools');?>">Kuwait
  <OPTION VALUE="<?php _e('Kyrgyzstan','simpleschools');?>">Kyrgyzstan
  <OPTION VALUE="<?php _e('Laos','simpleschools');?>">Laos
  <OPTION VALUE="<?php _e('Latvia','simpleschools');?>">Latvia
  <OPTION VALUE="<?php _e('Lebanon','simpleschools');?>">Lebanon
  <OPTION VALUE="<?php _e('Lesotho','simpleschools');?>">Lesotho
  <OPTION VALUE="<?php _e('Liberia','simpleschools');?>">Liberia
  <OPTION VALUE="<?php _e('Libya','simpleschools');?>">Libya
  <OPTION VALUE="<?php _e('Liechtenstein','simpleschools');?>">Liechtenstein
  <OPTION VALUE="<?php _e('Lithuania','simpleschools');?>">Lithuania
  <OPTION VALUE="<?php _e('Luxembourg','simpleschools');?>">Luxembourg
  <OPTION VALUE="<?php _e('Macau','simpleschools');?>">Macau
  <OPTION VALUE="<?php _e('Macedonia','simpleschools');?>">Macedonia
  <OPTION VALUE="<?php _e('Madagascar','simpleschools');?>">Madagascar
  <OPTION VALUE="<?php _e('Malawi','simpleschools');?>">Malawi
  <OPTION VALUE="<?php _e('Malaysia','simpleschools');?>">Malaysia
  <OPTION VALUE="<?php _e('Maldives','simpleschools');?>">Maldives
  <OPTION VALUE="<?php _e('Mali','simpleschools');?>">Mali
  <OPTION VALUE="<?php _e('Malta','simpleschools');?>">Malta
  <OPTION VALUE="<?php _e('Marshall Islands','simpleschools');?>">Marshall Islands
  <OPTION VALUE="<?php _e('Martinique','simpleschools');?>">Martinique
  <OPTION VALUE="<?php _e('Mauritania','simpleschools');?>">Mauritania
  <OPTION VALUE="<?php _e('Mauritius','simpleschools');?>">Mauritius
  <OPTION VALUE="<?php _e('Mayotte','simpleschools');?>">Mayotte
  <OPTION VALUE="<?php _e('Mexico','simpleschools');?>">Mexico
  <OPTION VALUE="<?php _e('Micronesia','simpleschools');?>">Micronesia
  <OPTION VALUE="<?php _e('Moldova','simpleschools');?>">Moldova
  <OPTION VALUE="<?php _e('Monaco','simpleschools');?>">Monaco
  <OPTION VALUE="<?php _e('Mongolia','simpleschools');?>">Mongolia
  <OPTION VALUE="<?php _e('Montserrat','simpleschools');?>">Montserrat
  <OPTION VALUE="<?php _e('Morocco','simpleschools');?>">Morocco
  <OPTION VALUE="<?php _e('Mozambique','simpleschools');?>">Mozambique
  <OPTION VALUE="<?php _e('Myanmar','simpleschools');?>">Myanmar
  <OPTION VALUE="<?php _e('Namibia','simpleschools');?>">Namibia
  <OPTION VALUE="<?php _e('Nauru','simpleschools');?>">Nauru
  <OPTION VALUE="<?php _e('Nepal','simpleschools');?>">Nepal
  <OPTION VALUE="<?php _e('Netherlands Antilles','simpleschools');?>">Netherlands Antilles
  <OPTION VALUE="<?php _e('Netherlands','simpleschools');?>">Netherlands
  <OPTION VALUE="<?php _e('New Caledonia','simpleschools');?>">New Caledonia
  <OPTION VALUE="<?php _e('New Zealand','simpleschools');?>">New Zealand
  <OPTION VALUE="<?php _e('Nicaragua','simpleschools');?>">Nicaragua
  <OPTION VALUE="<?php _e('Nigeria','simpleschools');?>">Nigeria
  <OPTION VALUE="<?php _e('Niger','simpleschools');?>">Niger
  <OPTION VALUE="<?php _e('Niue','simpleschools');?>">Niue
  <OPTION VALUE="<?php _e('Norfolk Island','simpleschools');?>">Norfolk Island
  <OPTION VALUE="<?php _e('Northern Mariana Islands','simpleschools');?>">
             Northern Mariana Islands
  <OPTION VALUE="<?php _e('Norway','simpleschools');?>">Norway
  <OPTION VALUE="<?php _e('Oman','simpleschools');?>">Oman
  <OPTION VALUE="<?php _e('Pakistan','simpleschools');?>">Pakistan
  <OPTION VALUE="<?php _e('Palau','simpleschools');?>">Palau
  <OPTION VALUE="<?php _e('Panama','simpleschools');?>">Panama
  <OPTION VALUE="<?php _e('Papua New Guinea','simpleschools');?>">Papua New Guinea
  <OPTION VALUE="<?php _e('Paraguay','simpleschools');?>">Paraguay
  <OPTION VALUE="<?php _e('Peru','simpleschools');?>">Peru
  <OPTION VALUE="<?php _e('Philippines','simpleschools');?>">Philippines
  <OPTION VALUE="<?php _e('Pitcairn','simpleschools');?>">Pitcairn
  <OPTION VALUE="<?php _e('Poland','simpleschools');?>">Poland
  <OPTION VALUE="<?php _e('Portugal','simpleschools');?>">Portugal
  <OPTION VALUE="<?php _e('Puerto Rico','simpleschools');?>">Puerto Rico
  <OPTION VALUE="<?php _e('Qatar','simpleschools');?>">Qatar
  <OPTION VALUE="<?php _e('Reunion','simpleschools');?>">Reunion
  <OPTION VALUE="<?php _e('Romania','simpleschools');?>">Romania
  <OPTION VALUE="<?php _e('Russian Federation','simpleschools');?>">Russian Federation
  <OPTION VALUE="<?php _e('Rwanda','simpleschools');?>">Rwanda
  <OPTION VALUE="<?php _e('S. Georgia and S. Sandwich Isls.','simpleschools');?>">
         S. Georgia and S. Sandwich Isls.
  <OPTION VALUE="<?php _e('Saint Kitts and Nevis','simpleschools');?>">Saint Kitts and Nevis
  <OPTION VALUE="<?php _e('Saint Lucia','simpleschools');?>">Saint Lucia
  <OPTION VALUE="<?php _e('Saint Vincent and The Grenadines','simpleschools');?>">
         Saint Vincent and The Grenadines
  <OPTION VALUE="<?php _e('Samoa','simpleschools');?>">Samoa
  <OPTION VALUE="<?php _e('San Marino','simpleschools');?>">San Marino
  <OPTION VALUE="<?php _e('Sao Tome and Principe','simpleschools');?>">Sao Tome and Principe
  <OPTION VALUE="<?php _e('Saudi Arabia','simpleschools');?>">Saudi Arabia
  <OPTION VALUE="<?php _e('Senegal','simpleschools');?>">Senegal
  <OPTION VALUE="<?php _e('Seychelles','simpleschools');?>">Seychelles
  <OPTION VALUE="<?php _e('Sierra Leone','simpleschools');?>">Sierra Leone
  <OPTION VALUE="<?php _e('Singapore','simpleschools');?>">Singapore
  <OPTION VALUE="<?php _e('Slovak Republic','simpleschools');?>">Slovak Republic
  <OPTION VALUE="<?php _e('Slovenia','simpleschools');?>">Slovenia
  <OPTION VALUE="<?php _e('Solomon Islands','simpleschools');?>">Solomon Islands
  <OPTION VALUE="<?php _e('Somalia','simpleschools');?>">Somalia
  <OPTION VALUE="<?php _e('South Africa','simpleschools');?>">South Africa
  <OPTION VALUE="<?php _e('Spain','simpleschools');?>">Spain
  <OPTION VALUE="<?php _e('Sri Lanka','simpleschools');?>">Sri Lanka
  <OPTION VALUE="<?php _e('St. Helena','simpleschools');?>">St. Helena
  <OPTION VALUE="<?php _e('St. Pierre and Miquelon','simpleschools');?>">
              St. Pierre and Miquelon
  <OPTION VALUE="<?php _e('Sudan','simpleschools');?>">Sudan
  <OPTION VALUE="<?php _e('Suriname','simpleschools');?>">Suriname
  <OPTION VALUE="<?php _e('Svalbard and Jan Mayen Islands','simpleschools');?>">
              Svalbard and Jan Mayen Islands
  <OPTION VALUE="<?php _e('Swaziland','simpleschools');?>">Swaziland
  <OPTION VALUE="<?php _e('Sweden','simpleschools');?>">Sweden
  <OPTION VALUE="<?php _e('Switzerland','simpleschools');?>">Switzerland
  <OPTION VALUE="<?php _e('Syria','simpleschools');?>">Syria
  <OPTION VALUE="<?php _e('Taiwan','simpleschools');?>">Taiwan
  <OPTION VALUE="<?php _e('Tajikistan','simpleschools');?>">Tajikistan
  <OPTION VALUE="<?php _e('Tanzania','simpleschools');?>">Tanzania
  <OPTION VALUE="<?php _e('Thailand','simpleschools');?>">Thailand
  <OPTION VALUE="<?php _e('Togo','simpleschools');?>">Togo
  <OPTION VALUE="<?php _e('Tokelau','simpleschools');?>">Tokelau
  <OPTION VALUE="<?php _e('Tonga','simpleschools');?>">Tonga
  <OPTION VALUE="<?php _e('Trinidad and Tobago','simpleschools');?>">Trinidad and Tobago
  <OPTION VALUE="<?php _e('Tunisia','simpleschools');?>">Tunisia
  <OPTION VALUE="<?php _e('Turkey','simpleschools');?>">Turkey
  <OPTION VALUE="<?php _e('Turkmenistan','simpleschools');?>">Turkmenistan
  <OPTION VALUE="<?php _e('Turks and Caicos Islands','simpleschools');?>">
       Turks and Caicos Islands
  <OPTION VALUE="<?php _e('Tuvalu','simpleschools');?>">Tuvalu
  <OPTION VALUE="<?php _e('US Minor Outlying Islands','simpleschools');?>">
     US Minor Outlying Islands
  <OPTION VALUE="<?php _e('Uganda','simpleschools');?>">Uganda
  <OPTION VALUE="<?php _e('Ukraine','simpleschools');?>">Ukraine
  <OPTION VALUE="<?php _e('United Arab Emirates','simpleschools');?>">
     United Arab Emirates
  <OPTION VALUE="<?php _e('United Kingdom','simpleschools');?>">United Kingdom
  <OPTION VALUE="<?php _e('United States','simpleschools');?>">United States
  <OPTION VALUE="<?php _e('Uruguay','simpleschools');?>">Uruguay
  <OPTION VALUE="<?php _e('Uzbekistan','simpleschools');?>">Uzbekistan
  <OPTION VALUE="<?php _e('Vanuatu','simpleschools');?>">Vanuatu
  <OPTION VALUE="<?php _e('Vatican City State','simpleschools');?>">Vatican City State
  <OPTION VALUE="<?php _e('Venezuela','simpleschools');?>">Venezuela
  <OPTION VALUE="<?php _e('Viet Nam','simpleschools');?>">Viet Nam
  <OPTION VALUE="<?php _e('Virgin Islands (British)','simpleschools');?>">
     Virgin Islands (British)
  <OPTION VALUE="<?php _e('Virgin Islands (US)','simpleschools');?>">
     Virgin Islands (US)
  <OPTION VALUE="<?php _e('Wallis and Futuna Islands','simpleschools');?>">
     Wallis and Futuna Islands
  <OPTION VALUE="<?php _e('Western Sahara','simpleschools');?>">Western Sahara
  <OPTION VALUE="<?php _e('Yemen','simpleschools');?>">Yemen
  <OPTION VALUE="<?php _e('Yugoslavia','simpleschools');?>">Yugoslavia
  <OPTION VALUE="<?php _e('Zaire','simpleschools');?>">Zaire
  <OPTION VALUE="<?php _e('Zambia','simpleschools');?>">Zambia
  <OPTION VALUE="<?php _e('Zimbabwe','simpleschools');?>">Zimbabwe
</SELECT>
                <br />
				<span class="description"><?php _e('Please enter your country.', 'simpleschools'); ?></span>
			</td>
		</tr>
        
        <tr>
			<th>				
                <?php if(current_user_can('administrator') ) { 
				_e('Custom Field #1 Label: ', 'simpleschools'); ?>
                <input name="custom1label" type="text" class="regular-text" id="custom1label" value="<?php echo get_option( 'custom1label'); ?>" size="20" /><?php } else { 				
				$custom1label= get_option( 'custom1label');	
				echo $custom1label;		
				if ($custom1label==''){
				echo 'Custom Field #1: ';
				}
               } 			   
			   ?>
		  </th>
			<td>
				<input type="text" name="custom1" id="custom1" value="<?php echo get_the_author_meta( 'custom1', $user->ID ) ; ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter a custom field that will show up in the Staff Directory if populated. HTML code is OK, but use carefully.', 'simpleschools'); ?></span>
			</td>
		</tr>
          <tr>
			<th>
				 <?php if(current_user_can('administrator') ) { 
				_e('Custom Field #2 Label: ', 'simpleschools'); ?>
                <input name="custom2label" type="text" class="regular-text" id="custom2label" value="<?php echo get_option( 'custom2label') ; ?>" size="20" /><?php } else { 				
				$custom2label= get_option( 'custom2label');	
				echo $custom2label;		
				if ($custom2label==''){
				echo 'Custom Field #2: ';
				}
               } 			   
			   ?>
			</th>
			<td>
				<input type="text" name="custom2" id="custom2" value="<?php echo get_the_author_meta( 'custom2', $user->ID ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter a custom field that will show up in the Staff Directory if populated. HTML code is OK, but use carefully.', 'simpleschools'); ?></span>
			</td>
		</tr>
          <tr>
			<th>
				 <?php if(current_user_can('administrator') ) { 
				_e('Custom Field #3 Label: ', 'simpleschools'); ?>
                <input name="custom3label" type="text" class="regular-text" id="custom3label" value="<?php echo get_option( 'custom3label'); ?>" size="20" /><?php } else { 				
				$custom3label= get_option( 'custom3label');	
				echo $custom3label;		
				if ($custom3label==''){
				echo 'Custom Field #3: ';
				}
               } 			   
			   ?>
			</th>
			<td>
				<input type="text" name="custom3" id="custom3" value="<?php echo get_the_author_meta( 'custom3', $user->ID ) ; ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter a custom field that will show up in the Staff Directory if populated. HTML code is OK, but use carefully.', 'simpleschools'); ?></span>
			</td>
		</tr>
          
         <tr>
			<th>
				<label for="si_office_status"><?php _e('Away from school? ', 'simpleschools'); ?></label> </th><td>            
	<?php 				
	global $in_out, $officeexpire,  $current_user;	
	if (!current_user_can( 'administrator' )) {
    $user_id = $current_user->ID;
	}
	if (current_user_can( 'administrator' ) && $_GET['user_id']!='' ) {
    $user_id = $_GET['user_id'];
	}
	if (current_user_can( 'administrator' ) && $_GET['user_id']=='' ) {
    $user_id = $current_user->ID;
	}
//	$gofs = get_option( 'gmt_offset' ); // get WordPress offset in hours
//	$tz = date_default_timezone_get(); // get current PHP timezone
//	date_default_timezone_set('Etc/GMT'.(($gofs < 0)?'+':'').-$gofs); // set the PHP timezone to match WordPress
	
	$right_now=current_time( 'timestamp' );
	
	$in_out= esc_attr( get_the_author_meta( 'si_office_status', $user_id, true) ); 
	$ignore2= esc_attr( get_the_author_meta( 'si_office_ignore', $user_id, true) ); 
	if($_GET['si_ignore']){
	$dismiss=$_GET['si_ignore'];
	update_user_meta($user_id, 'si_office_status', $dismiss);   
	}
	$officeexpire= get_the_author_meta( 'officeexpire', $user_id ) ;
	if($officeexpire!=''){
	$expire_string = implode("-", $officeexpire);
	}
	$officeexpire_unix1=strtotime($expire_string);
	$officeexpire_unix=$officeexpire_unix1+$gmt;	
		
	update_user_meta($user_id, 'officeexpire_unix',$officeexpire_unix ); 
	$set_expiry= esc_attr( get_the_author_meta( 'expiry', $user_id ) ); 	
				
	if($set_expiry=="Yes"){
	if($officeexpire_unix<=$right_now ){
	$in_out='false';
	update_user_meta($user_id, 'si_office_status','false'); 
	}
	if($officeexpire_unix>=$right_now ){
	$in_out='true';
	update_user_meta($user_id, 'si_office_status','true'); 
	}
	}
	
	?> 
                 <select name="si_office_status" id="si_office_status">
                    <option value="false" <?php if ($in_out == "" || $in_out=="false" ) { 
					echo "selected=\"selected\""; 
					}?>>No</option>
                    <option value="true" <?php if ($in_out=="true" ) { echo "selected=\"selected\"";
					}?>>Yes</option>   
                     </select>             
                <br />
                Hide Dashboard away from school reminder notice? <select name="si_office_ignore" id="si_office_ignore">
                    <option value="false" <?php if ($ignore2=="false" || $ignore2=="") { 
					echo "selected=\"selected\""; 
					}?>>No</option>
                    <option value="true" <?php if ($ignore2=="true" ) { echo "selected=\"selected\"";
					}?>>Yes</option>   
                     </select>   <br />
				<span class="description"><?php _e('Update away from school status.', 'simpleschools'); ?> </span>
			</td>
		</tr>
          <tr>
			<th>
				<label for="expiry"><?php _e('Away from school expiry?', 'simpleschools'); ?>
			</label></th>
            
			<td><input type="checkbox" name="expiry" id="expiry" value="Yes"  <?php if (get_the_author_meta( 'expiry', $user_id )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> <label for="expiry" ><?php _e('Check to set an expiry date for the away from school alert: ', 'simpleschools'); ?></label><?php
echo '<input type="date" id="datepicker" name="officeexpire[datepicker]" value="'.$expire_string.'" class="example-datepicker" />';

/**
 * Enqueue the date picker
 */
function enqueue_date_picker2(){
                wp_enqueue_script(
			'field-date-js',
			'js/Field_Date.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
			time(),
			true
		);	
		wp_enqueue_style( 'jquery-ui-datepicker' );
}
		  ?><br />
				<span class="description"><?php _e('Enter the day you are back in when the alert will be turned off.', 'simpleschools'); ?></span>
                <br /><input type="text" name="expirytext" id="expirytext" value="<?php echo esc_attr( get_the_author_meta( 'expirytext', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter custom back in text above, assuming activated.', 'simpleschools'); ?></span>
			</td>
		</tr>
        
         <tr>
			<th>
				<label for="officenotification"><?php _e('Away from school text', 'simpleschools'); ?>
			</label></th>
			<td>
				<input type="text" name="officenotification" id="officenotification" value="<?php echo esc_attr( get_the_author_meta( 'officenotification', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter custom away from school notification text here, assuming activated.', 'simpleschools'); ?></span>
			</td>
		</tr>
        <tr>
			<th>
				<label for="exclude"><?php _e('Exclude from Staff Directory?', 'simpleschools'); ?>
			</label></th>
			<td align="left">
				<input type="checkbox" name="exclude" id="exclude" value="Yes"  <?php if (get_the_author_meta( 'exclude', $user->ID )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> <label for="exclude" ><?php _e('Check if you want to exclude from the Staff Directory and Staff Widget.', 'simpleschools'); ?></label></td>
		</tr>
        <tr>
			<th>
				<label for="includebio"><?php _e('Include Biography in Directory?', 'simpleschools'); ?>
			</label></th>
			<td align="left">
				<input type="checkbox" name="includebio" id="includebio" value="Yes"  <?php if (get_the_author_meta( 'includebio', $user->ID )=="Yes"){
		echo "checked=\"checked\"";
	} ?>> <label for="includebio" ><?php _e('Check if you want to include a biography in the Staff Directory.', 'simpleschools'); ?></label></td>
		</tr>
       <?php if(current_user_can('administrator') ) { ?> 
                
       <tr>
			<th>
				<label for="phoneaustralia"><?php _e('Australian Phone Format?', 'simpleschools'); ?>
			</label></th>
			<td align="left">
				<input type="checkbox" name="phoneaustralia" id="phoneaustralia" value="Yes"  <?php if (get_option( 'phoneaustralia')=="Yes"){
		echo "checked=\"checked\"";
	} ?>> <label for="phoneaustralia" ><?php _e('Use Australian phone format for Staff Directory.', 'simpleschools'); ?></label></td>
		</tr>
       
     
       <?php } ?>
        
        
	</table>
<?php }
function fb_save_custom_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	update_user_meta( $user_id, 'company', $_POST['company'] );
	update_user_meta( $user_id, 'department', $_POST['department'] );
	update_user_meta( $user_id, 'title', $_POST['title'] );
	update_user_meta( $user_id, 'address', $_POST['address'] );
	update_user_meta( $user_id, 'postal', $_POST['postal'] );
	update_user_meta( $user_id, 'phone', $_POST['phone'] );
	update_user_meta( $user_id, 'phoneext', $_POST['phoneext'] );
	update_user_meta( $user_id, 'mobilephone', $_POST['mobilephone'] );
	update_user_meta( $user_id, 'fax', $_POST['fax'] );
	update_user_meta( $user_id, 'city', $_POST['city'] );
	update_user_meta( $user_id, 'region', $_POST['region'] );
	update_user_meta( $user_id, 'country', $_POST['country'] );
	update_user_meta( $user_id, 'hidemyemail', $_POST['hidemyemail'] );
	if(current_user_can('administrator') ) { 
	update_option('phonelabel', $_POST['phonelabel'] );	
	update_option('phoneextlabel', $_POST['phoneextlabel'] );
	update_option('mobilelabel', $_POST['mobilelabel'] );
	update_option('faxlabel', $_POST['faxlabel'] );
	update_option('custom1label', $_POST['custom1label'] );
	update_option('custom2label', $_POST['custom2label'] );
	update_option('custom3label', $_POST['custom3label'] );
	update_option('profiledetail', $_POST['profiledetail'] );
	update_option('hideemail', $_POST['hideemail'] );
	update_option('custombio', $_POST['custombio'] );
	update_option('phoneaustralia', $_POST['phoneaustralia'] );
	update_option('sroles', $_POST['savedroles']);
	}
	update_user_meta( $user_id, 'custom1', $_POST['custom1'] );	
	update_user_meta( $user_id, 'custom2', $_POST['custom2'] );	
	update_user_meta( $user_id, 'custom3', $_POST['custom3'] );
	
	update_user_meta( $user_id, 'si_office_status', $_POST['si_office_status'] );
	update_user_meta( $user_id, 'si_office_ignore', $_POST['si_office_ignore'] );
	update_user_meta( $user_id, 'expiry', $_POST['expiry'] );
	update_user_meta( $user_id, 'expirytext', $_POST['expirytext'] );
	update_user_meta( $user_id, 'officeexpire', $_POST['officeexpire'] );
	update_user_meta( $user_id, 'officenotification', $_POST['officenotification'] );
	update_user_meta( $user_id, 'exclude', $_POST['exclude'] );
	update_user_meta( $user_id, 'includebio', $_POST['includebio'] );
	update_user_meta( $user_id, 'employeeofmonth', $_POST['employeeofmonth'] );	
	update_user_meta( $user_id, 'employeeofmonthtext', $_POST['employeeofmonthtext'] );	
	update_user_meta( $user_id, 'parent', $_POST['parent'] );
}
add_action( 'show_user_profile', 'fb_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'fb_add_custom_user_profile_fields' );
add_action( 'personal_options_update', 'fb_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'fb_save_custom_user_profile_fields' );
//EXTRA PROFILE FIELDS END

add_action('admin_menu', 'add_the_schools_menu');

function add_the_schools_menu() {
add_menu_page('Simple Schools','Simple Schools', 'publish_pages', 'simple_schools', 'si_render', '', 4); 
}
 
function si_render() {
	//if (!current_user_can('manage_options'))  {
	//	wp_die( __('You do not have sufficient permissions to access this page.') );
	//}
	$homeurl=get_option('home'); 
	$imgurl=get_option('add_logo_filename');
	if ($imgurl!='' && get_option('add_logo_on_admin') == "yes"){	
	echo '<p><img src="'.$homeurl.'/wp-content/uploads/logos/'.$imgurl.'"/></p>';	
	}
	global $title;

echo '<h1><a href="../index.php" target="_blank">'.$title.'</a></h1><br>';
_e( 'Problems? <strong><a href="http://www.simpleintranet.org/support">Visit our Support Area</a>.</strong><br><br>');
	_e('<h3><strong>Setup A Staff Directory</strong></h3>');
	_e('a) To add a Staff Directory with photos, insert the <strong>[staff]</strong> shortcode into any page or post.<br>');	
	_e('b) <a href="user-new.php">Add new staff </a> and edit their profiles and upload photo avatars.<br>');
	_e('c) Enable options (admins only) under the <em>Enable Detailed Staff Directory Page?</em> heading in <a href="profile.php">Your Profile</a>.<br>');
	_e('d) An archive of all staff biographies can be found at <a href="'.$homeurl.'/bios">'.$homeurl.'/bios</a>.<br>');

	_e('NOTE: It is a good practise to <a href="options-permalink.php">change your Permalinks</a> from "Default" to "Post name".<br><br>');
	
	_e('<h4><em>Shortcodes</em></h4>');
		_e('- To add a searchable staff directory to a page or post, insert the <strong>[staff]</strong> shortcode. Optionally limit to 10 people per page (25 is default) using the limit parameter: <strong>[staff limit="10"]</strong>.<br>');
		
	_e('<h4><em>Widgets</em></h4>');

	_e('- Display a list of staff using the <strong>Staff</strong> widget.<br>');
		_e('- Display Away From School notifications in the staff directory using the <strong>Away From School</strong> widget.<br>');
				
}

function si_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL.'/custom_header.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
}
 
function si_admin_styles() {
wp_enqueue_style('thickbox');
}
 
if (isset($_GET['page']) && $_GET['page'] == 'simple_schools') {
add_action('admin_print_scripts', 'si_admin_scripts');
add_action('admin_print_styles', 'si_admin_styles');
}

//LOGO Initialization
add_action('admin_menu', 'si_add_logo_init');

$add_logo_upload_dir = wp_upload_dir();
$add_logo_directory = $add_logo_upload_dir['basedir']. '/logos';

//add page to admin 
function si_add_logo_init() {
	global $add_logo_directory, $add_logo_upload_dir;
	if(!empty($_GET['delete-logo'])) {
		unlink($add_logo_directory ."/". $_GET['delete-logo']);
		if($_GET['delete-logo'] == get_option('add_logo_filename')) {
			update_option('add_logo_filename', ""); 
			update_option('add_logo_logo', ""); 
		}
		
		$location = str_replace("&delete-logo=". $_GET['delete-logo'], "", $_SERVER['REQUEST_URI']."&deleted=true");
		header("Location: $location");
		die();		
	}

	if(!empty($_POST['add_logo_submit'])) {
		if (!wp_verify_nonce($_POST['add_logo_to_admin_nonce'], 'add_logo_to_admin_nonce'))
			exit();
		
		if ($_FILES["file"]["type"]){
			$image = str_replace(" ", "-", $_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"],
			$add_logo_directory .'/'. $image);
			update_option('add_logo_logo', $add_logo_upload_dir['baseurl'] . "/logos/" . $image);
			update_option('add_logo_filename', $image); 
		}
		
		if($_POST['add_logo_on_login']) update_option('add_logo_on_login',$_POST['add_logo_on_login']);
		if($_POST['add_logo_on_admin']) update_option('add_logo_on_admin',$_POST['add_logo_on_admin']);	
	
		if($_POST['add_logo_filename']) {
			update_option('add_logo_filename',$_POST['add_logo_filename']);
			update_option('add_logo_logo',  $add_logo_upload_dir['baseurl'] . "/logos/" . $_POST['add_logo_filename']);
		}	
		
		if($_POST['saved']==true) {
			$location = $_SERVER['REQUEST_URI'];
		} else {
			$location = str_replace("&deleted=true", "", $_SERVER['REQUEST_URI']."&saved=true");		
		}
		header("Location: $location");
		die();
		
	}	
	$add_logo_page = add_options_page( __('Add Logo'), __('Add Logo'), "manage_options", __FILE__, 'add_logo_options');

	//add logo to admin if "yes" is selected
	if(get_option('add_logo_on_admin') == "yes") {
		 $screen = get_current_screen();
		//if($_GET['post_type']!='tribe_events'){
		add_action( "admin_head", 'add_logo_css' );
		add_action( "admin_footer", 'add_logo_script' );
		//}
	}
}

//add logo to admin if "yes" selected
function add_logo_css() {
	$img = get_option('add_logo_logo');	
	if(!empty($img))
		echo '<style type="text/css">
#admin-logo-si { margin: 10px 0; padding: 0 0 5px; border-bottom: 1px solid #ddd; width: 100%; }
</style>'."\n";
}

function add_logo_script() {
	$img = get_option('add_logo_logo');
	if(!empty($img) )
		echo '<script type="text/javascript">
/* <![CDATA[ */
(function($) {
	$(".wrap").prepend("<div id=\"admin-logo-si\"><img src=\"'.($img).'\" alt=\"\" /></div>");
})(jQuery);
/* ]]> */
</script>';
}
	
//add logo to login if "yes" is selected
if(get_option('add_logo_on_login') == "yes") {
	add_action('login_head', 'login_logo_css');	
	function login_logo_css() {
		echo '<style type="text/css">.login h1 a { background-image: url('.get_option('add_logo_logo').');  background-size: 100% Auto; background-position: center top; display: block;}</style>'."\n";	
	}
}

function add_logo_settings_link( $links ) { 
	$settings_link = '<a href="options-general.php?page=simple-intranet/si_main.php">Settings</a>'; 
	array_unshift( $links, $settings_link ); 
	return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'add_logo_settings_link' );

//set default options
function set_add_logo_options() {	
	add_option('add_logo_on_login','no');
	add_option('add_logo_on_admin','no');	
	//add_option('add_logo_logo',get_option("siteurl").'/wp-content/plugins/simple-intranet/images/logo.png');	
	add_option('add_logo_filename', '');	// REVSIED logo.png
}

//delete options upon plugin deactivation
function unset_add_logo_options() {
	delete_option('add_logo_on_login');
	delete_option('add_logo_on_admin');
	delete_option('add_logo_logo');
	delete_option('add_logo_filename');
}

register_activation_hook(__FILE__,'set_add_logo_options');
register_deactivation_hook(__FILE__,'unset_add_logo_options');

//creating the admin page
function add_logo_options() { 
	global $add_logo_directory, $add_logo_upload_dir;
	if(!file_exists($add_logo_directory)) mkdir($add_logo_directory, 0755);
	
	$default_login = get_option('add_logo_on_login');
	$default_admin = get_option('add_logo_on_admin');
	$the_logo = get_option('add_logo_logo');
	?>
    <div class="wrap">
        <h2>Add Logo</h2>
        <?php
        if ( $_REQUEST['saved'] ) { _e( '<div id="message" class="updated fade"><p><strong>Logo settings saved.</strong></p></div>'); }
        if ( $_REQUEST['deleted'] ) { _e( '<div id="message" class="updated fade"><p><strong>Logo deleted.</strong></p></div>'); }
        ?>
        <!-- Add Logo to Admin box begin-->
        <form method="post" id="myForm" enctype="multipart/form-data">
        <table class="form-table">
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_on_login"><?php _e('Would you like your logo to appear on the home-page and login page?');?></label>
        </th>
        <td>
            <input type="radio" name="add_logo_on_login" value="yes" <?php checked($default_login, "yes"); ?> /><?php _e('&nbsp;Yes');?>
            <input type="radio" name="add_logo_on_login" value="no" <?php checked($default_login, "no"); ?> /><?php _e('&nbsp;No');?>
        </td>
         </tr>   
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_on_admin"><?php _e('Would you like your logo to appear on the admin pages?'); ?></label>
        </th>
        <td>
            <input type="radio" name="add_logo_on_admin" value="yes" <?php checked($default_admin, "yes"); ?> /><?php _e('&nbsp;Yes');?>
            <input type="radio" name="add_logo_on_admin" value="no" <?php checked($default_admin, "no"); ?> /><?php _e('&nbsp;No');?>
        </td>
        </tr>
        <tr valign="top">
        <th scope="row" style="width: 370px;">
            <label for="add_logo_logo"><?php _e('Choose a file to upload: ');?></label>
        </th>
        <td>
            <input type="file" name="file" id="file" /><?php _e('<em><small>Click Save Changes below to upload your logo.</small></em><br />
            (max. logo size 326px by 67px)'); ?>
            <?php
                $directory = $add_logo_upload_dir['baseurl'] . "/logos/";
                //update_option('add_logo_logo', $directory.get_option('add_logo_filename'));
                // Open the folder 
                $dir_handle = @opendir($add_logo_directory) or die("Unable to open $add_logo_directory"); 
                // Loop through the files 
                $count = 1;
                while ($file = readdir($dir_handle)) { 
                
                    if($file == "." || $file == ".." || $file == "index.php" ) {
                        continue; 
                        }
                    if($count==1) { _e('<br /><br />Select which logo you would like to use.<br />');
									   $count++; 
									   }
                    if($file == get_option('add_logo_filename')) { $checked = "checked"; } else { $checked = ""; }
                    _e("<br /><table><tr><td style=\"padding-right: 5px;\"><img src=\"$directory$file\" style=\"max-height:100px;border:1px solid #aaa;padding:10px;\" /></td><td><input id=\"add_logo_filename\" name=\"add_logo_filename\" type=\"radio\" value=\"$file\" $checked />&nbsp;Select<br /><br /><a href=\"options-general.php?page=simple-intranet/si_main.php&delete-logo=$file\">&laquo; Delete</a></td></tr></table>"); 
                } 
                
                // Close 
                closedir($dir_handle); 
             ?>    </td>
        </tr>
        </table>   
        <p class="submit">
        <input type="submit" name="add_logo_submit" class="button-primary" value="<?php _e('Save Changes');?>" />
        </p>
 	    <?php if(function_exists('wp_nonce_field')) wp_nonce_field('add_logo_to_admin_nonce', 'add_logo_to_admin_nonce'); ?>
       </form>
        <!-- Add Logo to Admin admin box end-->
    </div>
	<?php }  
 function count_roles() {
	if ( !empty( $wp_roles->role_names ) )
		return count( $wp_roles->role_names );
	return false;
}
 function si_contributors($params=array()) {	
// Get the global $wp_roles variable. //
global $wp_roles;
$role_count=count_roles();

extract(shortcode_atts(array(
		'limit' => 25
	), $params));	

// employee search form  // 
echo '<form method="get" id="employeesearchform" action="'.get_permalink($id).'" >
	<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input type="text" name="si_search" id="si_search" />
	<select name="type" id="type">';
$t=ucfirst(	$_GET['type']);
if ($t!='') { ?><option value="<?php echo $t;?>" selected="selected"><?php echo $t;?></option><?php } 
$name1= __('First Name','simpleintranet');
$name2= __('Last Name','simpleintranet');
$title1= __('Title','simpleschools');
$dept1= __('Department','simpleschools');
echo ' <option value="First Name">'.$name1.'</option>
<option value="Last Name">'.$name2.'</option>
	  <option value="Title">'.$title1.'</option>
	  <option value="Department">'.$dept1.'</option>';
foreach ($wp_roles->role_names as $roledex => $rolename) {
        $role = $wp_roles->get_role($roledex);	
if ($roledex!="administrator" && $roledex!="editor" && $roledex!="subscriber" && $roledex!="author" && $roledex!="contributor"){		
echo '<option value="'.$roledex.'">'.$rolename.'</option>';
}
}
echo '</select><input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" /></div></form><br>';

//employee directory or search resulrts
global $wpdb,$type,$page;
$name = ( isset($_GET["si_search"]) ) ? sanitize_text_field($_GET["si_search"]) : false ;
if(isset($_GET['type'])){
$type=$_GET['type'];
}

// Get Query Var for pagination. This already exists in WordPress
$number = $limit;
$page = (get_query_var('page')) ? get_query_var('page') : 1;
  
// Calculate the offset (i.e. how many users we should skip)
$offset = ($page - 1) * $number;

// prepare arguments
// prepare arguments

if ($type==""){
$args  = array(
'number' => $number,
'offset' => $offset,
);
$authors = get_users($args);
}

elseif ($type=="First Name"){
$args  = array(
'number' => $number,
'offset' => $offset,
'meta_query' => array(
					  'relation' => 'OR',
					  
array(      
		'key' => 'first_name',
        'value' => $name,	
		'compare' => 'IN',
        ),	 
));
$authors = get_users($args);
}

elseif ($type=="Last Name"){
$args  = array(
'number' => $number,
'offset' => $offset,
'meta_query' => array(
					  'relation' => 'OR',
					  
array(      
		'key' => 'last_name',
        'value' => $name,	
		'compare' => 'IN',
        ),	 
));
$authors = get_users($args);
}

elseif ($type=="Title"){
$args  = array(
'number' => $number,
'offset' => $offset,
'meta_query' => array(
					  'relation' => 'OR',				  

array(      
		'key' => 'title',
        'value' => $name,
		'compare' => 'IN',
        ),
));
$authors = get_users($args);

function si_cmp($a, $b){ 
    return strcasecmp($a->title, $b->title);
}
usort($authors, "si_cmp");

}

elseif ($type=="Department"){
$args  = array(
'number' => $number,
'offset' => $offset,
'meta_query' => array(
					  'relation' => 'OR',				  

array(      
		'key' => 'department',
        'value' => $name,
		'compare' => 'IN',
        ),
));
$authors = get_users($args);

function si_cmp($a, $b){ 
    return strcasecmp($a->department, $b->department);
}
usort($authors, "si_cmp");
}

else {
$args  = array(
'role' => $type,
'number' => $number,
'offset' => $offset,
// check for two meta_values
'meta_query' => array(
					  'relation' => 'OR',	  
array(      
		'key' => $type,
        'value' => $name,
		'compare' => 'IN',
        ),
));
$authors = get_users($args);
}

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);
// pagination
$total_authors = $wp_user_query->total_users;
$total_pages = intval($total_authors / $number) + 1;
// Get the results

// Create Staffs category
$addprofile = get_option( 'profiledetail' ); // check for clickable profile post option
$hideemail = get_option( 'hideemail' );
$custombio = get_option( 'custombio' );

// Format phone and fax #s
function formatPhone($num)
{
$num = preg_replace('/[^0-9]/', '', $num);
$len = strlen($num);
if (get_option( 'phoneaustralia')=="Yes" && $len == 10)
$num = preg_replace('/([0-9]{2})([0-9]{4})([0-9]{4})/', '$1 $2 $3', $num);
elseif($len == 7)
$num = preg_replace('/([0-9]{3})([0-9]{4})/', '$1-$2', $num);
elseif($len == 10)
$num = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2-$3', $num);

return $num;
}

// Check for results
if (empty($authors))
{
echo 'No results for the '.$type.' "'.$name.'".<br><br>';
} 

foreach ($authors as $author ) {
	
$c=0;	
$hidemyemail = get_the_author_meta('hidemyemail',$author->ID);
$website=get_the_author_meta('user_url',$author->ID);
if($website!=''){
$website='Website: <a href="'.$website.'">'.$website.'</a><br>';
}
$twitter=get_the_author_meta('twitter',$author->ID);
if($twitter!=''){
$tw= plugins_url('/images/si_twitter.gif', __FILE__);
$twitter='<a href="'.$twitter.'"><img src="'.$tw.'"></a>  ';
}
$facebook=get_the_author_meta('facebook',$author->ID);
if($facebook!=''){
$fb= plugins_url('/images/si_facebook.gif', __FILE__);
$facebook='<a href="'.$facebook.'"><img src="'.$fb.'"></a>  ';
}
$linkedin=get_the_author_meta('linkedin',$author->ID);
if($linkedin!=''){
$li= plugins_url('/images/si_linkedin.gif', __FILE__);
$linkedin='<a href="'.$linkedin.'"><img src="'.$li.'"></a>  ';
}
$googleplus=get_the_author_meta('googleplus',$author->ID);
if($googleplus!=''){
$go= plugins_url('/images/si_google.gif', __FILE__);
$googleplus='<a href="'.$googleplus.'"><img src="'.$go.'"></a>  ';
}
$exclude=get_the_author_meta('exclude', $author->ID);
$bio=get_the_author_meta('includebio', $author->ID);
$biography=get_the_author_meta('description', $author->ID);
$inoffice=get_the_author_meta('si_office_status', $author->ID);
$officetext=get_the_author_meta('officenotification', $author->ID);
if($inoffice=='true') {
$officetext='<div class="outofoffice">'.$officetext.'</div>';
}
else {
$officetext='';
}
$first = get_the_author_meta('first_name', $author->ID);
$last = get_the_author_meta('last_name', $author->ID);
$title = get_the_author_meta('title', $author->ID);

$company = get_the_author_meta('company', $author->ID);
if($company!=''){
$company=$company.'<br>';
}
$address = get_the_author_meta('address', $author->ID);
if($address!=''){
$address=$address.'<br>';
}
$postal = get_the_author_meta('postal', $author->ID);
if($postal!=''){
$postal=$postal.'<br>';
}
$city = get_the_author_meta('city', $author->ID);
if($city!=''){
$city=$city.'<br>';
}
$state = get_the_author_meta('region', $author->ID);
if($state!=''){
$state=$state.'<br>';
}
$country = get_the_author_meta('country', $author->ID);
if($country!=''){
$country=$country.'<br>';
}
if($title!=''){
$title=$title.', ';
}
$dept = get_the_author_meta('department', $author->ID);
if ($dept!=''){
$dept=$dept.'<br>';	
}
$phone = get_the_author_meta('phone', $author->ID);
$phonelabel = get_option('phonelabel');
$phoneextlabel = get_option('phoneextlabel');
$mobilelabel = get_option('mobilelabel');
$faxlabel = get_option('faxlabel');
$phone2 =  formatPhone($phone);
if($phone!=''){
$phone2=$phonelabel.'<a href="tel:'.$phone2.'">'.$phone2.'</a> ';
}
$mobilephone = get_the_author_meta('mobilephone', $author->ID);
$mobile2= formatPhone($mobilephone);
if($mobilephone!=''){
$mobile2=$mobilelabel.'<a href="tel:'.$mobile2.'">'.$mobile2.'</a>';
}
$fax = get_the_author_meta('fax', $author->ID);
$fax2= formatPhone($fax);
if($fax!=''){
$fax2=' | '.$faxlabel.'<a href="tel:'.$fax2.'">'.$fax2.'</a><br>';
}
$ext = get_the_author_meta('phoneext', $author->ID);
if($ext!=''){
$ext=' '.$phoneextlabel.$ext.'<br>';
}

$email = get_the_author_meta('email', $author->ID);
if($email!='' && ($hideemail!='Yes' || $hidemyemail!='Yes') ) {
$email= '<a href="mailto:'.$email.'">'.$email.'</a><br>';
}
if($hideemail=='Yes' || $hidemyemail=='Yes'){
$email='';
}
$custom1label = get_option('custom1label');
$custom1 = get_the_author_meta('custom1', $author->ID);
if($custom1!=''){
$cu1='<br>';
}
else {
$cu1='';
$custom1label='';
}
$custom2label = get_option('custom2label');
$custom2 = get_the_author_meta('custom2', $author->ID);
if($custom2!=''){
$cu2='<br>';
}
else {
$cu2='';
$custom2label='';
}
$custom3label = get_option('custom3label');
$custom3 = get_the_author_meta('custom3', $author->ID);
if($custom3!=''){
$cu3='<br>';
}
else {
$cu3='';
$custom3label='';
}
if($exclude!='Yes') {
if($bio!='Yes') {
$biography='';
}

// Create page for employee 
$fullname=$first.' '.$last;
$fullname=esc_html($fullname);
global $current_user;
$user_roles = $current_user->roles;
$user_role = array_shift($user_roles);
$allowed = get_option('sroles');	

if($allowed!=''){
$letin="";	
foreach ($allowed as $key=>$value){
if($key==$user_role){
$letin=$letin+1;
}
}
}

if ($addprofile=="Yes" && $letin>0){

$post = array(
  'post_title'    => $fullname, 
  'post_name'	  => $fullname,  
   'post_content'  => '<div id="wrap"><div class="employeephotoprofile">'.get_avatar($author->ID,150).'</div><div class="employeebioprofile"><div class="outofoffice">'.$officetext.'</div>'.$title.$dept.$company.$address.$postal.$city.$state.$country.$email.$phone2.$ext.$mobile2.$fax2.$city.$state.$country.'</div><br>'.$custom1label.$custom1.$cu1.$custom2label.$custom2.$cu2.$custom3label.$custom3.$cu3.$website.'<div class="socialicons">'.$twitter.$facebook.$linkedin.$googleplus.'</div><br><div class="employeebiographyprofile">'.$biography.'</div></div>',
   'post_author' => $author->ID,
  'post_type' => 'si_profile',
  'post_status'   => 'publish'
 
);
$page_exists = get_page_by_title( $post['post_name'],$output = OBJECT, $post_type = 'si_profile' );

$c=$c+1;
if ($page_exists==NULL && $c==1 ){

wp_insert_post( $post, $wp_error ); 

}
else {
$post_id=$page_exists->ID;
$updated_post = array(
'ID' => $post_id,
 'post_content'  => '<div class="wrap"><div class="employeephotoprofile">'.get_avatar($author->ID,150).'</div><div class="outofoffice">'.$officetext.'</div>
<div class="employeebioprofile"><span class="sid_title">'.$title.'</span><span class="sid_dept">'.$dept.'</span><span class="sid_company">'.$company.'</span><span class="sid_address">'.$address.'</span><span class="sid_postal">'.$postal.'</span><span class="sid_city">'.$city.'</span><span class="sid_state">'.$state.'</span><span class="sid_country">'.$country.'</span><span class="sid_email">'.$email.'</span><span class="sid_phone">'.$phone2.'</span><span class="sid_phone_extension">'.$ext.'</span><span class="sid_mobile_phone">'.$mobile2.'</span><span class="sid_fax">'.$fax2.'</span><br>
<span class="sid_custom1_label">'.$custom1label.'</span><span class="sid_custom1">'.$custom1.$cu1.'</span><span class="sid_custom2_label">'.$custom2label.'</span><span class="sid_custom2">'.$custom2.$cu2.'</span><span class="sid_custom3_label">'.$custom3label.'</span><span class="sid_custom3">'.$custom3.$cu3.'</span><span class="sid_website">'.$website.'</span></div><div class="socialicons">'.$twitter.$facebook.$linkedin.$googleplus.'</div><br><div class="employeebiographyprofile">'.$biography.'</div></div>',
'post_author' => $author->ID,
 'post_type' => 'si_profile',
 'post_status'   => 'publish' 
);

if ($custombio!="Yes" ){	
if ($updated_post['ID']!=''){
wp_update_post( $updated_post);
}
}
}
} // end of extended profile check
echo '<div id="wrap"><div class="employeephoto">';
if ($addprofile=="Yes"){ ?><a href="<?php echo get_permalink($post_id);?>"><?php } ;
echo get_avatar( $author->ID);
if ($addprofile=="Yes"){ ?></a><?php } 
echo '</div><div class="employeebio">';
if($inoffice=='true') {
echo '<div class="outofoffice">'.$officetext.'</div>';
}
?><?php if ($addprofile=="Yes"){ ?>
<div class="sid_fullname"><a href="<?php echo get_permalink($post_id);?>"><?php echo $first.' '.$last; ?></a></div>
<?php  } 
else {
echo '<span class="sid_fullname">'.$first.' '.$last.'</span> ';
}

echo '<span class="sid_title">'.$title.'</span><span class="sid_dept">'.$dept.'</span><span class="sid_company">'.$company.'</span><span class="sid_email">'.$email.'</span><span class="sid_phone">'.$phone2.'</span><span class="sid_phone_extension">'.$ext.'</span><span class="sid_mobile_phone">'.$mobile2.'</span><span class="sid_fax">'.$fax2.'</span><br><span class="sid_custom1_label">'.$custom1label.'</span><span class="sid_custom1">'.$custom1.$cu1.'</span><span class="sid_custom2_label">'.$custom2label.'</span><span class="sid_custom2">'.$custom2.$cu2.'</span><span class="sid_custom3_label">'.$custom3label.'</span><span class="sid_custom3">'.$custom3.$cu3.'</span>';
echo '</div></div><br>';
}
}

//pagination stuff
$pr='Previous Page';
$ne='Next Page';
$plink = get_permalink( $id );
if ($page != 1) { 
echo '<a rel="prev" href="'.$plink.'/'.($page - 1).'">'.$pr.'</a>'.'  ';
 } 
if ($page < $total_pages ) { 
echo '<a rel="next" href="'.$plink.'/'.($page + 1).'">'.$ne.'</a>';
 } 

}


// CHANGE LEAVE A REPLY
add_filter('comment_form_defaults', 'simple_comments');

function simple_comments($defaults) {
    global $current_user ;
    $user_id = $current_user->ID;	
	$wall_reply2 = get_user_meta( $user_id, 'wall_text', true);
	$defaults['title_reply'] = $wall_reply2; // CHANGED TODAY
	if ($wall_reply2==''){		
	$defaults['title_reply'] = __('What are you working on?','simpleschools'); 	
	}
	$defaults['title_reply_to'] = 'Post a reply %s';
	return $defaults;
}

function wp_remove_events_from_admin_bar() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('tribe-events');
}
add_action( 'wp_before_admin_bar_render', 'wp_remove_events_from_admin_bar' ); 

// REMOVE COMMENT TAGS INFO
function mytheme_init() {
	add_filter('comment_form_defaults','simple_comments_form_defaults');
}
add_action('after_setup_theme','mytheme_init');

function simple_comments_form_defaults($default) {
	unset($default['comment_notes_after']);
	return $default;
}

function redirect_to_front_page() {
	global $redirect_to;
	if (!isset($_GET['redirect_to'])) {
		$redirect_to = get_option('siteurl');
	}
}

add_action('login_form', 'redirect_to_front_page');


// Away from school ALERT

/* Display an Away from school notice that can be dismissed */
add_action('admin_notices', 'si_admin_notice');
function si_admin_notice() {
    global $current_user, $pagenow, $status,$ignore3;
        $user_id = $current_user->ID;		
		 $status= esc_attr( get_the_author_meta( 'si_office_status', $user_id ,true) ); 
		 $ignore= esc_attr( get_the_author_meta( 'si_office_ignore', $user_id ,true) ); 

 if ( !$ignore) {
 add_user_meta($user_id, 'si_office_ignore', 'false', true);
    }
 if(!empty($_GET['si_ignore'])){
$ignore3='';
$ignore3=	$_GET['si_ignore']; 
update_user_meta($user_id, 'si_office_ignore', $ignore3);
 }

 if ( $pagenow == 'profile.php' || $status=='true' ) {
if ($status=='true' && $ignore!='true' && $ignore3!='true') {  
 update_user_meta($user_id, 'si_office_ignore', 'false');
	  echo '<div class="updated"><p>';
        printf(__('Away notification is ON. | <a href="%1$s">Turn OFF.</a>'), 'profile.php?si_office=false');
		 printf(__('<br><a href="%1$s">Dismiss this notice.</a>'), 'profile.php?si_ignore=true');
        echo "</p></div>"; 			
             update_user_meta($user_id, 'si_office_status', 'true');   		
			 if($_GET['si_ignore']){
			 $ignore2=$_GET['si_ignore'];
			 update_user_meta($user_id, 'si_office_ignore', $ignore2); 
			 }
			   	
	}
if ($status=='false' && $ignore!='true' && $ignore3!='true') {    
      echo '<div class="updated"><p>';
        printf(__('Away notification is OFF. | <a href="%1$s">Turn ON.</a>'), 'profile.php?si_office=true');
		printf(__('<br><a href="%1$s">Dismiss this notice.</a>'), 'profile.php?si_ignore=true');
        echo "</p></div>";	 
		 update_user_meta($user_id, 'si_office_status', 'false');   
		  if(!empty($_GET['si_ignore'])){
			 $ignore2=$_GET['si_ignore'];
			 update_user_meta($user_id, 'si_office_ignore', $ignore2);  
			 }
			 
}
   }
}

add_action('admin_init', 'si_in_office');
function si_in_office() {
    global $current_user;
        $user_id = $current_user->ID;		
        /* If user clicks to be back in office, add that to their user meta */  
		if(isset($_GET['si_office'])){
		if($_GET['si_office']!=''){
             update_user_meta($user_id, 'si_office_status', $_GET['si_office']);   
		}
		}
}

// AWAY FROM SCHOOL WIDGET 

class OutOfOfficeWidget extends WP_Widget
{
  function OutOfOfficeWidget()
  {
    $widget_ops = array('classname' => 'OutOfOfficeWidget', 'description' => __('Displays a list of staff who are away.') );
    $this->WP_Widget('OutOfOfficeWidget', 'Away From School', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 $gofs = get_option( 'gmt_offset' ); // get WordPress offset in hours
$tz = date_default_timezone_get(); // get current PHP timezone
date_default_timezone_set('Etc/GMT'.(($gofs < 0)?'+':'').-$gofs); // set the PHP timezone to match WordPress
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	// Create the WP_User_Query object
$wp_user_query2 = new WP_User_Query($args);
// pagination
// Get the results
$authors2 = $wp_user_query2->get_results();
// Check for results

if (empty($authors2))
{
echo 'None.<br><br>';
} 
global $c;
$c=0;
    foreach ($authors2 as $author2 ) {
$inoffice=get_the_author_meta('si_office_status', $author2->ID, true);
$outtext =get_the_author_meta( 'officenotification', $author2->ID); 
$officeexpireuk= get_the_author_meta( 'officeexpire_unix', $author2->ID) ;
if($officeexpireuk!=''){
$nicedate= gmdate("F j, Y", $officeexpireuk);
}
$expiry= get_the_author_meta( 'expiry', $author2->ID ); 
$expirytext= get_the_author_meta( 'expirytext', $author2->ID ); 

if($inoffice=='true' || $in_out=='true') {
$c=$c+1;
}
$first = get_the_author_meta('first_name', $author2->ID);
$last = get_the_author_meta('last_name', $author2->ID);
$title = get_the_author_meta('title', $author2->ID);
$email = get_the_author_meta('email', $author2->ID);
if ($inoffice=='true' || $in_out=='true'){
echo '<div id="wrap"><div class="employeephotowidget">';
if(get_avatar($author2->ID,40))
echo get_avatar($author2->ID,40);
echo '</div>';
echo '<div class="employeebiowidget">';
echo '<strong>'.$first.' '.$last.'</strong>';
if($outtext!=''){
echo '<br>'.$outtext.' ';
}
if($expiry=='Yes' && $nicedate!=''){
echo $expirytext.$nicedate.'';
}
echo '</div></div>';
} 
}
 if ($c==0)
{
echo 'None.<br><br>';
}
    echo $after_widget;
	date_default_timezone_set($tz); // set the PHP timezone back the way it was
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("OutOfOfficeWidget");') );


// STAFF WIDGET 

class EmployeesWidget extends WP_Widget
{
  function EmployeesWidget()
  {
    $widget_ops = array('classname' => 'EmployeesWidget', 'description' => __('Displays a list of staff.') );
    $this->WP_Widget('EmployeesWidget', __('Staff'), $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Staff') ) );
    $etitle = $instance['title'];

?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($etitle); ?>" /></label></p>
   
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];

    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $etitle = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
	
    if (!empty($etitle))
      echo $before_title . $etitle . $after_title;;
 
    // WIDGET CODE GOES HERE
	// Create the WP_User_Query object
$wp_user_query6 = new WP_User_Query($args);
$authors6 = $wp_user_query6->get_results();
// Check for results


global $c, $current_user;
$c=0;
    foreach ($authors6 as $key =>$author6 ) {
$c=$c+1;

$first6 = get_the_author_meta('first_name', $author6->ID);
$last6 = get_the_author_meta('last_name', $author6->ID);	
if (get_the_author_meta( 'exclude', $author6->ID )!="Yes"){
echo '<div id="wrap"><div class="employeephotowidget">';
if(get_avatar($author6->ID,40))
echo get_avatar($author6->ID,40);
echo '</div>';
echo '<div class="employeebiowidget">';
echo '<strong>'.$first6.' '.$last6.'</strong>';
echo '</div></div>';
}
}
 if ($c==0)
{
echo 'None.<br><br>';
}
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("EmployeesWidget");') );

// Schedule to check out of office alerts are updated regularly

register_activation_hook(__FILE__, 'outofoffice_activation');
add_action('outofoffice_daily_check', 'outofoffice_check');

function outofoffice_activation() {
wp_schedule_event(time(), 'hourly', 'outofoffice_daily_check');
}

function outofoffice_check() {

global $in_out, $officeexpire, $current_user;	
	//$gofs = get_option( 'gmt_offset' ); // get WordPress offset in hours
	//$tz = date_default_timezone_get(); // get current PHP timezone
	//date_default_timezone_set('Etc/GMT'.(($gofs < 0)?'+':'').-$gofs); // set the PHP timezone to match WordPress
	$right_now=time();
	  foreach ($authors9 as $key =>$author9 ) {
	 
	 $in_out=  get_the_author_meta( 'si_office_status', $author9, true) ; 
	 $officeexpire= get_the_author_meta( 'officeexpire_unix', $author9 ) ;
	 $set_expiry= esc_attr( get_the_author_meta( 'expiry', $author9 ) ); 	
	
	 if($set_expiry=="Yes"){
	 if($officeexpire<=$right_now ){
	 $in_out='false';
	 update_user_meta($author9, 'si_office_status','false'); 
	 }
	 if($officeexpire>=$right_now ){
	 $in_out='true';
	 update_user_meta($author9, 'si_office_status','true'); 
	  }
	  }
	  }
	//  date_default_timezone_set($tz); // set the PHP timezone back the way it was
}


?>