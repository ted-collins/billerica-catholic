<?php 
    /* Template Name: Page With left sidebar  */
    get_header(); 
?>
<div class="row">


<!--Content-->
<?php if(of_get_option('pagehead_checkbox') == "1"){ ?>
 <div id="sub_banner">
<h1>
<?php the_title(); ?>
</h1>
</div><?php } ?>
<div id="content">
<div class="top-content">

                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
                
                <div class="post_content">
                   
                    <a class="postimg"><?php the_post_thumbnail('medium'); ?></a>
                   
                   
                   <div class="metadate"> <?php edit_post_link(); ?></div> 
                    </div>
                    <div style="clear:both"></div>	
                    <div class="post_info_wrap"><?php the_content(); ?> </div>
                    <div style="clear:both"></div>	
                    
            <div class="post_wrap_n">         
                   
                   
</div>

                
                        
            <?php endwhile ?> 
            
                </div>   
				<div class="comments_template"><?php comments_template('',true); ?></div>
            <?php endif ?>


</div>

    
    <!--POST END--> 
   
    
<?php get_sidebar();?>
</div>
</div>
</div>

<?php get_footer(); ?>