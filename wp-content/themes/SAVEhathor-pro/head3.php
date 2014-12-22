



 <div class="row"> 
 <div class="large-12 ">
    
 <div class="topbar">
 
 


 <div class="social-profiles ">
				
                <ul>
				<?php if ( of_get_option('fbsoc_text') ) { ?>

        <li class="facebook"> <a  href="<?php echo of_get_option('fbsoc_text');?>" title="facebook"></a></li><?php } ?>
         
                <?php if ( of_get_option('ttsoc_text') ) { ?>
                <li class="twitter"><a  href="<?php echo of_get_option('ttsoc_text'); ?>" target="_blank" title="twitter">twitter</a></li><?php } ?>
                
                <?php if ( of_get_option('gpsoc_text') ) { ?>
                <li class="google-plus"><a href="<?php echo of_get_option('gpsoc_text'); ?>" title=" Google Plus" target="_blank"> Google Plus</a></li><?php } ?>
                
                 <?php if ( of_get_option('pinsoc_text') ) { ?>
                <li class="pinterest"><a href="<?php echo of_get_option('pinsoc_text'); ?>" title=" Pinterest" target="_blank"> Pinterest</a></li>
                <?php } ?>
                
                 <?php if ( of_get_option('ytbsoc_text') ) { ?>
                <li class="you-tube"><a href="<?php echo of_get_option('ytbsoc_text'); ?>" title=" Youtube" target="_blank"> Youtube</a></li><?php } ?>
                
                <?php if ( of_get_option('linsoc_text') ) { ?>
                <li class="linked"><a href="<?php echo of_get_option('linsoc_text'); ?>" title=" linked" target="_blank"> linked</a></li><?php } ?>
                
                <?php if ( of_get_option('vimsoc_text') ) { ?>
                <li class="vimeo"><a href="<?php echo of_get_option('vimsoc_text'); ?>" title=" Vimeo" target="_blank"> Vimeo</a></li><?php } ?>
                
                  <?php if ( of_get_option('flisoc_text') ) { ?>
                <li class="flickr"><a href="<?php echo of_get_option('flisoc_text'); ?>" title=" flickr" target="_blank"> flickr</a></li><?php } ?>
                
                 <?php if ( of_get_option('rsssoc_text') ) { ?>
                <li class="rss"><a href="<?php echo of_get_option('rsssoc_text'); ?>" title="rss" target="_blank"> rss</a></li><?php } ?>
                
			</ul>
			</div>
    <?php if ( of_get_option('call_num') ) { ?> 
        <h6>
   <?php echo of_get_option('call_num'); ?>
</h6>
 <?php } ?>
 </div>
 
 <div id="branding3">

    	<!--LOGO START-->
        <div id="site-title3">
        <?php if (of_get_option('hathor_logo_image')) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo of_get_option('hathor_logo_image'); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
                    <?php else : ?>
                    
       <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo('description'); ?>" rel="home"><?php bloginfo('name'); ?></a><?php endif; ?>	
       
        
        
        
       
       
     
       
        
     
        <!--LOGO END-->
        
        <!--MENU STARTS-->
       
         
       
      
        <div id="menu_wrap"><div id="navmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>   </div> </div>
        
       
         </div>
    
       
   </div>
        
      </div>
      
      
</div>
             <!--MENU END-->
