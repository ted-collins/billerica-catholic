	






<div class="lay2">
<?php if(of_get_option('frontcat_checkbox') == "1"){ ?>
<?php if(is_front_page()) { 
	 $args = array(
				   'cat' => ''.$os_front = of_get_option('front_cat').'',
				   'post_type' => 'post',
				   'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
				   'posts_per_page' => ''.$os_fonts = of_get_option('frontnum_select').'');
	query_posts($args);
} ?>
<?php }?>

          
				   
				   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
                             
                             
 
   
            
      
                <span class="imageWrap">
               
                     <!--CALL TO POST IMAGE-->
                    <?php if ( has_post_thumbnail() ) : ?>
                    
						
                       <a href="  " data-rel="prettyPhoto " >
                <?php the_post_thumbnail('medium'); ?>
                    
                    <?php elseif($photo = hathor_get_images('numberposts=1', true)): ?>
    
                                	
                        
                	<?php echo wp_get_attachment_image($photo[0]->ID ,'medium'); ?> 
					
                
                    <?php else : ?>
                    
                   
                     
                         
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blank1.jpg" alt="<?php the_title_attribute(); ?>"/>   
                             
                    <?php endif; ?>
                     
					<span><span></span></span>
                    </a>          
                </span>	
                    
                 
                  <span class="shadowHolder"><img src="<?php echo get_template_directory_uri(); ?>/images/small-shadow.png" alt=""></span>     
                    

                    <h3  ><?php the_title(); ?></h3>
                   <p> <?php hathor_excerpt('hathor_excerptlength_teaser', 'hathor_excerptmore'); ?> </p>
                     <a class="buttonPro"  href="<?php the_permalink();?>" >

Learn More</a>
 
                
                
                

                        </div>
            <?php endwhile ?> 

            <?php endif ?>
</div>
          
           

    </div>