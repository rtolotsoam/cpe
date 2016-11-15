<?php


class Accueil_traitement extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_categorie','cats');
        $this->load->model('cey_traitement','traits');
        $this->load->model('cey_marche','mars');
        $this->load->model('cey_entre','entr');

    }

    

    public function index($id)
    {
        $this->accueil_traitement($id);

    }

    public function accueil_traitement($id)
    {
        if($this->session->userdata('loggin')){

            //** CODE **
            $id_cats = (int) $id;
            
            $traitement = $this->traits->liste_traitement_by_categorie($id_cats);

            $categories = $this->cats->getNomcategorieById($id_cats);


            if(!empty($categories)){
                foreach ($categories as $val_cat) {
                    $nom_categorie = $val_cat->info_categorie;
                    $id_entre = (int) $val_cat->entre_id;
                }
            }


            $entres = $this->entr->getNomEntreById($id_entre);

            if(!empty($entres)){
                foreach ($entres as $val_ent) {
                    $nom_entre = $val_ent->libelle;
                }
            }

            $canal = $this->session->userdata('canal');

            if(!empty($traitement)){
                foreach ($traitement as $val_op) {
                    if($val_op->process_id != "0"){
                        $donnes_deb = $this->mars->liste_processus_first($val_op->process_id, $canal);
                        $deb[$val_op->cey_traitement_id] = $donnes_deb;
                    }
                }

            }
            


            $level = $this->session->userdata('level');

            $var_js_pont = "var pont = "."\"".site_url("front/pont")."\";";
            //** END CODE **
            
            //** PARAMETRE VUE **
            $data['titre'] = 'ACCUEIL TRAITEMENT';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global','admin/module.admin.page.pricing_tables.min');
            $data['level'] = $level;
            $data['prenom'] = $this->session->userdata('prenom');
            $data['js_info'] = array($var_js_pont);
            $data['js'] = array('js/debut.js', 'js/global.js', 'js/back.js');

            if(!empty($traitement)){
                $data['traitement'] = $traitement;
                $data['encours_traits'] = "ok";
            }

            if(!empty($entres)){
                $data['nom_entre']= $nom_entre;
            }

            if(!empty($deb)){

                $data['deb'] = $deb;
            }

            if(!empty($categories)){
                $data['nom_categorie']= $nom_categorie;
                $data['encours_cats'] = "ok";
                
                $data['id_categorie'] = $id_entre;
            }
            //** END PARAMETRE VUE **
        
            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('includes/menu_verticale_traitement.php',$data);
            $this->load->view('front/accueil_traitement_view.php', $data);
            $this->load->view('includes/footer.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }

    }

}