	<!-- MODAL -->
	<div class="modal fade" id="supprimer-procs-<?php echo $id_proc; ?>">
		<div class="modal-dialog">
			<div class="modal-content">


				<!-- MODAL HEADER -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Supprimer processus</h3>
				</div>
				<!-- END MODAL HEADER -->
				
				<!-- MODAL BODY -->
				<div class="modal-body">
					<div class="innerAll">
						<p class="astuce"><img src="<?php echo img_url('attention.png'); ?>" alt="logo_attention" />&nbsp;Voulez-vous vraiment Supprimer le processus libelle : <span style="color:red;"><?php echo ascii_to_entities($libelle_proc); ?></span> ?</p><br />
						
						
						<?php 
							if($type_cat =='trait'){
						?>
								<p>Supprimer aussi catégorie 1 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="cat_<?php echo $id_proc; ?>" value="<?php echo $id_cat; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_cat); ?></i></strong>
					                </label>
								</div>		
						<?php
							}elseif ($type_cat =='op') {
						?>		
								<p>Supprimer aussi catégorie 1 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="cat_<?php echo $id_proc; ?>" value="<?php echo $id_cat; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_cat); ?></i></strong>
					                </label>
								</div>
								<p>Supprimer aussi catégorie 2 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="trait_<?php echo $id_proc; ?>" value="<?php echo $id_trait; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_trait); ?></i></strong>
					                </label>
								</div>		
						<?php		
							}elseif ($type_cat =='act') {
						?>
								<p>Supprimer aussi catégorie 1 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="cat_<?php echo $id_proc; ?>" value="<?php echo $id_cat; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_cat); ?></i></strong>
					                </label>
								</div>
								<p>Supprimer aussi catégorie 2 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="trait_<?php echo $id_proc; ?>" value="<?php echo $id_trait; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_trait); ?></i></strong>
					                </label>
								</div>
								<p>Supprimer aussi catégorie 3 :</p>
								<div class="checkbox">
					                <label class="checkbox">
					                    <input type="checkbox" class="checkbox" id="op_<?php echo $id_proc; ?>" value="<?php echo $id_op; ?>" /> <strong><i><?php echo ascii_to_entities($libelle_op); ?></i></strong>
					                </label>
								</div>


						<?php
							}
						?>
						
					</div>
				</div>
				<!--  END MODAL BODY -->

				<!-- MODAL FOOTER -->
				<div class="modal-footer">
					<button class="btn btn-block btn-info" onclick="supprimer_procs(<?php echo $id_proc; ?>, <?php echo "'".$type_cat."'"; ?>);">Supprimer</button>
				</div>
				<!--  END MODAL FOOTER -->
			
			</div>
		</div> 
	</div>
	<!-- END MODAL -->