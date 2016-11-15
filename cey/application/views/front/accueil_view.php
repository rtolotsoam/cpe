<div id="content"><h1 class="content-heading bg-white border-bottom hidden">ACCUEIL</h1> 
<div class="innerAll">

    	
<!-- CONTENT -->
<div style="margin-top:80px;"class="row">

		<div class="row">
			<?php 
				if(!empty($entres)){
					foreach ($entres as $val_entr) {
			?>
			
			<div class="col-lg-6  dashboard clearfix">
				<ul class="tiles">
			   
		 			<span style="position:absolute; z-index:10000; font-size:4.5rem; top:-10px;left:20px;"><?php echo $val_entr->cey_entre_id;?></span>
		
		  				<a style="text-decoration:none!important; font-size:5rem;" id="ico" style="font-size:6em;"class=" 
		  <?php echo $val_entr->icon;
		  
		  				?>"></a>
				
					<div class="col1 clearfix">
					  <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
						<div><p><a id="nombre" href="<?php echo site_url('front/accueil_categories/'.$val_entr->cey_entre_id); ?>" class="titre_bouton"><?php echo ascii_to_entities($val_entr->libelle);?></a></p></div>
						
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
<!-- END CONTENT -->