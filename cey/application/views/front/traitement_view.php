<div id="content">
<h1 class="content-heading bg-white border-bottom">
	<?php 

		if($type_proc == "action"){

			echo "&nbsp;".ascii_to_entities($nom_entre)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_categorie)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_traitement)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_operation);
		}
		if($type_proc == "operation"){

			echo "&nbsp;".ascii_to_entities($nom_entre)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_categorie)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_traitement);
		
		}
		if($type_proc == "traitement"){

			echo "&nbsp;".ascii_to_entities($nom_entre)."&nbsp;&nbsp;<i class=\"fa fa-chevron-circle-right\"></i>&nbsp;&nbsp;".ascii_to_entities($nom_categorie);

		}
	?>
</h1> 
<div class="innerAll spacing-x2">

    	
<!-- CONTENT -->
<div class="wizard" style="margin-top: 70px;">

    <div class="widget widget-tabs widget-tabs-double widget-tabs-vertical row row-merge widget-tabs-gray">
    		
        <!-- ETAPES PROCESSUS -->
        <div id="rootwizard" class="wizard">

        	<!-- NBRE ETAPES PROCESSUS -->
        	<div class="wizard-head hidden">
        		<ul>					
						<?php
							$i_tab = 0;
							foreach ($lst_proc as $val_proc) {
								$i_tab += 1;
								$pr_act = $lst_act[$val_proc->cey_marche_id];
						?>
							<li><a href="#tab<?php echo $val_proc->cey_marche_id; ?>" data-toggle="tab" id="lien<?php echo $val_proc->cey_marche_id; ?>"><?php echo $i_tab;?></a></li>
						<?php 
							}
						?>
					
        		</ul>
        	</div>
        	<!-- END NBRE ETAPES PROCESSUS -->
        	
        	<div class="widget">
        	
        		
				<!-- Wizard Progress bar -->
				
        		<!--<div class="widget-head progress" id="bar">
        			<div class="progress-bar progress-bar-primary"><strong class="step-current">1</strong> à <strong class="steps-total"><?php  echo $i_tab; ?></strong> - <strong class="steps-percent">100%</strong></div>
        		</div>-->

        		<!-- // Wizard Progress bar END -->
        		
        		<div class="widget-body">
        			<div class="tab-content">
        			
						<?php

						if(isset($lst_proc) && isset($lst_act)){
							foreach ($lst_proc as $val_proc) {
								$pr_act = $lst_act[$val_proc->cey_marche_id];
						?>

        				<div class="tab-pane" id="tab<?php echo $val_proc->cey_marche_id;?>">
        					<div class="row slim-scroll">
        						<div class="col-md-12 etape-contenu"> 
        						<?php 

        						if(isset($id_proc_pop) && isset($libelle_pop)){
        							
        							if($val_proc->type =="popup") {
        							
        						?>
        									<a href="#proc_redirect_<?php echo $val_proc->cey_marche_id; ?>" id="popup_<?php echo $id_proc_pop; ?>" data-toggle="modal"  class="btn btn-info btn-block"><?php echo $val_proc->libelle; ?></a>
        									
        						<?php
									}else{
										
										if(isset($val_proc->active_popup_all) && $val_proc->active_popup_all == 1){

								?>	
											<a href="#"  class="btn btn-info pull-left" onclick="charge_popup_direct(<?php echo $id_proc_pop; ?>); return false;"><?php echo $libelle_pop; ?></a><br/>
											<hr>
								<?php
											echo ascii_to_entities($val_proc->text_html);
										}
										
									}
								}else{
									echo ascii_to_entities($val_proc->text_html);
								}


								?>
        						</div>

								<!--<div class="col-md-3">
									consigne ou image 	
								</div>-->

							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<!--<ul>-->							
											<?php
											if($val_proc->type !="popup"){
												if(!empty($pr_act)){ 
													foreach ($pr_act as $val_act) {
														if($val_act->marche_redirect_id != "0"){
												?>
												<!--<li>--><a href="#tab<?php echo $val_act->marche_redirect_id; ?>" data-toggle="tab" class="btn btn-info pull-right action-btn"   onclick="click_tab(<?php echo $val_act->marche_redirect_id; ?>, <?php echo $val_act->cey_arret_id; ?>)"><?php echo ascii_to_entities($val_act->libelle); ?></a><!--</li>-->
															
												<?php	
														}else{

														?>
															<a href="<?php echo site_url('front/pont/terminer'); ?>" class="btn btn-info pull-right action-btn"><?php echo $val_act->libelle; ?></a><!--</li>-->
															
														<?php							
														}
													}
												}
											}
											?>
										<!--</ul>-->
													<?php 
														if(isset($deb_proc)){  
															if($deb_proc == $val_proc->cey_marche_id ){
													?>
																
													<?php 
															}else{
													?>
																<button class="btn btn-primary pull-left" onclick="abhis()"><i class="fa fa-lg fa-arrow-left"></i> ACTION PRECEDENTE</button>
													<?php
															}
														} 
													?>
								</div>
							</div>
							

        				</div>
						
						<?php
							}
						}
						?>
						
        			</div>
        			
        		</div>
        	</div>
        </div>
        <!-- END ETAPES PROCESSUS -->

    </div>	
    

</div>
<!-- END CONTENT -->


	
		
		
		