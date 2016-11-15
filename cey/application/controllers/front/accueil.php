<?php


class Accueil extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_entre','entr');
        $this->load->model('cey_user','usr');

    }

    

    public function index()
    {

        $this->accueil();

    }


    public function accueil()
    {
        if($this->session->userdata('loggin')){

            //** CODE **
            $entres = $this->entr->liste_entre();
            $level = $this->session->userdata('level');

            if($this->session->userdata('user')){

                $user = $this->session->userdata('user');

                if(!empty($user)){

                    foreach ($user as $val_user) {
                        $id_user = $val_user->cey_user_id;
                        $data_user['id_user'] = $id_user;

                        $this->session->set_userdata('id_user', $id_user);

                        $data_user['matricule'] = $val_user->matricule;
                        $data_user['prenom'] = $val_user->prenom;
                        $data_user['pass'] = $val_user->pass;
                        $data_user['mail'] = $val_user->mail; 
                    }

                    $this->session->unset_userdata('user');
                }
            }else{

                $user = $this->usr->liste_utilisateur_ById((int) $this->session->userdata('id_user'));

                if(!empty($user)){

                    foreach ($user as $val_user) {
                        $id_user = $val_user->cey_user_id;
                        $data_user['id_user'] = $id_user;

                        $data_user['matricule'] = $val_user->matricule;
                        $data_user['prenom'] = $val_user->prenom;
                        $data_user['pass'] = $val_user->pass;
                        $data_user['mail'] = $val_user->mail; 
                    }

                }
            }

            $var_url_modif_user_profil = "var url_modif_user_profil = "."\"".site_url("back/utilisateur/modifier_profil")."\";";
            $var_url_accueil = "var url_accueil = "."\"".site_url("front/accueil")."\";";
            //** END CODE **
            
            //** PARAMETRE VUE **
            $data['titre'] = 'ACCUEIL';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global','admin/module.admin.page.pricing_tables.min');
            $data['entres'] = $entres;
            $data['level'] = $level;
            $data['prenom'] = $this->session->userdata('prenom');
            $data['js'] = array('js/back.js','js/users.js');
            $data['js_info'] = array($var_url_modif_user_profil, $var_url_accueil);
            //** END PARAMETRE VUE **
        
            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('front/accueil_view.php', $data);
            $this->load->view('front/user_profil_view.php', $data_user);
            $this->load->view('includes/footer.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }
    }

}