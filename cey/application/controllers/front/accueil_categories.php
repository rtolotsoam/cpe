<?php


class Accueil_categories extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_categorie','cats');
        $this->load->model('cey_entre','entr');

    }

    

    public function index($id)
    {

        $this->accueil_categories($id);

    }


    public function accueil_categories($id)
    {
        if($this->session->userdata('loggin')){

            $id_entre = (int) $id;

            //** CODE **
            $categories = $this->cats->liste_categories_by_entre($id_entre);

            $level = $this->session->userdata('level');

            $entres = $this->entr->getNomEntreById($id_entre);

            if(!empty($entres)){
                foreach ($entres as $val_ent) {
                    $nom_entre = $val_ent->libelle;
                }
            }
            //** END CODE **
			
            //** PARAMETRE VUE **
			$data['titre'] = 'ACCUEIL CATEGORIE';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global','admin/module.admin.page.pricing_tables.min');
            $data['categories'] = $categories;
            $data['level'] = $level;
            $data['prenom'] = $this->session->userdata('prenom');
            if(!empty($entres)){
                $data['nom_entre']= $nom_entre;
                $data['encours_entre'] = "ok";
            }
            $data['js'] = array('js/back.js');
            //** END PARAMETRE VUE **
		
            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('includes/menu_verticale_traitement.php',$data);
            $this->load->view('front/accueil_categories_view.php', $data);
            $this->load->view('includes/footer.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }

    }

}