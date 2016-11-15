function ajout_user()
{
	var matricule = document.getElementById('matricule').value;
	var prenom = document.getElementById('prenom').value;
	var mail = document.getElementById('mail').value;
	var pass = document.getElementById('pass').value;
	var confpass = document.getElementById('confpass').value;

	var level = document.getElementById('level').value;
	var statut = document.getElementById('statut').value;
	var access_1 = document.getElementById('access_1').value;
	var access_2 = document.getElementById('access_2').value;

	if((typeof matricule != null && matricule != '') && (typeof prenom != null && prenom != '') && (typeof pass != null && pass != '') && (typeof confpass != null && confpass != '')){
		
		if(pass == confpass){

			if(level == "admin" && access_1 == '0' && access_2 == '0'){

				$('#opt_error').html('<div class="alert alert-danger" align="center">Veuillez mettre "oui", l\'un des accès de gestion ci-dessous !</div>');		
			
			}else{

				// DONNEES DU FORMULAIRE AJOUT UTILISATEUR
				if(level == "user"){

					var form_data = {

						matricule : matricule,
						prenom : prenom,
						mail : mail,
						pass : pass,
						confpass : confpass,
						level : level,
						statut : statut,
						access_1 : 0,
						access_2 : 0,
						ajax : '1'
					};

				}else{

					var form_data = {

						matricule : matricule,
						prenom : prenom,
						mail : mail,
						pass : pass,
						confpass : confpass,
						level : level,
						statut : statut,
						access_1 : access_1,
						access_2 : access_2,
						ajax : '1'
					};
				}
				
				// TRAITEMENT AJAX DU FORMULAIRE AJOUT UTILISATEUR
				$.ajax({
					url: url_ajout_user,
					type: 'POST',
					data: form_data,
					success: function(data) {

						
						// TRAITEMENT DES ERREURS
						if(data == 'erreur'){
							
							$('#message_error').html('<div class="alert alert-danger" align="center">Veillez réessayer ulterieurement !</div>');

							$('#matricule_error').html('');
							$('#prenom_error').html('');
							$('#pass_error').html('');
							$('#pass_error').html('');

						}else if(data == 'success'){

							window.location.href = url_ajout_user_ok;
						}else{

							var str = data;
							var res = str.split(";");

							$('#matricule_error').html(res[0]);
							$('#prenom_error').html(res[1]);
							$('#pass_error').html(res[2]);
							$('#pass_error').html(res[3]);

							$('#message_error').html('');
				
						}


					}
				});

				return true;
			}


		}else{
			$('#pass_error').html('<div class="alert alert-danger" align="center">Le mot de passe et son confirmation ne correspond pas !</div>');		
		}
		
	}else{
		$('#message_error').html('<div class="alert alert-danger" align="center">Les champs sont obligatoires !</div>');		
	}
}


function supprimer_user(id){

	var btn_data = {
		id_user : id
	};

	$.ajax({
		url: url_suppr_user,
		type: 'POST',
		data: btn_data,
		success: function(data) {
			window.location.href = data;
		}
	});
	
	return true;

}


function modifier_user(id){

	var matricule = document.getElementById('matricule_'+id).value;
	var prenom = document.getElementById('prenom_'+id).value;
	var mail = document.getElementById('mail_'+id).value;
	var pass = document.getElementById('pass_'+id).value;

	var level = document.getElementById('level_'+id).value;
	var statut = document.getElementById('statut_'+id).value;
	var access_1 = document.getElementById('access_1_'+id).value;
	var access_2 = document.getElementById('access_2_'+id).value;

	var opt = '#opt_error_'+id;

	if((typeof matricule != null && matricule != '') && (typeof prenom != null && prenom != '') && (typeof pass != null && pass != '')){
		

		if(level == "admin" && access_1 == '0' && access_2 == '0'){

				$(opt).html('<div class="alert alert-danger" align="center">Veuillez mettre "oui", l\'un des accès de gestion ci-dessous !</div>');		
			
		}else{
				// DONNEES DU FORMULAIRE AJOUT UTILISATEUR
				var form_data = {

					matricule : matricule,
					prenom : prenom,
					mail : mail,
					pass : pass,
					level : level,
					statut : statut,
					access_1 : access_1,
					access_2 : access_2,
					id_user : id,
					ajax : '1'
				};
				
				// TRAITEMENT AJAX DU FORMULAIRE AJOUT UTILISATEUR
				$.ajax({
					url: url_modif_user,
					type: 'POST',
					data: form_data,
					success: function(data) {

						
						// TRAITEMENT DES ERREURS
						if(data == 'erreur'){
							
							$('#message_error_'+id).html('<div class="alert alert-danger" align="center">Veillez réessayer ulterieurement !</div>');
							

						}else if(data == 'success'){

							window.location.href = url_ajout_user_ok;
						
						}else{

							var str = data;
							var res = str.split(";");

							$('#matricule_error_'+id).html(res[0]);
							$('#prenom_error_'+id).html(res[1]);
							$('#pass_error_'+id).html(res[2]);

							$('#message_error_'+id).html('');
				
						}


					}
				});

				return true;
			}

		
	}else{
		$('#message_error_'+id).html('<div class="alert alert-danger" align="center">Les champs sont obligatoires !</div>');		
	}
}


