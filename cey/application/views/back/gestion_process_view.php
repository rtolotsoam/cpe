
<div id="content">
	<h1 class="content-heading bg-white border-bottom">
		
		<div class="row">
			<div class="col-md-2"> 
				<a href="#ajout-processus" data-toggle="modal" class="btn btn-success">AJOUTER PROCESSUS</a>
			</div>
			<div class="col-md-2">
				<i id="spin" style="display:none;position:relative; left: 80px;" class="fa fa-spinner fa-spin"></i>
			</div>
			<div class="col-md-4"> 
					
					<label for="entre">Choisir la <?php echo ascii_to_entities("catégorie"); ?>: </label>

			    	<select id="entre" onchange="charge_entres();">
			    		<?php 

			    		if(!empty($lst_entre) && isset($id_entre)){

			    			foreach ($lst_entre as $val_select) {
			    		?>

						<option value="<?php echo $val_select->cey_entre_id; ?>" <?php if($id_entre==$val_select->cey_entre_id) echo "selected"; ?>><?php echo ascii_to_entities($val_select->libelle); ?></option>
						
						<?php
							}
						} 

						?>
					</select>
			</div>

			<div class="col-md-4"> 
					
					<label for="canal">Choisir le type de traitement: </label>

			    	<select id="canal" onchange="charge_entres();">
			    		<?php 
			    		

			    		if(isset($canal)){

			    			
			    		?>

							<option value="tel" <?php if($canal=="tel") echo "selected"; ?>><?php echo ascii_to_entities("Par Téléphone"); ?></option>
							<option value="mail" <?php if($canal=="mail") echo "selected"; ?>><?php echo ascii_to_entities("Par E-mail"); ?></option>
							<option value="courrier" <?php if($canal=="courrier") echo "selected"; ?>><?php echo ascii_to_entities("Par Courrier"); ?></option>
						
						<?php
							}
						
						?>
					</select>
					
			</div>
		</div>

	</h1> 
<div class="innerAll spacing-x2">

		<div class="widget widget-inverse corp-info" >
			<div class="widget-body padding-bottom-none">

				<!-- Table -->
				<table class="dynamicTable colVis table">
					
					<!-- Table heading -->
					<thead class="bg-gray">
						<tr>
							<th>Numero</th>
							<th>Libelle</th>
								<?php /*?><th class="center">Cheminement</th><?php */?>
							<th class="center">Processus</th>
							<th class="center">Supprimer</th>
						</tr>
					</thead>
					<!-- // Table heading END -->

					<!-- Table body -->
					<tbody>
						<?php 
						 if(!empty($data_table)){

						 	$i=1;
							foreach ($data_table as $val_table) {
							
							
						?>

								<!-- Table row -->
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo ascii_to_entities($val_table->libelle); ?></td>
									<?php /* ?>
									<td class="center">
										<li class="style_li">
											<a href="#" data-toggle="modal" class="btn btn-success"><i class="fa fa-pencil"></i> Modifier</a>
										</li>
									</td>
									<?php */?>
									<td class="center">
										<li class="style_li">
											<a href="#" onclick="traiter(<?php echo $val_table->process_id; ?>, <?php echo $data_deb[$val_table->process_id]; ?>); return false;" class="btn btn-info"><i class="fa fa-eye"></i> Visualiser</a>
											<a href="#" onclick="editer(<?php echo $val_table->process_id; ?>); return false;" class="btn btn-success"><i class="fa fa-pencil"></i> Modifier</a>
										</li>
									</td>
									<td class="center">
										<li class="style_li">
											<a href="#supprimer-procs-<?php echo $val_table->process_id; ?>" data-toggle="modal" class="btn btn-danger"><i class="fa fa-times"></i></a>
										</li>
									</td>
								</tr>
								<!-- // Table row END -->
						
						<?php 
								$i++;
							}
						}
						?>

					</tbody>
					<!-- // Table body END -->
						
				</table>
				<!-- // Table END -->

			</div>	
		</div>		
	



	
		
		
		