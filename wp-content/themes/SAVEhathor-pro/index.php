<?php get_header(); ?>


 <!--Slider-->
 <?php if ( is_home() ) { ?>


<div class="row"> 

<div id="slider">

<?php get_template_part(''.$slides = of_get_option('slider_select', 'nivo').''); ?>
 <?php }?> 
          
 		
            
</div>



</div>
</div></div>
<!--Slider end-->

<!-- Start Callout section -->

<?php if ( is_home() ) { ?>
<?php if(of_get_option('welcome2_enable','isis') == "1"){ ?>

<div class="  warp row">
<div class=" large-12">
<?php if ( of_get_option('hathor1_welcome') ) : ?>


            
            
            
            <?php echo apply_filters('the_content', of_get_option('hathor1_welcome')); ?>
 </section>
  </div></div>         

            <?php endif; ?>
            <?php } ?> 
</div></div>
 <?php } ?> 
 <!-- END #callout -->

<!-- Start Call to action -->
<?php if ( is_home() ) { ?>
<?php if(of_get_option('callout3_enable','isis') == "1"){ ?>
<div class="warp row">
<div class="large-12 columns">
<div class="stunning boxes-shadow animated animation-btt" >
<section class="stunning-text">
<a class="midbutton-call" href="<?php echo of_get_option('call3_link'); ?>"><?php echo of_get_option('call3_linkname'); ?></a>
           
<div class="contents">
<?php if ( of_get_option('isis_call3') ) : ?>
            
           
            <?php echo apply_filters('the_content', of_get_option('isis_call3')); ?>
             
            </div>
            
            
         
 </section>
  </div></div>       

            <?php endif; ?>
            
            <?php } ?> 
            <?php } ?> 
</div></div>  
        
              <!-- END Call to action  --> 

<!--Service  Block-->
<div class="services-wrap row "> 
 
<?php if ( is_home() ) { ?>





  
    
<?php if(of_get_option('blocks_checkbox','hathor') == "1"){ ?>


<?php get_template_part(''.$block = of_get_option('block_select', 'service').''); ?>
<?php }?>
<?php }else{ ?>
 
 <?php get_template_part('dummy/dummy','bloks'); ?>
        <?php } ?>  
 
</div></div>		
</div>
<!--Service Block End-->

<!-- Start Call to action -->
<?php if ( is_home() ) { ?>
<?php if(of_get_option('callout1_enable','isis') == "1"){ ?>
<div class="warp row">
<div class="large-12 columns">
<div class="stunning boxes-shadow animated animation-btt" >
<section class="stunning-text">
<a class="midbutton-call" href="<?php echo of_get_option('call1_link'); ?>"><?php echo of_get_option('call1_linkname'); ?></a>
           
<div class="contents">
<?php if ( of_get_option('isis_call1') ) : ?>
            
           
            <?php echo apply_filters('the_content', of_get_option('isis_call1')); ?>
             
            </div>
            
            
         
 </section>
  </div></div>       

            <?php endif; ?>
            
            <?php } ?> 
            <?php } ?> 
</div></div>  
        
              <!-- END Call to action  --> 
<!--recent work-->
 
<?php if ( is_home() ) { ?>
<div class="row "> 

<div class="warp large-12 columns">


<?php if(of_get_option('recentwork_checkbox','hathor') == "1"){ ?>


<?php get_template_part('parts/mid','contant'); ?>

<?php }?>

<?php }else{ ?>
 
 <?php get_template_part('dummy/dummy','contant'); ?>
        <?php } ?> 

</div></div>		
</div>




<!--recent work end-->
<!-- Start Callout section -->

<?php if ( is_home() ) { ?>
<?php if(of_get_option('welcome1_enable','isis') == "1"){ ?>
<div class="  warp row">
<div class=" large-12">
<?php if ( of_get_option('hathor_welcome') ) : ?>
<section id="callout">

            
            
            
            <?php echo apply_filters('the_content', of_get_option('hathor_welcome')); ?>
 </section>
  </div></div>         

            <?php endif; ?>
            <?php } ?> 
</div></div>
<?php } ?> 
 <!-- END #callout -->

<!--LATEST POSTS-->

<?php if ( is_home() ) { ?>

<div class="row "> 
<div class="warp columns ">
<div class="title">
<h2 class="blue1"><?php echo of_get_option('latest_blog'); ?></h2></div>
	<?php if(of_get_option('latstpst_checkbox') == "1")
	{ ?><?php get_template_part(''.$os_lays = of_get_option('layout1_images','layout1').''); ?><?php } else { ?><?php } ?>
<?php } else { ?>
	<?php get_template_part(''.$os_lays = of_get_option('layout1_images', 'layout1').''); ?>
    
<?php } ?> 



</div>
</div>
</div></div></div>

<!--LATEST POSTS END-->

<!--Our team-->

<?php if ( is_home() ) { ?>
<div class="row "> 

<div class="warp large-12 columns">


<?php if(of_get_option('ourteam_checkbox','hathor') == "1"){ ?>


<?php get_template_part('parts/mid','team'); ?>


<?php }?>
<?php }else{ ?>
 
 

</div></div>		
<?php }?></div></div></div>

<!--Our Team END-->

<!--Our client-->

<?php if(of_get_option('ourclient_checkbox','hathor') == "1"){ ?>
 <div class="row "> 

<div class=" warp large-12 columns">

<?php get_template_part('parts/our','client'); ?>


<?php }?>

      </div></div>
<!--Our Client END-->


<!-- Start Call to action -->
<?php if ( is_home() ) { ?>
<?php if(of_get_option('callout2_enable','isis') == "1"){ ?>
<div class="warp row">


<section class="stunning-text2">
<a class="midbutton-call" href="<?php echo of_get_option('call2_link'); ?>"><?php echo of_get_option('call2_linkname'); ?></a>
           
<div class="contents">
<?php if ( of_get_option('isis_call2') ) : ?>
            
           
            <?php echo apply_filters('the_content', of_get_option('isis_call2')); ?>
             
            </div>
            
            
         
 </section>
  </div></div>       

            <?php endif; ?>
            
            <?php } ?> 
            <?php } ?> 
</div>  
        
              <!-- END Call to action  --> 

<?php get_footer(); ?>