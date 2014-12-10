
<div class="row">

<div class="lay1">


<?php if(of_get_option('frontcat_checkbox') == "1"){ ?>
<?php if(is_front_page()) { 
	$args = array(
				   'cat' => ''.$os_front = of_get_option('front_cat').'',
				   'post_type' => 'post',
				   'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
				   'posts_per_page' => ''.$os_fonts = of_get_option('frontnum_select').''
				   );
	
   new WP_Query( $args ); 
   
} ?>

<?php }?>    
		
 <?php wp_reset_postdata(); ?>


	   
				   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
                             
                             
 
   
   
   
              

                  
            
                <div class="post_image">
                     <!--CALL TO POST IMAGE-->
                     
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class=" imgwrap">
                     
                      <a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium'); ?></a>
                   <div class="ch-item ch-img-1 "> 
                   
                     
                    
                     
						  
                        
                      
                       
                        
                        </div>
                       
                        
                    </div>
                    
                    <?php elseif($photo = hathor_get_images('numberposts=1', true)): ?>
    
                    <div class=" imgwrap">
                    <a href="<?php the_permalink();?>"><?php echo wp_get_attachment_image($photo[0]->ID ,'medium'); ?></a>
                    <div class="ch-item ch-img-1 "> 
                   
                  
						
                        
                       
                        </div>
                        
                                            
                        
                	</div>
                
                    <?php else : ?>
                    
                    <div class=" imgwrap">
                    <a href="<?php the_permalink();?>"><img src="<?php echo get_template_directory_uri(); ?>/images/blank1.jpg" alt="<?php the_title_attribute(); ?>" class="thn_thumbnail"/></a>
                    
                    <div class="ch-item ch-img-1 "> 
                   
                     
					
                        
                       
                        </div>
                        
                                            
                        
                	
                        
                    </div>   
                             
                    <?php endif; ?>
                </div>
                
                
                <div class=" post_content2">
               <div class=" post_content3">
                    <h2 class="postitle_lay"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                     
                    <?php hathor_excerpt('hathor_excerptlength_teaser', 'hathor_excerptmore'); ?> 
                    
                </div> </div>
 
                        </div>
            <?php endwhile ?> 

            <?php endif ?>
        <?php get_template_part('pagination'); ?>  
</div>
            
                  

 

       </div>       


<div>
	<table border="0" cellspacing="1" cellpadding="5" width="100%">
    <tbody>
        <tr>
            <td><a href="http://www.rcab.org/" target="_blank"><img width="135" height="135" style="border: 0px solid;" title="Archdiocese of Boston" alt="Archdiocese of Boston" src="/wp-content/uploads/assets/bostonAD.gif" /></a></td>
            <td><a href="http://www.vatican.va/phome_en.htm" target="_blank" alt="Vatican"><img width="95" height="103" style="border: 0px solid;" alt="Vatican" src="/wp-content/uploads/assets/vatic_home3.gif" /></a></td>
            <td><a href="http://www.usccb.org/" target="_blank"><img width="110" height="107" style="border: 0px solid;" title="United States Conference of Catholic Bishops" alt="United States Conference of Catholic Bishops" src="/wp-content/uploads/assets/usccb.gif" /></a></td>
            <td><a href="http://www.ewtn.com/" target="_blank"><img width="120" height="35" style="border: 0px solid;" alt="Eternal Word Television Network" src="/wp-content/uploads/assets/ewtn.gif" /></a></td>
        </tr>
    </tbody>
</table>

</div>

</div>

</div>
