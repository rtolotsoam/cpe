<?php


class Utilisateur extends CI_Controller
{


	
	public function __construct()
	{
		//  Obligatoire
		parent::__construct();

		$this->load->model('cey_user','user');

		$this->load->library('form_validation');
		$this->load->library('email');


	}	

	

	public function index()
	{

		$this->utilisateur();

	}


	public function utilisateur()
	{
		$level = $this->session->userdata('level');

		if($this->session->userdata('loggin') && $level == 'admin'){

			//** CODE **
			$users = $this->user->liste_utilisateur();


			$var_url_ajout_user = "var url_ajout_user = "."\"".site_url("back/utilisateur/ajouter")."\";";
			$var_url_suppr_user = "var url_suppr_user = "."\"".site_url("back/utilisateur/supprimer")."\";";
			$var_url_modif_user = "var url_modif_user = "."\"".site_url("back/utilisateur/modifier")."\";";
			$var_url_ajout_user_ok = "var url_ajout_user_ok = "."\"".site_url("back/utilisateur")."\";";
			//** END CODE **
			
			//** PARAMETRE VUE **
			$data['titre'] = 'UTILISATEUR';
			$data['css'] = array('admin/module.admin.page.tables.min','admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global'); 
			$data['level'] = $level;
            $data['gestion_usr'] = $this->session->userdata('gestion_user');
            $data['gestion_proc'] = $this->session->userdata('gestion_process');

			$data['js_info'] = array($var_url_ajout_user, $var_url_ajout_user_ok, $var_url_suppr_user, $var_url_modif_user);
			$data['js'] = array('js/users.js');
			if(!empty($users)){
				$data['users'] = $users;
			}
			//** END PARAMETRE VUE **
		
			//** APPEL VUE **
			$this->load->view('includes/header.php', $data);
			$this->load->view('includes/menu_vertical.php', $data);
			$this->load->view('back/utilisateur_view.php', $data);
			$this->load->view('back/ajout_user_view.php');
			if(!empty($users)){
				foreach ($users as $val_user) {
					$id_user = (int) $val_user->cey_user_id;

					$data_supr['id_user'] = $id_user;
					$data_supr['mle'] = $val_user->matricule;
					$data_supr['pren'] = $val_user->prenom;
					
					$data_supr['email'] = $val_user->mail;
					$data_supr['stat'] = $val_user->flag;

					$data_supr['pas'] = $val_user->pass;
					$data_supr['lev'] = $val_user->level;



					$data_supr['acc_user'] = $val_user->gestion_user;
					$data_supr['acc_process'] = $val_user->gestion_process;


					$this->load->view('back/supprimer_user_view.php', $data_supr);
					$this->load->view('back/modifier_user_view.php', $data_supr);
				}
			}
			$this->load->view('includes/footer_admin.php');
			$this->load->view('includes/js.php');
			//** END APPEL VUE **

			
		}else{
			redirect('login');
		}

	}


