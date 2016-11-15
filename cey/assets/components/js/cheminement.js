function charge_cheminement_cat()
{
	var id_cat = document.getElementById('choix_cat').value;


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	if(typeof id_cat != null && id_cat != ''){

		var btn_data = {
			id_categorie : id_cat,
			ajax : '1'
		};

		document.getElementById('btn_trait').classList.add('hidden');

		document.getElementById('btn_op').classList.remove('hidden');
		
		$.ajax({
			url: cheminement_cat,
			type: 'POST',
			data: btn_data,
			success: function(data) {

				
					var str = data;
					var res = str.split("|||");

					var long = res.length-1;


					if(long > 0){


						if (!$('#nouveau_trait').hasClass('hidden')){
				        	document.getElementById('nouveau_trait').classList.add('hidden');
					    }

					    if (!$('#nouveau_op').hasClass('hidden')){
				        	document.getElementById('nouveau_op').classList.add('hidden');
					    }

					    if (!$('#nouveau_act').hasClass('hidden')){
				        	document.getElementById('nouveau_act').classList.add('hidden');
					    }


						document.getElementById('option_trait').classList.remove('hidden');


						$('#choix_trait').empty();


						for (var i = 0; i < long; i++) {

							
							var str1 = res[i];
							var res1 = str1.split("||");

							s_pattern = "<option value=\"" + res1[0] +"||"+ res1[2] +"\">"+ res1[1]+"</option>";
							$("#choix_trait").append(s_pattern);

						}

						//charge_cheminement_trait();



					}else{



						if (!$('#option_trait').hasClass('hidden')){
				        	document.getElementById('option_trait').classList.add('hidden');
					    }

					    if (!$('#option_op').hasClass('hidden')){
				        	document.getElementById('option_op').classList.add('hidden');
					    }

					    if (!$('#option_act').hasClass('hidden')){
				        	document.getElementById('option_act').classList.add('hidden');
					    }

					    document.getElementById('btn_trait').classList.add('hidden');
					    document.getElementById('btn_op').classList.add('hidden');
					    document.getElementById('btn_act').classList.add('hidden');

				        document.getElementById('nouveau_op').classList.remove('hidden');
				        document.getElementById('nouveau_act').classList.remove('hidden');
							
					    
					}

			}

		});
		
		return true;

	}
}


function charge_cheminement_trait(){
	
	var data = document.getElementById('choix_trait').value;


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	//console.log(data);

	var str = data.split('||');

	var id_trait = str[0];
	var id_pro = str[1];

	document.getElementById('btn_trait').classList.add('hidden');

	document.getElementById('option_op').classList.remove('hidden');

	document.getElementById('fin_trait').classList.add('hidden');

	if(typeof id_trait != null && id_trait != '' && id_pro ==0){
		
		//console.log('zero');
		
		var btn_data = {
			id_traitement : id_trait,
			ajax : '1'
		};	

		$.ajax({
		url: cheminement_op,
		type: 'POST',
		data: btn_data,
		success: function(data) {
			
				var str = data;
				var res = str.split("|||");

				var long = res.length-1;


				if(long > 0){

				    if (!$('#nouveau_op').hasClass('hidden')){
			        	document.getElementById('nouveau_op').classList.add('hidden');
				    }

				    if (!$('#nouveau_act').hasClass('hidden')){
			        	document.getElementById('nouveau_act').classList.add('hidden');
				    }

				    document.getElementById('btn_op').classList.add('hidden');
				    document.getElementById('btn_act').classList.remove('hidden');

					$('#choix_op').empty();


					for (var i = 0; i < long; i++) {

						
						var str1 = res[i];
						var res1 = str1.split("||");

						s_pattern = "<option value=\"" + res1[0] +"||"+ res1[2] +"\">"+ res1[1]+"</option>";
						$("#choix_op").append(s_pattern);

					}

					//charge_cheminement_op();
					

				}else{

					if (!$('#option_op').hasClass('hidden')){
			        	document.getElementById('option_op').classList.add('hidden');
				    }

			    	document.getElementById('btn_trait').classList.add('hidden');
				    document.getElementById('btn_op').classList.add('hidden');
				    document.getElementById('btn_act').classList.add('hidden');

			        //document.getElementById('nouveau_op').classList.remove('hidden');
			        document.getElementById('nouveau_act').classList.remove('hidden');
						
				    
				}

			}

		});
	
		return true;
	
	}else{

		document.getElementById('fin_trait').classList.remove('hidden');		

		$('#choix_op').empty();

		document.getElementById('option_op').classList.add('hidden');

		document.getElementById('option_act').classList.add('hidden');

		//console.log('dif_zero');
	}

}


