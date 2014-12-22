	






<div class="lay4">
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
                             
                             
 
   
            
      
                <div class="proj-thumb">
               
                     <!--CALL TO POST IMAGE-->
                    <?php if ( has_post_thumbnail() ) : ?>
                    
						
                       
                <?php the_post_thumbnail('medium'); ?>
                    
                    <?php elseif($photo = hathor_get_images('numberposts=1', true)): ?>
    
                                	
                        
                	<?php echo wp_get_attachment_image($photo[0]->ID ,'medium'); ?> 
					
                
                    <?php else : ?>
                    
                   
                     
                         
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blank1.jpg" alt="<?php the_title_attribute(); ?>"/>   
                             
                    <?php endif; ?>
                     
				<a href="<?php the_permalink();?>" ><span class="image-overlay"></span>	</a>
                           
                </div>	
                    
                 
                  <div class="proj-description">
                    

                    <h5 ><a href="<?php the_permalink();?>" ><?php the_title(); ?></a></h5>
                 
                    <i><?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">+'.$category[0]->cat_name.'</a>';}?></i>
 
                
                
                
</div></div>
                       
            <?php endwhile ?> 

            <?php endif ?>
</div>
          
           

    </div>