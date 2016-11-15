	<?php 
		foreach ($lst_hod as $val_hod) {
			$image = $val_hod->image_hod;			
			$id = $val_hod->cey_hod_id;				
			$libelle = ascii_to_entities($val_hod->libelle_hod);				
		}
	?>

	<!-- MODAL -->
	<div class="modal fade" id="hod<?php echo $id; ?>">
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
						<div>
							<img src="<?php echo $image; ?>" class="img-responsive"/>
						</div>
					</div>
				</div>
				<!--  END MODAL BODY -->
			
			</div>
		</div> 
	</div>
	<!-- END MODAL -->