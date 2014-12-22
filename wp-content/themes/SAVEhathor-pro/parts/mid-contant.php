


<div class="our_work">
        <div class="title">
          <h2 class="blue1"><?php echo of_get_option('recent_work'); ?></h2>
          <p><?php echo of_get_option('recent_work2'); ?></p>
        </div>
        <div id="middle" class="cols2 sidebar_left box_white">
          <div class="content" role="main">
            <article class="post-detail">
              <div class="entry">
                <div class="work-carousel">
                  <div class="work-carousel-head"> <a class="prev" id="work-carousel-prev" href="#" ><span>prev</span></a> <a class="next" id="work-carousel-next" href="#"><span>next</span></a> </div>
                  <div class="carousel_content">
                    <div class="caroufredsel_wrapper" >
                      <ul id="work-carousel" >
                        <li>
                        <?php  if(of_get_option('recent1')){ ?>
                          <div class="work">
                            <div class="main">
                           
                            
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent1'); ?>" alt="<?php echo of_get_option('recenttitle1'); ?>" />
                            
                                <div class="mask"></div>
                                <div class="content">
                                <?php  if(of_get_option('recenttitle1')){ ?>
                                  <h2><?php echo of_get_option('recenttitle1'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc1'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl1'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl1'); ?>"><?php echo of_get_option('recenttitle1'); ?></a></p>
                          </div>
                        </li>
                        <li>
						 <?php } ?>
                         
				<?php  if(of_get_option('recent2')){ ?>		
                          <div class="work">
                            <div class="main">
                              <div class="view view-second">
                              <?php  if(of_get_option('recent2')){ ?>	
                               <img  src="<?php echo of_get_option('recent2'); ?>" alt="<?php echo of_get_option('recenttitle2'); ?>" /><?php } ?>
                            
                               <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle2')){ ?>
                                  <h2><?php echo of_get_option('recenttitle2'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc2'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl2'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl2'); ?>"><?php echo of_get_option('recenttitle2'); ?></a></p>
                          </div>
                        </li>
                        <li>
						
						 <?php } ?>
                         
                        <?php  if(of_get_option('recent3')){ ?>	
                          <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent3'); ?>" alt="<?php echo of_get_option('recenttitle3'); ?>" />
                              
                               <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle3')){ ?>
                                  <h2><?php echo of_get_option('recenttitle3'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc3'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl3'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl3'); ?>"><?php echo of_get_option('recenttitle3'); ?></a></p>
                          </div>
                        </li>
                        <li >
						<?php } ?>
                        
                        <?php  if(of_get_option('recent4')){ ?>	 
                        
                          <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent4'); ?>" alt="<?php echo of_get_option('recenttitle4'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle4')){ ?>
                                  <h2><?php echo of_get_option('recenttitle4'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc4'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl4'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl4'); ?>"><?php echo of_get_option('recenttitle4'); ?></a></p>
                          </div>
                        </li>
                        <li >
						
						<?php } ?>
                        
                        
                        <?php  if(of_get_option('recent5')){ ?>	 
                         <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent5'); ?>" alt="<?php echo of_get_option('recenttitle5'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle5')){ ?>
                                  <h2><?php echo of_get_option('recenttitle5'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc5'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl5'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                           
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl5'); ?>"><?php echo of_get_option('recenttitle5'); ?></a></p>
                          </div>
                        </li>
                       
                 <?php } ?>
              
              
        
                       
                <?php  if(of_get_option('recent6')){ ?>	 
                         <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent6'); ?>" alt="<?php echo of_get_option('recenttitle6'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle6')){ ?>
                                  <h2><?php echo of_get_option('recenttitle6'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc6'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl6'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                           
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl6'); ?>"><?php echo of_get_option('recenttitle6'); ?></a></p>
                          </div>
                        </li>
                       
                 <?php } ?>
                 
                 
       <?php  if(of_get_option('recent7')){ ?>	 
                         <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent7'); ?>" alt="<?php echo of_get_option('recenttitle7'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle7')){ ?>
                                  <h2><?php echo of_get_option('recenttitle7'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc7'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl7'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                           
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl7'); ?>"><?php echo of_get_option('recenttitle7'); ?></a></p>
                          </div>
                        </li>
                       
                 <?php } ?>
                    
                    
        <?php  if(of_get_option('recent8')){ ?>	 
                         <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent8'); ?>" alt="<?php echo of_get_option('recenttitle5'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle8')){ ?>
                                  <h2><?php echo of_get_option('recenttitle8'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc8'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl8'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                           
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl8'); ?>"><?php echo of_get_option('recenttitle8'); ?></a></p>
                          </div>
                        </li>
                       
                 <?php } ?>
                 
                 
                 
                 
      <?php  if(of_get_option('recent9')){ ?>	 
                         <div class="work">
                            <div class="main">
                              
                              <div class="view view-second"> <img  src="<?php echo of_get_option('recent9'); ?>" alt="<?php echo of_get_option('recenttitle9'); ?>" />
                              
                                <div class="mask">
                               </div>
                              <div class="content">
                                <?php  if(of_get_option('recenttitle9')){ ?>
                                  <h2><?php echo of_get_option('recenttitle9'); ?></h2>
                                  <?php } ?>
                                  <p><?php echo of_get_option('recentdesc9'); ?></p>
                                  <a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl9'); ?>" class="info"><?php echo of_get_option('recentlink2'); ?></a> </div>
                              </div>
                            </div>
                           
                            <p class="port"><a <?php if(of_get_option('newtab2_checkbox','hathor') == "1"){ ?> target="_blank" <?php } ?> href="<?php echo of_get_option('recenturl9'); ?>"><?php echo of_get_option('recenttitle9'); ?></a></p>
                          </div>
                        </li>
                       
                 <?php } ?>
                         
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </article>
            </div></div>