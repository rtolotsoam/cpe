
						<?php 
								$row = $lst_proc;

								$id_ck = 'area_html_'.$row->cey_marche_id;

						?>
						
						<?php /*?>
						<script>
						$(document).ready(function(){
							var obj3 = '#type_'+'<?php echo $row->cey_marche_id; ?>';
							var obj4 = '#opt_popup_'+'<?php echo $row->cey_marche_id; ?>';

							var str = $(obj3).val();

							console.log(str);

							if(str == 'popup'){
								$(obj4).removeClass('hidden');
							}
							
						});
						</script>

						<?php */?>

        				<div class="tab-pane" id="tab<?php echo $row->cey_marche_id; ?>">

        					<div class="row">
        						<div class="col-md-12">
									<label for="txt_libelle_<?php echo $row->cey_marche_id; ?>">Libelle</label>
									<input type="text" id="txt_libelle_<?php echo $row->cey_marche_id; ?>" class="form-control" value="<?php  echo ascii_to_entities($row->libelle);  ?>"/>
								</div>
							</div>
							<br>


							<div class="row hidden">
	        					<div class="col-md-3">
									<div class="form-group">
										<label for="type_<?php echo $row->cey_marche_id; ?>">Type d'affichage</label>
										<select id="type_<?php echo $row->cey_marche_id; ?>" class="form-control" style="text-align: center;" onchange="affiche_type(<?php echo $row->cey_marche_id; ?>);">
											<option value="normal" <?php if($row->type == "normal"){ echo "selected"; } ?>> Normal</option>
											<option value="popup" <?php if($row->type == "popup"){ echo "selected"; }?>> Popup</option>
										</select>
									</div>
								</div>
								<div class="col-md-9 hidden" id="opt_popup_<?php echo $row->cey_marche_id; ?>">
									<div class="form-group">
										<label for="affiche_<?php echo $row->cey_marche_id; ?>">Activées l'affichage de tous les popup dans tout le processus : </label>
										<select id="affiche_<?php echo $row->cey_marche_id; ?>" class="form-control" style="text-align: center;">
											<option value="1" <?php if($row->active_popup_all == 1){ echo "selected"; } ?>> Oui</option>
											<option value="0" <?php if($row->active_popup_all == 0){ echo "selected"; }?>> Non</option>
										</select>
									</div>
								</div>
							</div>
							<br />
							
						
							<div class="row">
        						<div class="col-md-12">
									<textarea id='<?php echo $id_ck; ?>' class='form-control' rows='10' style='resize:none;'><?php echo ascii_to_entities($row->text_html) ;?></textarea>
																<?php  echo display_ckeditor($$id_ck); ?>
								</div>
							</div>
							
							<hr>
							
							<div class="row">
								<div class="col-md-12">
	        						<button class="btn btn-primary pull-right" style="margin-left:15px;" onclick="ajout_procs(<?php echo $row->parent_id; ?>, <?php echo $dern_ordre; ?>)">AJOUTER PROCESSUS <i class="fa fa-lg fa-arrow-right"></i></button>
	        						<a href="#ajout-bouton" data-toggle="modal"  style="margin-left:15px;" class="btn btn-info pull-right" onclick="nouveau_bouton(<?php echo $row->cey_marche_id; ?>);">AJOUTER BOUTON</a>
	        						<?php if($row->alias !="P1"){ ?>
	        						<a href="#supprimer-proc-<?php echo $row->cey_marche_id; ?>" data-toggle="modal" class="btn btn-danger pull-left" style="margin-right:15px;"><i class="fa fa-lg fa-arrow-left"></i> SUPPRIMER PROCESSUS</a>
	        						<?php } ?>
	        						<a href="#visu<?php echo $row->cey_marche_id; ?>" data-toggle="modal" class="btn btn-success pull-left">VISUALISER</a>
	        						<button class="btn btn-success pull-left" onclick="get_data_tab(<?php echo $row->cey_marche_id; ?>);" style="margin-left:15px;">VALIDER </button>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<?php
									if(!empty($lst_acts)){ 
										foreach ($lst_acts as $row_act): 
									?>
									<div class="row">
										<div class="col-md-3">
											<a href="#modif-bouton-<?php echo $row_act->cey_arret_id; ?>" data-toggle="modal"  style="margin-left:15px; margin-bottom:15px;" class="btn btn-success pull-right">MODIFIER BOUTON</a>
										</div>
										<div class="col-md-3">
											<a href="#suppr-bouton-<?php echo $row_act->cey_arret_id; ?>" data-toggle="modal"  style="margin-left:15px; margin-bottom:15px;" class="btn btn-danger pull-right">SUPPRIMER BOUTON</a>
		        						</div>
		        						<div class="col-md-6">
		        							<button class="btn btn-info pull-right" style="margin-left:15px;"><?php echo ascii_to_entities($row_act->libelle); ?></button>
	        							</div>
	        						</div>
	        						<?php 
	        							endforeach; 
	        						}
	        						?>
								</div>
							</div>

						</div>

						

						<a href="#edtion-procs" data-toggle="modal" id="edition_valid" class="hidden"></a>

						<!-- MODAL -->
						<div class="modal fade" id="edtion-procs">
							<div class="modal-dialog">
								<div class="modal-content">

									<!-- MODAL HEADER -->
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h3 class="modal-title">Edition</h3>
									</div>
									<!-- END MODAL HEADER -->

									<!-- MODAL BODY -->
									<div class="modal-body">
										<p class="astuce"><i class="fa fa-check"></i> Edition du processus bien terminer</p>
									</div>
									<!--  END MODAL BODY -->

									<!-- MODAL FOOTER -->
									<div class="modal-footer">
										<a href="<?php echo site_url('back/processus'); ?>" class="btn btn-block btn-success"> OK</a>
									</div>
									<!--  END MODAL FOOTER -->
								
								</div>
							</div> 
						</div>
						<!-- END MODAL -->



			
			







						
