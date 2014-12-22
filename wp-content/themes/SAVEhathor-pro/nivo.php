
<div id="nivo">

        <?php $loop = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => ''.$os_fonts = of_get_option('number_select').'' ) ); ?>
        
        <?php if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php $osirisdata = get_post_meta($post->ID, 'osiris_slide_link', TRUE); ?>
        <?php $osirisnivoimg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <?php $osirisnivothmb = wp_get_attachment_thumb_url( get_post_thumbnail_id($post->ID) ); ?>
        <img src="<?php echo $osirisnivoimg ?>" data-thumb="<?php echo $osirisnivothmb ?>" alt="<?php the_title(); ?>" title="#nv_<?php the_ID(); ?>" />

         <?php endwhile; else: ?>
<img  title="#nv_1" src="<?php echo get_template_directory_uri(); ?>/images/slide1.jpg" />
<img  title="#nv_2" src="<?php echo get_template_directory_uri(); ?>/images/slide2.jpg" />
<?php endif; ?>
            <?php wp_reset_query(); ?>
        </div>
        
        <?php if(of_get_option('sldrtxt_checkbox') == "1"){ ?>
        <?php $loop = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => ''.$zn_fonts = of_get_option('number_select').'' ) ); ?>
        <?php if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>         
            <div id="nv_<?php the_ID(); ?>" class="nivo-html-caption">
        <?php $osirisdata = get_post_meta($post->ID, 'osiris_slide_link', TRUE); ?>           
            <?php the_title( '<h3 class="entry-title"><a href="' . $osirisdata . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h3>' ); ?>
                <?php the_excerpt(); ?>
                
                 <?php if($osirisdata = get_post_meta($post->ID, 'osiris_slide_link', TRUE)){ ?>
                <a target="_blank" href="<?php echo $osirisdata; ?>"><div class='readmore2'><?php echo of_get_option('sliderlink2'); ?></div></a><?php } ?>
            </div>
            
                    <?php endwhile; else: ?>
             <div id="nv_1" class="nivo-html-caption">          
            <h3 class="entry-title"><?php echo of_get_option('block1_text'); ?></h3>
                <p><?php echo of_get_option('block1_textarea'); ?></p>
            </div>
            
            <div id="nv_2" class="nivo-html-caption">         
           <h3 class="entry-title"><?php echo of_get_option('block2_text'); ?></h3>
                <p><?php echo of_get_option('block2_textarea'); ?></p>
            </div>
            
                    <?php endif; ?>
         <?php } ?>

