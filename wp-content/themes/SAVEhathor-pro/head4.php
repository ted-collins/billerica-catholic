
<div class="row"> 
 <div class="large-12">

 <div id="branding4">
 

          <div class="call2">
          <?php if ( of_get_option('call_num') ) { ?>     
       
   <?php echo of_get_option('call_num'); ?>

 <?php } ?></div>
    	<!--LOGO START-->
        <div id="site-title4">
        <?php if (of_get_option('hathor_logo_image')) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo of_get_option('hathor_logo_image'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
                    <?php else : ?>
                    
       <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo('description'); ?>" rel="home"><?php bloginfo('name'); ?></a><?php endif; ?>	
        
        
        </div>
        <div class="desc4"><?php bloginfo('description'); ?></div>
        
        </div>
      
       </div></div>
       
       
        
     
        <!--LOGO END-->
        
        <!--MENU STARTS-->
       
        <div class="row">
         
        <div class="large-12 ">
      
         <div id="menu_wrap4"><div id="navmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>   </div>
        
        </div>
         
    
        </div>
        
      
        </div></div>
        <!--MENU END-->