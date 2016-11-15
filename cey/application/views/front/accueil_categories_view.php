<div id="content"><h1 class="content-heading bg-white border-bottom hidden">CATEGORIES</h1> 
<div class="innerAll">

    	
<!-- CONTENT -->
<div style="margin-top:40px;"class="row">
	<div class="col-lg-1">
	</div>	
	<div class="col-lg-10">	
		<div class="row">
			
		
			<?php 
				if(!empty($categories)){
					foreach ($categories as $val_cat) {
						
			?>
			
				
							<div class="col-lg-6 dashboard clearfix">
								<ul class="tiles">
								

									<div class="col1 clearfix">
									  <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
										<div><p><a href="<?php echo site_url('front/accueil_traitement/'.$val_cat->cey_categorie_id) ?>" class="titre_bouton"><?php echo ascii_to_entities($val_cat->info_categorie);?></a></p></div>
										
									  </li>
									</div>

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
		
		