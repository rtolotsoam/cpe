		<!-- MODAL -->
		<div class="modal fade" id="modifier-user-<?php echo $id_user; ?>">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- MODAL HEADER -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Modifier Utilisateur</h3>
					</div>
					<!-- END MODAL HEADER -->

					<!-- MODAL BODY -->
					<div class="modal-body">
						<div class="innerAll">
							<p id="message_error_<?php echo $id_user; ?>"></p>

							<form class="margin-none innerLR inner-2x">	
								
								<div class="row">

									<div class="col-md-6">
										
										<p id="matricule_error_<?php echo $id_user; ?>"></p>

										<div class="form-group">
									    	<label for="matricule_<?php echo $id_user; ?>">Matricule</label>
									    	<input type="numeric" class="form-control" id="matricule_<?php echo $id_user; ?>" value="<?php echo $mle; ?>" placeholder="Entrer Matricule" />
									  	</div>

									  	<p id="prenom_error_<?php echo $id_user; ?>"></p>
									  	
									  	<div class="form-group">
									    	<label for="prenom_<?php echo $id_user; ?>"><?php echo ascii_to_entities("Prénom"); ?></label>
									    	<input type="text" class="form-control" id="prenom_<?php echo $id_user; ?>" value="<?php echo $pren; ?>" placeholder="Entrer Prénom" />
									  	</div>

									  	<p id="mail_error_<?php echo $id_user; ?>"></p>

									  	<div class="form-group">
									    	<label for="mail_<?php echo $id_user; ?>">Adresse E-mail</label>
									    	<input type="mail" class="form-control" id="mail_<?php echo $id_user; ?>" value="<?php echo $email; ?>" placeholder="Entrer E-mail" />
									  	</div>

									  	<p id="pass_error_<?php echo $id_user; ?>"></p>

										<div class="form-group">
									    	<label for="pass_<?php echo $id_user; ?>">Mot de passe</label>
									    	<input type="password" class="form-control" id="pass_<?php echo $id_user; ?>" value="<?php echo $pas; ?>" placeholder="Entrer Mot de passe" />
									  	</div>
								  	</div>

								  	<div class="col-md-6">

								  		<div class="form-group">
									    	<label for="level_<?php echo $id_user; ?>">Le type d'utilisateur</label>
									    	<select class="form-control" id="level_<?php echo $id_user; ?>" onchange="fonc_user_id(<?php echo $id_user; ?>);">
									    		<option value="user" <?php if($lev =="user"){ echo "selected"; } ?>>Utilisateur</option>
												<option value="admin" <?php if($lev =="admin"){ echo "selected"; } ?>>Admin</option>
											</select>
									  	</div>

									  	<div class="form-group">
									    	<label for="statut_<?php echo $id_user; ?>">Statut</label>
									    	<select class="form-control" id="statut_<?php echo $id_user; ?>">
									    		<option value="1" <?php if($stat =="1"){ echo "selected"; } ?>><?php echo ascii_to_entities("Activer"); ?></option>
												<option value="0" <?php if($stat =="0"){ echo "selected"; } ?>><?php echo ascii_to_entities("Désactiver"); ?></option>
											</select>
									  	</div>

									  	<p id="opt_error_<?php echo $id_user; ?>"></p>
									
									  	<div class="form-group hidden" id="op_access_1_<?php echo $id_user; ?>">
									    	<label for="access_1_<?php echo $id_user; ?>"><?php echo ascii_to_entities("Accès"); ?> Gestion des utilisateurs</label>
									    	<select class="form-control" id="access_1_<?php echo $id_user; ?>">
												<option value="1" <?php if($acc_user =="1"){ echo "selected"; } ?>><?php echo ascii_to_entities("Oui"); ?></option>
												<option value="0" <?php if($acc_user =="0"){ echo "selected"; } ?>><?php echo ascii_to_entities("Non"); ?></option>
											</select>
									  	</div>
									  	<div class="form-group hidden" id="op_access_2_<?php echo $id_user; ?>">
									    	<label for="access_2_<?php echo $id_user; ?>"><?php echo ascii_to_entities("Accès"); ?> Gestion des processus</label>
									    	<select class="form-control" id="access_2_<?php echo $id_user; ?>">
												<option value="1" <?php if($acc_process =="1"){ echo "selected"; } ?>><?php echo ascii_to_entities("Oui"); ?></option>
												<option value="0" <?php if($acc_process =="0"){ echo "selected"; } ?>><?php echo ascii_to_entities("Non"); ?></option>
											</select>
									  	</div>
								  	</div>

								</div>
							</form>
						</div>
					</div>
					<!--  END MODAL BODY -->

					<!-- MODAL FOOTER -->
					<div class="modal-footer">
						<button class="btn btn-block btn-info" onclick="modifier_user(<?php echo $id_user; ?>);">Modifier</button>
					</div>
					<!--  END MODAL FOOTER -->
				
				</div>
			</div> 
		</div>
		<!-- END MODAL -->


		<script>
		$(document).ready(function(){
			var obj = '#level_'+'<?php echo $id_user; ?>';
			var obj1 = '#op_access_1_'+'<?php echo $id_user; ?>';
			var obj2 = '#op_access_2_'+'<?php echo $id_user; ?>';

			var str = $(obj).val();

			console.log(str);

			if(str == 'admin'){
				$(obj1).removeClass('hidden');
				$(obj2).removeClass('hidden');
			}
			
		});
		</script>