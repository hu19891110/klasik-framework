        <!-- MAIN CONTENT -->
        <div id="outermain">
        	<div id="maincontainer">

                    <?php if(is_active_sidebar('maintop') ){ ?>
               
                    	<div class="custom-position maintop-container">
                    		<?php if ( ! dynamic_sidebar( 'maintop' ) ){ } ?>
                        	<div class="clear"></div>
                        </div>
                  
                    <?php } ?>
                
                <div id="maincontent-container">  
                <div class="container">
                    <div class="row">
                    
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
                    
                    if($pagelayout!='one-col'){
                        $mcontentclass = "hassidebar";
						$contentclass = 'contentcol columns ';
						
                        if($pagelayout=="two-col-left"){
                            $mcontentclass .= " mborderright";
							$contentclass .= "positionleft";
                        }else{
                            $mcontentclass .= " mborderleft";
							$contentclass .= "positionright";
                        }
                    }else{
                        $mcontentclass = "twelve columns";
						$contentclass = '';
                    }
		
                    ?>
                    <section id="maincontent" class="<?php echo $mcontentclass; ?>">
                    
                    
                        <section id="content" class="<?php echo $contentclass; ?>">


                            <?php if(is_active_sidebar('contenttop') ){ ?>
                            <div class="row">
                                <div class="twelve columns">
                                    <div class="custom-position contenttop-container">
                                        <?php if ( ! dynamic_sidebar( 'contenttop' ) ){ } ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php 
								$nocont="";
								if(!empty($post))
								if(get_the_content()== "" && is_page() && !is_page_template()){$nocont="nocontent";} 
							?>
                            <div class="main <?php echo $nocont; ?>">
                           