<!-- MENU ACTION -->
<div id="menu" class="hidden-print hidden-xs">
	<div style="background-color:#E9F4F5!important; border-right : 1px solid white !important;" class="sidebar sidebar-inverse">
			
			<?php if(isset($nom_entre)){ ?>
			<div  style="margin-top:80px;" class="row">
				
				
					<div <?php if(isset($encours_entre) && $encours_entre=="ok"){ ?> class="encours_menu" <?php }else{ ?> class="active_menu" <?php } ?> style="cursor:pointer;">
							<p>
								<a href="<?php echo site_url('front/accueil'); ?>" ><?php echo ascii_to_entities($nom_entre); ?></a>
							</p>
					</div>
				
				
			</div>
			<?php } ?>
		
			<?php if(isset($nom_categorie)){ ?>
			<div  id="categorie" style="margin-left:22px;" class="row">
				
				<div <?php if(isset($encours_traits) && $encours_traits=="ok"){ ?> class="encours_menu" <?php }else{ ?> class="active_menu" <?php } ?>>
				
					<p style="position:relative;">
							<a href="<?php echo site_url('front/accueil_categories/'.$id_categorie); ?>"><?php echo ascii_to_entities($nom_categorie); ?></a>
							<img style="position:absolute; left:-28px; top:-38px; z-index:-1;"src="<?php echo img_url('sous_arbre.png');?>"/>
					</p>

				
				</div>		
			</div>
			<?php } ?>

			<?php if(isset($nom_traitement)){ ?>
			<div  id="traitement" style="margin-left:50px;" class="row">
				
				<div <?php if(isset($encours_ops) && $encours_ops=="ok"){ ?> class="encours_menu" <?php }else{ ?> class="active_menu" <?php } ?>>
				
					<p style="position:relative;">
							<a href="<?php echo site_url('front/accueil_traitement/'.$id_traitement); ?>"><?php echo ascii_to_entities($nom_traitement); ?></a>
							<img style="position:absolute; left:-28px; top:-38px; z-index:-1;"src="<?php echo img_url('sous_arbre.png');?>"/>
					</p>

				
				</div>		
			</div>
			<?php } ?>

			<?php if(isset($nom_operation)){ ?>
			<div id="operation" style="margin-left:80px;" class="row">
				<div <?php if(isset($encours_act) && $encours_act=="ok"){ ?> class="encours_menu" <?php }else{ ?> class="active_menu" <?php } ?>>
				
					<p style="position:relative">
							<a href="<?php echo site_url('front/accueil_operation/'.$id_operation); ?>"><?php echo ascii_to_entities($nom_operation); ?></a>
							<img style="position:absolute; left:-28px; top:-38px; z-index:-1;" src="<?php echo img_url('sous_arbre.png');?>"/>
					</p>
				
				</div>		
			</div>
			<?php } ?>
	
	</div>
</div>
<!-- END MENU ACTION -->