function charge_cheminement_op(){

	var data = document.getElementById('choix_op').value;


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	//console.log(data);

	var str = data.split('||');

	var id_op = str[0];
	var id_pro = str[1];

	document.getElementById('fin_op').classList.add('hidden');


	if(typeof id_op != null && id_op != '' && id_pro ==0){

		var btn_data = {
			id_operation : id_op,
			ajax : '1'
		};

		$.ajax({
		url: cheminement_act,
		type: 'POST',
		data: btn_data,
		success: function(data) {
			
				var str = data;
				var res = str.split("|||");

				var long = res.length-1;


				if(long > 0){


				    if (!$('#nouveau_act').hasClass('hidden')){
			        	document.getElementById('nouveau_act').classList.add('hidden');
				    }

				    document.getElementById('btn_act').classList.add('hidden');

					document.getElementById('option_act').classList.remove('hidden');

					$('#choix_act').empty();


					for (var i = 0; i < long; i++) {

						
						var str1 = res[i];
						var res1 = str1.split("||");

						s_pattern = "<option value=\"" + res1[0] +"||"+ res1[2] +"\">"+ res1[1]+"</option>";
						$("#choix_act").append(s_pattern);

					}

				}else{

					document.getElementById('btn_trait').classList.add('hidden');
				    document.getElementById('btn_op').classList.add('hidden');
				    document.getElementById('btn_act').classList.add('hidden');

			       // document.getElementById('nouveau_act').classList.remove('hidden');
						
				    
				}

			}

		});
	
		return true;


	}else{

		document.getElementById('fin_op').classList.remove('hidden');

		document.getElementById('option_act').classList.add('hidden');
		
	}

}

function charge_champs_trait(){


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_trait').classList.add('hidden');
    document.getElementById('nouveau_trait').classList.remove('hidden');
    document.getElementById('nouveau_op').classList.remove('hidden');
    document.getElementById('nouveau_act').classList.remove('hidden');	
    document.getElementById('fin_trait').classList.add('hidden');
    document.getElementById('fin_op').classList.add('hidden');

}




function affiche_btn_trait(){


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_trait').classList.remove('hidden');
    document.getElementById('nouveau_trait').classList.add('hidden');
    document.getElementById('nouveau_op').classList.add('hidden');
    document.getElementById('nouveau_act').classList.add('hidden');
    document.getElementById('option_trait').classList.add('hidden');
    document.getElementById('option_op').classList.add('hidden');
    document.getElementById('option_act').classList.add('hidden');
    document.getElementById('btn_op').classList.add('hidden');
    document.getElementById('btn_act').classList.add('hidden');
    document.getElementById('fin_trait').classList.add('hidden');
    document.getElementById('fin_op').classList.add('hidden');

}


function charge_champs_op(){


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_op').classList.add('hidden');
    document.getElementById('nouveau_op').classList.remove('hidden');
    document.getElementById('nouveau_act').classList.remove('hidden');	
    document.getElementById('fin_trait').classList.add('hidden');
    document.getElementById('fin_op').classList.add('hidden');

}


function affiche_btn_op(){


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_op').classList.remove('hidden');
    document.getElementById('nouveau_op').classList.add('hidden');
    document.getElementById('nouveau_act').classList.add('hidden');
    document.getElementById('option_op').classList.add('hidden');
    document.getElementById('option_act').classList.add('hidden');
	document.getElementById('btn_act').classList.add('hidden');
	document.getElementById('btn_trait').classList.add('hidden');
	document.getElementById('fin_trait').classList.add('hidden');
	document.getElementById('fin_op').classList.add('hidden');

}


function charge_champs_act(){


	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_act').classList.add('hidden');
    document.getElementById('nouveau_act').classList.remove('hidden');	
    document.getElementById('option_act').classList.add('hidden');
    document.getElementById('fin_trait').classList.add('hidden');
    document.getElementById('fin_op').classList.add('hidden');

}