function fonc_user(){
	var fonc = document.getElementById('level').value;

	console.log(fonc);

	if(fonc == 'admin'){
		$('#op_access_1').removeClass('hidden');
		$('#op_access_2').removeClass('hidden');
	}else{
		$('#op_access_1').addClass('hidden');
		$('#op_access_2').addClass('hidden');
	}


}



function fonc_user_id(id){
	var obj = 'level_'+id;
	var odj1 = '#op_access_1_'+id;
	var odj2 = '#op_access_2_'+id;

	var fonc = document.getElementById(obj).value;

	console.log(fonc);

	if(fonc == 'admin'){
		$(odj1).removeClass('hidden');
		$(odj2).removeClass('hidden');
	}else{
		$(odj1).addClass('hidden');
		$(odj2).addClass('hidden');
	}


}


function modifier_user_profil(id){

	var nouvpass = $('#nouvpass').val();
	var confnouvpass = $('#confnouvpass').val();
	var prenom = $('#prenom').val();
	var mail = $('#mail').val();
	var matricule = $('#matricule').val();
	var pass = $('#pass').val();

	if(nouvpass == '' && confnouvpass == ''){
		
		if(typeof mail != null && mail !=''){
			// DONNEES DU FORMULAIRE MODIFIER PROFIL
			var form_data = {
				prenom : prenom,
				matricule : matricule,
				mail : mail,
				pass : pass,
				id_user : id,
				modif : 'mail_renseigne',
				ajax : '1'
			};

		}else{

			$('#message_error').html('');

			$('#prenom_error').html('');
			$('#mail_error').html('<div class="alert alert-info" align="center">Veuillez renseigner votre adresse E-mail, si vous souhaitiez !</div>');
			$('#modif_pass_error').html('');

		}

	}else{

		if( nouvpass == confnouvpass){

			if(typeof mail != null && mail !=''){

				// DONNEES DU FORMULAIRE MODIFIER PROFIL
				var form_data = {
					prenom : prenom,
					matricule : matricule,
					mail : mail,
					pass : nouvpass,
					id_user : id,
					modif : 'modif_pass_mail',
					ajax : '1'
				};

			}else{

				// DONNEES DU FORMULAIRE MODIFIER PROFIL
				var form_data = {
					prenom : prenom,
					matricule : matricule,
					mail : '',
					pass : nouvpass,
					id_user : id,
					modif : 'modif_pass',
					ajax : '1'
				};
			}

		}else{

			$('#message_error').html('');

			$('#prenom_error').html('');
			$('#mail_error').html('');
			$('#modif_pass_error').html('<div class="alert alert-danger" align="center">Le nouveau mot de passe et son confirmation ne correspond pas !</div>');
		}
	}

	
	if(typeof form_data != 'undefined'){

		$.ajax({
			url: url_modif_user_profil,
			type: 'POST',
			data: form_data,
			success: function(data) {

				
				// TRAITEMENT DES ERREURS
				if(data == 'erreur'){
					
					$('#message_error').html('<div class="alert alert-danger" align="center">Veillez réessayer ulterieurement !</div>');
					

				}else if(data == 'success'){

					window.location.href = url_accueil;

				}else if(data == 'erreur-mail'){
					
					$('#prenom_error').html('');
					$('#mail_error').html('<div class="alert alert-danger" align="center">Veillez vérifier votre adresse E-mail ! </div>');
					$('#modif_pass_error').html('');

					$('#message_error').html('');

				}else{

					var str = data;
					var res = str.split("|||");

					$('#prenom_error').html(res[0]);
					$('#mail_error').html(res[1]);
					$('#modif_pass_error').html(res[2]);

					$('#message_error').html('');
		
				}


			}
		});

		return true;
	}

}