						<?php 
                        $sidebarposition = klasik_get_option( 'klasik_sidebar_position' ,'two-col-left'); 
                		
						
                        if(is_home()){
							$pid = get_option('page_for_posts');
						}else{
							$pid = '';
						}
						$custom_fields = klasik_get_customdata($pid);
                        
                        $pagelayout = $sidebarposition;
                        
						if(klasik_get_metabox('klasik_layout') && klasik_get_metabox('klasik_layout')!='default' && is_search()!='default'){
							$pagelayout = klasik_get_metabox('klasik_layout');
						}
						?>
						
                        		<div class="clear"></div>
                            </div><!-- main -->
                            
                            <?php
							if(is_active_sidebar('contentbottom') ){ 
							?>
							<div class="row">
								<div class="twelve columns">
                                    <div class="custom-position contentbottom-container">
                                        <?php if ( ! dynamic_sidebar( 'contentbottom' ) ){ }?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
							</div>
							<?php 
							}
							?>
                            
                            <div class="clear"></div>
                        </section><!-- content -->
                        
                        <?php if($pagelayout!='one-col'){ ?>
                        
                        <aside id="sidebar" class="sidebarcol columns <?php if($pagelayout=="two-col-left"){echo "positionright";}else{echo "positionleft";}?>">
                            <?php get_sidebar();?>  
                        </aside><!-- sidebar -->
                        
                        <?php } ?>
                        <div class="clear"></div>
                        </section><!-- END #maincontent -->
                        
                        <div class="clear"></div>
                    </div>
                </div><!-- END container -->
                </div><!-- END maincontent-container --> 
                   
				<?php if(is_active_sidebar('mainbottom') ){ ?>
               
                    <div class="custom-position mainbottom-container">
                        <?php if ( ! dynamic_sidebar( 'mainbottom' ) ){ } ?>
                        <div class="clear"></div>
                    </div>
            
                <?php } ?>
                        

            </div><!-- END maincontainer -->
        </div><!-- END outermain -->
        <!-- END MAIN CONTENT -->
        
