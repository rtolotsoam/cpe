<div id="content"><h1 class="content-heading bg-white border-bottom hidden">OPERATION</h1> 
<div class="innerAll">

    	
<!-- CONTENT -->
<div style="margin-top:40px;" class="row">
	<div class="col-lg-1">
	</div>
	<div class="col-lg-10">
		<div class="row">
			<?php 
				if(!empty($operation)){
					foreach ($operation as $val_op) {
					
			?>
			
				<div class="col-lg-6 dashboard clearfix">
					
					<ul class="tiles">
					<?php 
					if($val_op->process_id == "0"){
					?>
					<div class="col1 clearfix">
					  <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
						<div><p><a href="<?php echo site_url('front/accueil_action/'.$val_op->cey_operation_id); ?>" class="titre_bouton"><?php echo ascii_to_entities($val_op->info_operation);?></a></p></div>
						
					  </li>
					</div>
					
						
					
					<?php 
					}else{


						$deb_proc  =  $deb[$val_op->cey_operation_id];

						if($deb_proc){

							foreach ($deb_proc as $val_first) {
					?>
					<div class="col1 clearfix">
					  <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
						<div><p><a href="#" onclick="traiter(<?php echo $val_op->process_id; ?> , <?php  echo $val_first->cey_marche_id;  ?>); return false;" class="titre_bouton"><?php echo ascii_to_entities($val_op->info_operation);?></a></p></div>
						
					  </li>
					</div>

						

					<?php 
							}
						}
					}
					?>					
					</ul>
				
				</div>
				
			<?php 
					}
				}
			?>
		</div>
	</div>
	
	<div class="col-lg-1">
	</div>
</div>
<!-- END CONTENT -->
		
		