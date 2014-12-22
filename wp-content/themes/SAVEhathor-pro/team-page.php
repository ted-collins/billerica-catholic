<?php 
    /* Template Name: Team Page */
    get_header(); 
?>
  
 <div class="row">
   
  <?php if(of_get_option('pagehead_checkbox') == "1"){ ?> 
 <div id="sub_banner">
<h1>
<?php the_title(); ?>
</h1>
</div>
<?php } ?>


<div id="content" >
<div class="top-content2">

<div class="our_team">
        <div class="title">
          <h2 class="blue1"><?php echo of_get_option('ourteam_work'); ?></h2>
          <p><?php echo of_get_option('ourteam_work2'); ?></p>
        </div>
        
                        <?php  if(of_get_option('ourteam1')){ ?>
                          <div class="work">
                            <div class="main">
                           
                            
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam1'); ?>" alt="<?php echo of_get_option('ourteamtitle1'); ?>" />
                            <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl1'); ?>" >
                                <div class="mask">
                                
                                <?php  if(of_get_option('ourteamtitle1')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle1'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc1'); ?></p>
                                   </div>
                                   </a>
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl1'); ?>"><?php echo of_get_option('ourteamtitle1'); ?></a></p>
                          </div>
                       
                       
						 <?php } ?>
                         
				<?php  if(of_get_option('ourteam2')){ ?>		
                          <div class="work">
                            <div class="main">
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam2'); ?>" alt="<?php echo of_get_option('ourteamtitle2'); ?>" />
                                <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl2'); ?>" >
                               <div class="mask">
                             
                                <?php  if(of_get_option('ourteamtitle2')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle2'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc2'); ?></p>
                                   </div>
                                   </a>
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl2'); ?>"><?php echo of_get_option('ourteamtitle2'); ?></a></p>
                          </div>
                        
                        						
						 <?php } ?>
                         
                        <?php  if(of_get_option('ourteam3')){ ?>	
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam3'); ?>" alt="<?php echo of_get_option('ourteamtitle3'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl3'); ?>" >
                               <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle3')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle3'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc3'); ?></p>
                                  </div>
                                  </a>
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl3'); ?>"><?php echo of_get_option('ourteamtitle3'); ?></a></p>
                          </div>
                        
                        
						<?php } ?>
                        
                        <?php  if(of_get_option('ourteam4')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam4'); ?>" alt="<?php echo of_get_option('ourteamtitle4'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl4'); ?>" >
                                <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle4')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle4'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc4'); ?></p>
                                 </div></a> 
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl4'); ?>"><?php echo of_get_option('ourteamtitle4'); ?></a></p>
                          </div>
                       
                        
						
						<?php } ?>
                        
                        
              <?php  if(of_get_option('ourteam5')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam5'); ?>" alt="<?php echo of_get_option('ourteamtitle5'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl5'); ?>" >
                                <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle5')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle5'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc5'); ?></p>
                                 </div></a> 
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl5'); ?>"><?php echo of_get_option('ourteamtitle5'); ?></a></p>
                          </div>
                        
                        
						
						<?php } ?>          
                    
                 
              <?php  if(of_get_option('ourteam6')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam6'); ?>" alt="<?php echo of_get_option('ourteamtitle6'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl6'); ?>" >
                                <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle6')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle6'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc6'); ?></p>
                                 </div></a> 
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl6'); ?>"><?php echo of_get_option('ourteamtitle6'); ?></a></p>
                          </div>
                       
                        
						
						<?php } ?>  
                        
               <?php  if(of_get_option('ourteam7')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam7'); ?>" alt="<?php echo of_get_option('ourteamtitle7'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl7'); ?>" >
                                <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle7')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle7'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc7'); ?></p>
                                 </div></a> 
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl7'); ?>"><?php echo of_get_option('ourteamtitle7'); ?></a></p>
                          </div>
                       
                        
						
						<?php } ?>  
                 
                 
                 
           <?php  if(of_get_option('ourteam8')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view_team view-fifth"> <img  src="<?php echo of_get_option('ourteam8'); ?>" alt="<?php echo of_get_option('ourteamtitle8'); ?>" />
                              <a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl8'); ?>" >
                                <div class="mask">
                               
                                <?php  if(of_get_option('ourteamtitle8')){ ?>
                                  <h2><?php echo of_get_option('ourteamtitle8'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('ourteamdesc8'); ?></p>
                                 </div></a> 
                              </div>
                            </div>
                            <p class="port_team"><a <?php if(of_get_option('newtab3_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('ourteamurl8'); ?>"><?php echo of_get_option('ourteamtitle8'); ?></a></p>
                          </div>
                        
                        
						
						<?php } ?>
                 
                         
                      
                  

</div></div></div></div>
<?php get_footer(); ?>