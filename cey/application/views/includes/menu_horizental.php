<!-- MENU ACTION -->
<div id="menu" class="hidden-print hidden-xs">
	<div class="sidebar sidebar-inverse">
		<div class="user-profile media innerAll">
			<div class="media-body">
				<p style="color:white; font-size:15px; font-weight: bold;">
				<?php 
				if($level == "user"){ 
				?>	
					<?php if($type_proc =="action"){ ?>
					<a href="<?php echo site_url('front/accueil_action/'.$id_action); ?>">
					<?php 
						echo ascii_to_entities($libelle_procs);
					?>
					</a>
					<?php } ?>
					<?php if($type_proc =="operation"){ ?>
					<a href="<?php echo site_url('front/accueil_operation/'.$id_operation); ?>">
					<?php 
						echo ascii_to_entities($libelle_procs);
					?>
					</a>
					<?php } ?>
					<?php if($type_proc =="traitement"){ ?>
					<a href="<?php echo site_url('front/accueil_traitement/'.$id_traitement); ?>">
					<?php 
						echo ascii_to_entities($libelle_procs);
					?>
					</a>
					<?php } 
				}else{
					?>
					<a href="<?php echo site_url('back/gestion_process/normal'); ?>">
						<?php 
						echo ascii_to_entities($libelle_procs);
					?>
					</a>
				<?php 
				}
				?>	
				</p>
			</div>
		</div>
		<?php if($titre != "ACCUEIL"){ ?>
		<div class="sidebarMenuWrapper">
			<ul class="list-unstyled" id="activities">
				<?php
					$i_tab = 0;
					foreach ($lst_proc as $val_proc) {
						$i_tab += 1;
						$pr_act = $lst_act[$val_proc->cey_marche_id];
				?>
					<li><a href="#tab<?php echo $val_proc->cey_marche_id; ?>" data-toggle="tab" id="lien<?php echo $val_proc->cey_marche_id; ?>"><i class="fa fa-caret-square-o-right"></i><?php echo ascii_to_entities($val_proc->libelle);?></a></li>
				<?php 
					}
				?>
			</ul>	
		</div>
		<?php } ?>
	</div>
</div>
<!-- END MENU ACTION -->