	public function ajouter(){

		$level = $this->session->userdata('level');

		if($this->session->userdata('loggin') && $level == 'admin' && $this->input->post('ajax') == '1'){

			// VALIDATION DU CHAMPS DU FORMULAIRE (Libelle traitement)
			$this->form_validation->set_rules('matricule', 'Matricule', 'integer|trim|required|min_length[2]|max_length[10]|xss_clean|htmlspecialchars');
			$this->form_validation->set_rules('prenom', 'Prénom', 'min_length[4]|max_length[20]|trim|required|xss_clean|htmlspecialchars');
			$this->form_validation->set_rules('pass', 'Mot de passe', 'min_length[4]|max_length[10]|trim|required|xss_clean|htmlspecialchars');
			$this->form_validation->set_rules('confpass', 'Confirmation Mot de passe', 'min_length[4]|max_length[10]|trim|required|xss_clean|htmlspecialchars');

			// PERSONNALISATION DES MESSAGES D'ERREUR
			$this->form_validation->set_message('required', 'Le champs est obligatoire');
			$this->form_validation->set_message('htmlspecialchars', 'Caractères invalide');
			$this->form_validation->set_message('xss_clean', 'Caractères invalide');
			$this->form_validation->set_message('min_length', 'Longueur de champs minimum invalide');
			$this->form_validation->set_message('max_length', 'Longueur de champs maximum invalide');
			$this->form_validation->set_message('integer', 'Champs non numérique');

			// TRAITEMENT DU FORMULAIRE
			if($this->form_validation->run()) {

				$matricule = $this->input->post('matricule');
				$prenom = $this->input->post('prenom');
				$mail = $this->input->post('mail');
				$pass = $this->input->post('pass');

				$level = $this->input->post('level');
				$statut = $this->input->post('statut');
				$access_1 = $this->input->post('access_1');
				$access_2 = $this->input->post('access_2');

				$data_user = array(
					'matricule' => $matricule,
					'prenom' => $prenom,
					'mail' => $mail,
					'pass' => $pass,
					'level' => $level,
					'statut' => $statut,
					'gestion_user' => $access_1,
					'gestion_process' => $access_2
				);

					
					if($statut == '1'){


						$this->email->from("", "Outil d'aide à l'agent CPE");
						$this->email->to($mail);
						$this->email->subject("Création de votre compte utilisateur Outil d'aide à l'agent CPE");
						
						$this->email->message('
							<strong>Bonjour '.strtoupper($prenom).'</strong><br/><br/>
							<p>Votre compte a été créer pour utiliser l\'outil d\'aide à l\'agent CPE.</p>
							<p>Ci-joint les détails</p>
							<h2>Information sur votre compte : </h2>
							<ol>
								<li>Matricule : '.$matricule.'</li>
								<li>Mot de passe : '.$pass.'</li>
								<li>Lien : http://aide-agent.vivetic.com:8888/cpe</li>
							</ol>
							<p>Cordialement</p> 
							<p><h4>Administration <span style="color:blue;">CPE</span></h4></p>
							');


						$result = $this->email->send();

						//var_dump($result);

						if($result){
							
							$utilisateur = $this->user->ajouter_user($data_user);
							
							if($utilisateur){
								echo "success";
							}else{
								echo "erreur";
							}

						}else{
							
							$utilisateur = $this->user->ajouter_user($data_user);

							echo "success";
						}

					}else if($statut == '0'){

						$this->email->from("", "Outil d'aide à l'agent CPE");
						$this->email->to($mail);
						$this->email->subject("Création de votre compte utilisateur Outil d'aide à l'agent CPE");
						
						$this->email->message('
							<strong>Bonjour '.strtoupper($prenom).'</strong><br/><br/>
							<p>Votre compte a été créer pour utiliser l\'outil d\'aide à l\'agent CPE.</p>
							<p>Mais il n\'est pas encore activé, veuillez aviser votre N+1 de l\'activer.</p>
							<p>Ci-joint les détails</p>
							<h2>Information sur votre compte : </h2>
							<ol>
								<li>Matricule : '.$matricule.'</li>
								<li>Mot de passe : '.$pass.'</li>
								<li>Lien : http://aide-agent.vivetic.com:8888/cpe</li>
							</ol>
							<p>Cordialement</p> 
							<p><h4>Administration <span style="color:blue;">CPE</span></h4></p>
							');


						$result = $this->email->send();

						//var_dump($result);

						if($result){
							
							$utilisateur = $this->user->ajouter_user($data_user);
							
							if($utilisateur){
								echo "success";
							}else{
								echo "erreur";
							}

						}else{
							
							$utilisateur = $this->user->ajouter_user($data_user);

							echo "success";
						}

					}
						

				

			}else{
				echo form_error('matricule' ,'<div class="alert alert-danger" align="center">' ,'</div>').";".form_error('prenom' ,'<div class="alert alert-danger" align="center">' ,'</div>').";".form_error('pass' ,'<div class="alert alert-danger" align="center">' ,'</div>').";".form_error('confpass' ,'<div class="alert alert-danger" align="center">' ,'</div>');
			}

		}else{
			redirect('login');
		}

	}


	public function supprimer(){
        
        $level = $this->session->userdata('level');        

        if($this->session->userdata('loggin') && $level =="admin"){

            $id = (int) $this->input->post('id_user');
            
            
            
            $data = array(
                'flag' => 0    
            );
            
            $res = $this->user->editer_user($id, $data);

            echo site_url('back/utilisateur');
               
        }else{
            redirect('login');
        }
    }


    public function modifier(){

    	$level = $this->session->userdata('level');

		if($this->session->userdata('loggin') && $level == 'admin' && $this->input->post('ajax') == '1'){


			$id_user = (int) $this->input->post('id_user');


			// VALIDATION DU CHAMPS DU FORMULAIRE (Libelle traitement)
			$this->form_validation->set_rules('matricule', 'Matricule', 'integer|trim|required|min_length[2]|max_length[10]|xss_clean|htmlspecialchars');
			$this->form_validation->set_rules('prenom', 'Prénom', 'min_length[4]|max_length[20]|trim|required|xss_clean|htmlspecialchars');
			$this->form_validation->set_rules('pass', 'Mot de passe', 'min_length[4]|max_length[10]|trim|required|xss_clean|htmlspecialchars');

			// PERSONNALISATION DES MESSAGES D'ERREUR
			$this->form_validation->set_message('required', 'Le champs est obligatoire');
			$this->form_validation->set_message('htmlspecialchars', 'Caractères invalide');
			$this->form_validation->set_message('xss_clean', 'Caractères invalide');
			$this->form_validation->set_message('min_length', 'Longueur de champs minimum invalide');
			$this->form_validation->set_message('max_length', 'Longueur de champs maximum invalide');
			$this->form_validation->set_message('integer', 'Champs non numérique');

			// TRAITEMENT DU FORMULAIRE
			if($this->form_validation->run()) {

				$matricule = $this->input->post('matricule');
				$prenom = $this->input->post('prenom');
				$mail = $this->input->post('mail');
				$pass = $this->input->post('pass');

				$level = $this->input->post('level');
				$statut = $this->input->post('statut');
				$access_1 = $this->input->post('access_1');
				$access_2 = $this->input->post('access_2');

				if($level == "user"){

					$data_user = array(
						'matricule' => $matricule,
						'prenom' => $prenom,
						'mail' => $mail,
						'pass' => $pass,
						'level' => $level,
						'statut' => $statut,
						'gestion_user' => 0,
						'gestion_process' => 0
					);

				}else{
					
					$data_user = array(
						'matricule' => $matricule,
						'prenom' => $prenom,
						'mail' => $mail,
						'pass' => $pass,
						'level' => $level,
						'statut' => $statut,
						'gestion_user' => $access_1,
						'gestion_process' => $access_2
					);

				}

				$utilisateur = $this->user->editer_user($id_user, $data_user);

				if($utilisateur){
					echo "success";
				}else{
					echo "erreur";
				}

			}else{
				echo form_error('matricule' ,'<div class="alert alert-danger" align="center">' ,'</div>').";".form_error('prenom' ,'<div class="alert alert-danger" align="center">' ,'</div>').";".form_error('pass' ,'<div class="alert alert-danger" align="center">' ,'</div>');
			}

		}else{
			redirect('login');
		}

    }


    public function modifier_profil(){

		if($this->input->post('ajax') == '1'){


			$id_user = (int) $this->input->post('id_user');


			if($this->input->post('modif') == 'mail_renseigne'){

				// VALIDATION DU CHAMPS DU FORMULAIRE (Libelle traitement)
				$this->form_validation->set_rules('prenom', 'Prénom', 'min_length[4]|max_length[20]|trim|required|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('mail', 'E-mail', 'valid_email|trim|required|xss_clean|htmlspecialchars');

				// PERSONNALISATION DES MESSAGES D'ERREUR
				$this->form_validation->set_message('required', 'Le champs est obligatoire');
				$this->form_validation->set_message('htmlspecialchars', 'Caractères invalide');
				$this->form_validation->set_message('xss_clean', 'Caractères invalide');
				$this->form_validation->set_message('valid_email', 'E-mail invalide');
				$this->form_validation->set_message('min_length', 'Longueur de champs minimum invalide');
				$this->form_validation->set_message('max_length', 'Longueur de champs maximum invalide');
				

				// TRAITEMENT DU FORMULAIRE
				if($this->form_validation->run()) {

					$prenom = $this->input->post('prenom');
					$matricule = $this->input->post('matricule');
					$pass = $this->input->post('pass');
					$mail = $this->input->post('mail');

						$this->email->from("", "Outil d'aide à l'agent CPE");
						$this->email->to($mail);
						$this->email->subject("Renseignement de votre adresse E-mail dans l'Outil d'aide à l'agent CPE");
						
						$this->email->message('
							<strong>Bonjour '.strtoupper($prenom).'</strong><br/><br/>
							<p>Merci d\'avoir renseigner votre adresse E-mail, pour utiliser l\'outil d\'aide à l\'agent CPE.</p>
							<p>Ci-joint les détails</p>
							<h2>Information sur votre compte : </h2>
							<ol>
								<li>Matricule : '.$matricule.'</li>
								<li>Mot de passe : '.$pass.'</li>
								<li>Lien : http://aide-agent.vivetic.com:8888/cpe</li>
							</ol>
							<p>Cordialement</p> 
							<p><h4>Administration <span style="color:blue;">CPE</span></h4></p>
							');


						$result = $this->email->send();

						//var_dump($result);

						if($result){

							$data_user = array(
								'prenom' => $prenom,
								'mail' => $mail
							);
							
							$utilisateur = $this->user->editer_user($id_user, $data_user);

							if($utilisateur){
								echo "success";
							}else{
								echo "erreur";
							}

						}else{

							echo "erreur-mail";
						}

				}else{
					echo form_error('prenom' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('mail' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('pass' ,'<div class="alert alert-danger" align="center">' ,'</div>');
				}

			}else if($this->input->post('modif') == 'modif_pass_mail'){

				// VALIDATION DU CHAMPS DU FORMULAIRE (Libelle traitement)
				$this->form_validation->set_rules('prenom', 'Prénom', 'min_length[4]|max_length[20]|trim|required|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('pass', 'Mot de passe', 'trim|required|min_length[4]|max_length[8]|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('mail', 'E-mail', 'valid_email|trim|required|xss_clean|htmlspecialchars');

				// PERSONNALISATION DES MESSAGES D'ERREUR
				$this->form_validation->set_message('required', 'Le champs est obligatoire');
				$this->form_validation->set_message('htmlspecialchars', 'Caractères invalide');
				$this->form_validation->set_message('xss_clean', 'Caractères invalide');
				$this->form_validation->set_message('valid_email', 'E-mail invalide');
				$this->form_validation->set_message('min_length', 'Longueur de champs minimum invalide');
				$this->form_validation->set_message('max_length', 'Longueur de champs maximum invalide');
				

				// TRAITEMENT DU FORMULAIRE
				if($this->form_validation->run()) {

					$prenom = $this->input->post('prenom');
					$matricule = $this->input->post('matricule');
					$pass = $this->input->post('pass');
					$mail = $this->input->post('mail');

						$this->email->from("", "Outil d'aide à l'agent CPE");
						$this->email->to($mail);
						$this->email->subject("Modification mot de passe et renseignement de votre adresse E-mail dans l'Outil d'aide à l'agent CPE");
						
						$this->email->message('
							<strong>Bonjour '.strtoupper($prenom).'</strong><br/><br/>
							<p>Merci d\'avoir renseigner votre adresse E-mail et votre mot de passe est modifier, pour utiliser l\'outil d\'aide à l\'agent CPE.</p>
							<p>Ci-joint les détails</p>
							<h2>Information sur votre compte : </h2>
							<ol>
								<li>Matricule : '.$matricule.'</li>
								<li>Mot de passe : '.$pass.'</li>
								<li>Lien : http://aide-agent.vivetic.com:8888/cpe</li>
							</ol>
							<p>Cordialement</p> 
							<p><h4>Administration <span style="color:blue;">CPE</span></h4></p>
							');


						$result = $this->email->send();

						//var_dump($result);

						if($result){

							$data_user = array(
								'prenom' => $prenom,
								'mail' => $mail,
								'pass' => $pass
							);
							
							$utilisateur = $this->user->editer_user($id_user, $data_user);

							if($utilisateur){
								echo "success";
							}else{
								echo "erreur";
							}

						}else{

							echo "erreur-mail";
						}

				}else{
					echo form_error('prenom' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('mail' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('pass' ,'<div class="alert alert-danger" align="center">' ,'</div>');
				}

			}else if($this->input->post('modif') == 'modif_pass'){

				// VALIDATION DU CHAMPS DU FORMULAIRE (Libelle traitement)
				$this->form_validation->set_rules('prenom', 'Prénom', 'min_length[4]|max_length[20]|trim|required|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('pass', 'Mot de passe', 'trim|required|min_length[4]|max_length[8]|xss_clean|htmlspecialchars');
				// PERSONNALISATION DES MESSAGES D'ERREUR
				$this->form_validation->set_message('required', 'Le champs est obligatoire');
				$this->form_validation->set_message('htmlspecialchars', 'Caractères invalide');
				$this->form_validation->set_message('xss_clean', 'Caractères invalide');
				$this->form_validation->set_message('min_length', 'Longueur de champs minimum invalide');
				$this->form_validation->set_message('max_length', 'Longueur de champs maximum invalide');
				

				// TRAITEMENT DU FORMULAIRE
				if($this->form_validation->run()) {

					$prenom = $this->input->post('prenom');
					$pass = $this->input->post('pass');
					$mail = $this->input->post('mail');

							$data_user = array(
								'prenom' => $prenom,
								'mail' => $mail,
								'pass' => $pass
							);
							
							$utilisateur = $this->user->editer_user($id_user, $data_user);

							if($utilisateur){
								echo "success";
							}else{
								echo "erreur";
							}

						

				}else{
					echo form_error('prenom' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('mail' ,'<div class="alert alert-danger" align="center">' ,'</div>')."|||".form_error('pass' ,'<div class="alert alert-danger" align="center">' ,'</div>');
				}
			}

		}else{
			redirect('login');
		}

    }

}