function affiche_btn_act(){

	$('#message_error').empty();
	$('#option_trait_error').empty();
	$('#option_op_error').empty();
	$("#message_error").append('');

	document.getElementById('btn_act').classList.remove('hidden');
    document.getElementById('nouveau_act').classList.add('hidden');
    document.getElementById('option_act').classList.add('hidden');
	document.getElementById('btn_op').classList.add('hidden');
	document.getElementById('btn_trait').classList.add('hidden');
	document.getElementById('fin_trait').classList.add('hidden');
	document.getElementById('fin_op').classList.add('hidden');

}


function ajout_processus () 
{
	var libelle_proc = document.getElementById('libelle_proc').value;

	var nouveau_libelle_trait = document.getElementById('nouveau_libelle_trait').value;
	var nouveau_libelle_op = document.getElementById('nouveau_libelle_op').value;
	var nouveau_libelle_act = document.getElementById('nouveau_libelle_act').value;

	var libelle_cat = document.getElementById('libelle_cat').value;
	var libelle_trait = document.getElementById('libelle_trait').value;
	var libelle_op = document.getElementById('libelle_op').value;


	var canal_tel = document.getElementById('canal_tel').value;
	var canal_mail = document.getElementById('canal_mail').value;
	var canal_courrier = document.getElementById('canal_courrier').value;


	var url_add_proc = url_proc_ajout;

	

	if(typeof libelle_proc != null && libelle_proc !=''){

		$('#message_error').empty();
		$("#message_error").append('');
		
		//console.log("plein");

		if (!$('#nouveau_trait').hasClass('hidden') && !$('#nouveau_op').hasClass('hidden') && !$('#nouveau_act').hasClass('hidden')){

      		console.log("3");

      		if(typeof nouveau_libelle_trait != null && nouveau_libelle_trait != ''){

      			console.log("3-OK");
				
				if((typeof nouveau_libelle_op != null && nouveau_libelle_op != '') && (typeof nouveau_libelle_act != null && nouveau_libelle_act != '')){ 
					
					var pont_ajout = {

						libelle_proc : libelle_proc,
						nouveau_libelle_trait : nouveau_libelle_trait,
						nouveau_libelle_op :  nouveau_libelle_op,
						nouveau_libelle_act :  nouveau_libelle_act,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-3-1-3"
					};
						


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_trait_error').html('');
								$('#libelle_op_error').html('');
								$('#libelle_act_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_trait_error').html(res[1]);
								$('#libelle_op_error').html(res[2]);
								$('#libelle_act_error').html(res[3]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-3-1-3");

				}else if ((typeof nouveau_libelle_op != null && nouveau_libelle_op != '') && (nouveau_libelle_act == '')){


					var pont_ajout = {

						libelle_proc : libelle_proc,
						nouveau_libelle_trait : nouveau_libelle_trait,
						nouveau_libelle_op :  nouveau_libelle_op,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-3-1-2"
					};

					

					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_trait_error').html('');
								$('#libelle_op_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_trait_error').html(res[1]);
								$('#libelle_op_error').html(res[2]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-3-1-2");


				}else{


					var pont_ajout = {

						libelle_proc : libelle_proc,
						nouveau_libelle_trait : nouveau_libelle_trait,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-3-1-1"
					};	
					


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_trait_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_trait_error').html(res[1]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-3-1-1");

				}
				


      		}else{

      			$('#libelle_error').html('');
				$('#libelle_trait_error').html('');
				$('#libelle_op_error').html('');
				$('#libelle_act_error').html('');

      			$('#message_error').empty();
				$("#message_error").append('<div class="alert-danger center">Nouveau Catégorie 1 obligatoire</div>');

      			console.log("3-NON");
      		}





	    }else if($('#nouveau_trait').hasClass('hidden') && !$('#nouveau_op').hasClass('hidden') && !$('#nouveau_act').hasClass('hidden')){
	    	
	    	console.log("2");

	    	if(typeof nouveau_libelle_op != null && nouveau_libelle_op != ''){

      			console.log("2-OK");

      			if((typeof nouveau_libelle_op != null && nouveau_libelle_op != '') && (typeof nouveau_libelle_act != null && nouveau_libelle_act != '') && !$('#nouveau_act').hasClass('hidden')){

      				var choix_cat = document.getElementById('choix_cat').value;

      				var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_cat : choix_cat,
						nouveau_libelle_op :  nouveau_libelle_op,
						nouveau_libelle_act :  nouveau_libelle_act,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-2-1-2"
					};	
					


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_op_error').html('');
								$('#libelle_act_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_op_error').html(res[2]);
								$('#libelle_act_error').html(res[3]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;


      				console.log("2-1-2");

      			}else if((typeof nouveau_libelle_op != null && nouveau_libelle_op != '') && (nouveau_libelle_act == '') && !$('#nouveau_act').hasClass('hidden')){

      				var choix_cat = document.getElementById('choix_cat').value;

      				var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_cat : choix_cat,
						nouveau_libelle_op :  nouveau_libelle_op,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-2-1-1"
					};	
					

					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_op_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_op_error').html(res[2]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

      				console.log("2-1-1");
      			}

      		}else{
				
				$('#libelle_error').html('');
				$('#libelle_trait_error').html('');
				$('#libelle_op_error').html('');
				$('#libelle_act_error').html('');

      			$('#message_error').empty();
				$("#message_error").append('<div class="alert-danger center">Nouveau Catégorie 2 obligatoire</div>');

      			console.log("2-NON");
      		}



	    }else if($('#nouveau_trait').hasClass('hidden') && $('#nouveau_op').hasClass('hidden') && !$('#nouveau_act').hasClass('hidden')){

	    	console.log("1");

	    	if(typeof nouveau_libelle_act != null && nouveau_libelle_act != ''){

	    		    var choix_trait = document.getElementById('choix_trait').value;

      				var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_trait : choix_trait,
						nouveau_libelle_act :  nouveau_libelle_act,
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-1-1-1"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_act_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_act_error').html(res[2]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;


      			console.log("1-OK");

      			console.log("envoi-1-1-1");

      		}else{

      			$('#libelle_error').html('');
				$('#libelle_trait_error').html('');
				$('#libelle_op_error').html('');
				$('#libelle_act_error').html('');

      			$('#message_error').empty();
				$("#message_error").append('<div class="alert-danger center">Nouveau Catégorie 3 obligatoire</div>');

      			console.log("1-NON");
      		}


	    }else if(!$('#nouveau_champs').hasClass('hidden')){
	
			console.log("nouveau");

			if(typeof libelle_cat != null && libelle_cat != '' && typeof libelle_proc != null && libelle_proc !=''){
				
				console.log("nouveau-OK");

				if((typeof libelle_cat != null && libelle_cat != '') && (typeof libelle_trait != null && libelle_trait != '') && (typeof libelle_op != null && libelle_op != '') ){

					var pont_ajout = {

						libelle_proc : libelle_proc,
						libelle_cat :  libelle_cat,
						libelle_trait : libelle_trait,
						libelle_op :  	libelle_op,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-nouveau"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_nouv_trait_error').html('');
								$('#libelle_nouv_op_error').html('');
								$('#libelle_nouv_cat_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_nouv_trait_error').html(res[2]);
								$('#libelle_nouv_op_error').html(res[3]);
								$('#libelle_nouv_cat_error').html(res[1]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-nouveau");

				}else if((typeof libelle_cat != null && libelle_cat != '') && (typeof libelle_trait != null && libelle_trait != '') && (libelle_op == '')){

					var pont_ajout = {

						libelle_proc : libelle_proc,
						libelle_cat :  libelle_cat,
						libelle_trait : libelle_trait,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-nouveau-2"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_nouv_trait_error').html('');
								$('#libelle_nouv_cat_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_nouv_trait_error').html(res[2]);
								$('#libelle_nouv_cat_error').html(res[1]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-nouveau-2");
								
				}else if((typeof libelle_cat != null && libelle_cat != '') && (libelle_trait == '') && (libelle_op == '')){

					var pont_ajout = {

						libelle_proc : libelle_proc,
						libelle_cat :  libelle_cat,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-nouveau-1"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#libelle_nouv_cat_error').html('');
								$('#message_error').html('Veuillez éssayer ultérieurement');

							}else{
								console.log(data);

								var str = data;
								var res = str.split("||");


								$('#libelle_error').html(res[0]);
								$('#libelle_nouv_cat_error').html(res[1]);
								$('#message_error').html('');	
							}

							
						}
					});

					return true;

					console.log("envoi-nouveau-1");

				}

			}else{

				console.log("nouveau-NON");

				$('#libelle_error').html('');
				$('#libelle_trait_error').html('');
				$('#libelle_op_error').html('');
				$('#libelle_act_error').html('');

				$('#message_error').empty();
				$("#message_error").append('<div class="alert-danger center">Nouveau Catégorie 1 est obligatoire</div>');
			}
	
		}else{

			if(!$('#option_cat').hasClass('hidden') && $('#option_trait').hasClass('hidden') && $('#option_op').hasClass('hidden') && $('#option_act').hasClass('hidden')){

					var choix_cat = document.getElementById('choix_cat').value;

					var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_cat : choix_cat,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-cat"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#message_error').html('<div class="alert-danger center">Veuillez éssayer ultérieurement</div>');

							}else{

								console.log(data);

								$('#libelle_error').html(data);
				
							}

							console.log(data);

							
						}
					});

					return true;

				console.log("cat");

			}else if(!$('#option_cat').hasClass('hidden') && !$('#option_trait').hasClass('hidden') && $('#option_op').hasClass('hidden') && $('#option_act').hasClass('hidden')){
				
					var choix_trait = document.getElementById('choix_trait').value;

					var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_trait : choix_trait,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-cat-trait"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#message_error').html('<div class="alert-danger center">Veuillez éssayer ultérieurement</div>');
								$('#option_trait_error').html('');

							}else if(data == 'erreur-process'){

								$('#libelle_error').html('');
								$('#message_error').html('');
								$('#option_trait_error').html('<div class="alert-danger center">La catégorie choisie est une fin de traitement</div>');

							}else{

								console.log(data);

								$('#libelle_error').html(data);
								$('#option_trait_error').html('');
				
							}

							console.log(data);

							
						}
					});

					return true;

				console.log("cat_trait");

			}else if(!$('#option_cat').hasClass('hidden') && !$('#option_trait').hasClass('hidden') && !$('#option_op').hasClass('hidden') && $('#option_act').hasClass('hidden')){
				

					var choix_op = document.getElementById('choix_op').value;

					var pont_ajout = {

						libelle_proc : libelle_proc,
						choix_op : choix_op,
						
						canal_tel : canal_tel,
						canal_mail : canal_mail,
						canal_courrier : canal_courrier,
						ajax : "envoi-cat-trait-op"
					};	


					$.ajax({
						url: url_add_proc,
						type: 'POST',
						data: pont_ajout,
						success: function(data) {

							if(data == 'OK'){
									
								console.log('ok');

								window.location.href = url_proc;

							}else if(data == 'erreur'){
								
								$('#libelle_error').html('');
								$('#message_error').html('<div class="alert-danger center">Veuillez éssayer ultérieurement</div>');
								$('#option_op_error').html('');

							}else if(data == 'erreur-process'){

								$('#libelle_error').html('');
								$('#message_error').html('');
								$('#option_op_error').html('<div class="alert-danger center">La catégorie choisie est une fin de traitement</div>');

							}else{

								console.log(data);

								$('#libelle_error').html(data);
								$('#option_trait_error').html('');
				
							}

							console.log(data);

							
						}
					});

					return true;


				console.log("cat_trait_op");

			}else if(!$('#option_cat').hasClass('hidden') && !$('#option_trait').hasClass('hidden') && !$('#option_op').hasClass('hidden') && !$('#option_act').hasClass('hidden')){
				
				$('#message_error').html('<div class="alert-danger center">La catégorie choisie est une fin de traitement</div>');
			
			}

	    }

	}else{

		console.log("aucun");


		$('#libelle_error').html('');
		$('#libelle_trait_error').html('');
		$('#libelle_op_error').html('');
		$('#libelle_act_error').html('');

		$('#message_error').empty();
		$("#message_error").append('<div class="alert-danger center">Champs Libelle processus obligatoire</div>');
	}
}