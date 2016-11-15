	<!-- MODAL -->
	<div class="modal fade" id="proc_redirect_<?php echo $id_proc; ?>">
		<div class="modal-dialog">
			<div class="modal-content">


				<!-- MODAL HEADER -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><?php echo ascii_to_entities($libelle); ?></h3>
				</div>
				<!-- END MODAL HEADER -->
				
				<!-- MODAL BODY -->
				<div class="modal-body">
					<div class="innerAll">
						<?php echo ascii_to_entities($text_html); ?>

					</div>
				</div>
				<!--  END MODAL BODY -->

				  
				
				

				<!-- MODAL FOOTER -->
				<div class="modal-footer popup_foot_<?php echo $id_proc; ?>">

					
						<?php 


							if ($acts) {

								foreach ($acts as $val_act) {


										if($id_proc == $val_act->marche_id){	
						
											if($val_act->marche_redirect_id != "0"){
						?>
												<a href="#tab<?php echo $val_act->marche_redirect_id; ?>" data-toggle="tab" class="btn btn-info pull-right action-btn"   onclick="click_tab(<?php echo $val_act->marche_redirect_id; ?>, <?php echo $val_act->cey_arret_id; ?>)"><?php echo ascii_to_entities($val_act->libelle); ?></a>
													
						<?php	
											}else{

						?>
												<a href="<?php echo site_url('front/pont/terminer'); ?>" class="btn btn-info pull-right action-btn"><?php echo $val_act->libelle; ?></a>
													
						<?php							
											}	
										}
						 
								}
							}

						
						?>
					
				</div>
				<!--  END MODAL FOOTER -->


				
			
			</div>
		</div> 
	</div>
	<!-- END MODAL -->