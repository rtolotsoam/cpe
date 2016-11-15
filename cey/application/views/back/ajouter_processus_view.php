<!-- MODAL -->
	<div class="modal fade" id="ajout-processus">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- MODAL HEADER -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Ajouter Processus</h3>
				</div>
				<!-- END MODAL HEADER -->

				<!-- MODAL BODY -->
				<div class="modal-body">
					<div class="innerAll">
						<p id="message_error"></p>
						<form class="margin-none innerLR inner-2x">
							<div class="row">
								<div class="col-md-<?php if(!empty($lst_categorie) && $lst_categorie){echo "6"; }else{ echo "6"; }?>">

									<div class="form-group">
								    	<label for="libelle_proc">Libelle processus</label>
								    	<input type="text" class="form-control" id="libelle_proc" placeholder="Entrer Libelle processus" />
								  		<p id="libelle_error"></p>
								  	</div>

								  	<div class="form-group">
								    	<label for="canal_tel">Par <?php echo ascii_to_entities("Téléphone"); ?></label>
								    	<select class="form-control" id="canal_tel">
												<option value="1">Oui</option>
												<option value="0">Non</option>
										</select>
								  	</div>

								  	<div class="form-group">
								    	<label for="canal_mail">Par <?php echo ascii_to_entities("E-mail"); ?></label>
								    	<select class="form-control" id="canal_mail">
												<option value="1">Oui</option>
												<option value="0">Non</option>
										</select>
								  	</div>

								  	<div class="form-group">
								    	<label for="canal_courrier">Par <?php echo ascii_to_entities("Courrier"); ?></label>
								    	<select class="form-control" id="canal_courrier">
												<option value="1">Oui</option>
												<option value="0">Non</option>
										</select>
								  	</div>
								 
								</div> 	

							  	<div class="col-md-<?php if(!empty($lst_categorie) && $lst_categorie){ echo "6"; }else{ echo "0 hidden"; } ?>">
								  	
								  	<div class="form-group" id="option_cat">
								    	<label for="choix_cat">Liste <?php echo ascii_to_entities("Catégorie 1"); ?></label>
								    	<select class="form-control" id="choix_cat" onclick="affiche_btn_trait();">
								    		<?php
								    		foreach ($lst_categorie as $val_cat) {
								    		?>
												<option value="<?php echo ascii_to_entities($val_cat->cey_categorie_id); ?>"><?php echo ascii_to_entities($val_cat->info_categorie); ?></option>

											<?php
											}
								    		?>
										</select>
								  	</div>


								  	<div class="form-group" id="btn_trait">
								  		<a href="#" onclick="charge_cheminement_cat(); return false;">Continuer</a>| |<a href="#" onclick="charge_champs_trait(); return false;">Nouveau</a>
								  	</div>

								  	<p id="option_trait_error"></p>

								  	<div class="form-group hidden" id="option_trait">
								    	<label for="choix_trait">Liste <?php echo ascii_to_entities("Catégorie 2"); ?></label>
								    	<select class="form-control" id="choix_trait" onclick="affiche_btn_op();">
								  			
										</select>
								  	</div>

								  	<div class="form-group hidden" id="btn_op">
								  		<a href="#" onclick="charge_cheminement_trait(); return false;">Continuer</a>| |<a href="#" onclick="charge_champs_op(); return false;">Nouveau</a>
								  	</div>


								  	<div class="form-group hidden" id="fin_trait">
								  		<div class="alert-info center">Fin traitement</div>
								  	</div>

								  	<p id="option_op_error"></p>

								  	<div class="form-group hidden" id="option_op">
								    	<label for="choix_op">Liste <?php echo ascii_to_entities("Catégorie 3"); ?></label>
								    	<select class="form-control" id="choix_op" onclick="affiche_btn_act();">
								  			
										</select>
								  	</div>

								  	<div class="form-group hidden" id="btn_act">
								  		<a href="#" onclick="charge_cheminement_op(); return false;">Continuer</a>| |<a href="#" onclick="charge_champs_act(); return false;">Nouveau</a>
								  	</div>



								  	<div class="form-group hidden" id="fin_op">
								  		<div class="alert-info center">Fin traitement</div>
								  	</div>


								  	<div class="form-group hidden" id="option_act">
								    	<label for="choix_act">Liste <?php echo ascii_to_entities("Catégorie 4"); ?></label>
								    	<select class="form-control" id="choix_act">
								  			
										</select>
								  	</div>


								  	<div class="form-group hidden" id="nouveau_trait">
								    	<label for="nouveau_libelle_trait">Nouveau <?php echo ascii_to_entities("Catégorie 1"); ?> </label>
								    	<input type="text" class="form-control" id="nouveau_libelle_trait" placeholder="Entrer Nouveau Categorie 1" />
								    	<p id="libelle_trait_error"></p>
								  	</div>


								  	<div class="form-group hidden" id="nouveau_op">
								    	<label for="nouveau_libelle_op">Nouveau <?php echo ascii_to_entities("Catégorie 2"); ?> </label>
								    	<input type="text" class="form-control" id="nouveau_libelle_op" placeholder="Entrer Nouveau Categorie 2" />
								    	<p id="libelle_op_error"></p>
								  	</div>


								  	<div class="form-group hidden" id="nouveau_act">
								    	<label for="nouveau_libelle_act">Nouveau <?php echo ascii_to_entities("Catégorie 3"); ?> </label>
								    	<input type="text" class="form-control" id="nouveau_libelle_act" placeholder="Entrer Nouveau Categorie 3" />
								    	<p id="libelle_act_error"></p>
								  	</div>


								  	

								</div>

								<div class="col-md-<?php if(!empty($lst_categorie) && $lst_categorie){echo "0 hidden"; }else{ echo "6"; }?>" id="nouveau_champs">

									<div class="form-group">
								    	<label for="libelle_cat">Nouveau <?php echo ascii_to_entities("Catégorie 1"); ?> </label>
								    	<input type="text" class="form-control" id="libelle_cat" placeholder="Entrer catégorie 1" />
								    	<p id="libelle_nouv_cat_error"></p>
								  	</div>

								  	<div class="form-group">
								    	<label for="libelle_trait">Nouveau <?php echo ascii_to_entities("Catégorie 2"); ?> </label>
								    	<input type="text" class="form-control" id="libelle_trait" placeholder="Entrer catégorie 2" />
								    	<p id="libelle_nouv_trait_error"></p>
								  	</div>

								  	<div class="form-group">
								    	<label for="libelle_op">Nouveau <?php echo ascii_to_entities("Catégorie 3"); ?> </label>
								    	<input type="text" class="form-control" id="libelle_op" placeholder="Entrer catégorie 3" />
								    	<p id="libelle_nouv_op_error"></p>
								  	</div>


								</div>

							</div>	
						</form>
					</div>
				</div>
				<!--  END MODAL BODY -->

				<!-- MODAL FOOTER -->
				<div class="modal-footer">
					<button class="btn btn-block btn-info" id="bouton_ajout_procs" onclick="ajout_processus()">Ajouter</button>
				</div>
				<!--  END MODAL FOOTER -->
			
			</div>
		</div> 
	</div>
	<!-- END MODAL -->
