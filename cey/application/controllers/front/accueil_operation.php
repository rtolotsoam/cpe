<?php


class Accueil_operation extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_operation','ops');
        $this->load->model('cey_marche','mars');
        $this->load->model('cey_categorie','cats');
        $this->load->model('cey_traitement','traits');
        $this->load->model('cey_entre','entr');

    }

    

    public function index($id)
    {
        $this->accueil_operation($id);

    }

    public function accueil_operation($id)
    {
        if($this->session->userdata('loggin')){

            $id_traits = (int) $id;


            //** CODE **

            $traitements = $this->traits->getNomtraitementById($id_traits);

            if(!empty($traitements)){
                foreach ($traitements as $val_trait) {
                    $nom_traitement = $val_trait->info_traitement;
                    $id_cats = $val_trait->categorie_id;
                }
            }


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

            $operation = $this->ops->liste_operation_by_traitement($id_traits);

            if(!empty($operation)){
                foreach ($operation as $val_op) {
                    if($val_op->process_id != "0"){
                        $donnes_deb = $this->mars->liste_processus_first($val_op->process_id, $canal);
                        $deb[$val_op->cey_operation_id] = $donnes_deb;
                    }
                }

            }
            $level = $this->session->userdata('level');

            $var_js_pont = "var pont = "."\"".site_url("front/pont")."\";";
            //** END CODE **
            
        
            // *** PARAMETRE VUE
            $data['titre'] = 'ACCUEIL PROCESSUS';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global','admin/module.admin.page.pricing_tables.min');
            $data['level'] = $level;
            $data['prenom'] = $this->session->userdata('prenom');
            $data['js_info'] = array($var_js_pont);
            $data['js'] = array('js/debut.js', 'js/global.js','js/back.js');
            if(!empty($operation)){
                $data['operation'] = $operation;
            }

            if(!empty($deb)){
                $data['deb'] = $deb;
            }

            if(!empty($entres)){
                $data['nom_entre']= $nom_entre;
            }

            if(!empty($traitements) && !empty($categories)){
                $data['nom_categorie'] = $nom_categorie;
                $data['nom_traitement'] = $nom_traitement;
                $data['id_traitement'] = $id_cats;
                $data['id_categorie'] = $id_entre;
                $data['encours_ops'] = "ok";
            }
            // *** END PARAMETRE VUE
        
            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('includes/menu_verticale_traitement.php', $data);
            $this->load->view('front/accueil_operation_view.php', $data);
            $this->load->view('includes/footer.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }

    }

}