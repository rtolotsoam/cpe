<?php


class Gestion_process extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        // APPELER LES MODEL
        $this->load->model('cey_reference_process','ref');
        $this->load->model('cey_entre','entr');
        $this->load->model('cey_categorie','cat');
        $this->load->model('cey_traitement','trait');
        $this->load->model('cey_operation','op');
        $this->load->model('cey_action','act');
        $this->load->model('cey_marche','mars');


        $this->load->library('form_validation');

    }

    

    public function index()
    {

        $this->gestion_process();

    }

    // AFFICHER HISTORIQUE
    public function gestion_process()
    {
        $level = $this->session->userdata('level');

        if($this->session->userdata('loggin') && $level == "admin"){
			
            
            // CODE
            $canal = $this->session->userdata('canal');

            $where = array($canal => 1);

            $id_entre = 1;

            $this->session->set_userdata('entre', $id_entre);

            
            $donnees = $this->ref->liste_reference($where, $id_entre);

            if(!empty($donnees)){
                foreach ($donnees as $val_pro) {
                    $id_parent = (int) $val_pro->process_id;

                    $debs = $this->mars->liste_processus_first($id_parent, $canal);

                    foreach ($debs as $val_deb) {
                        $id_pro_first = (int) $val_deb->cey_marche_id;

                        $data_deb[$id_parent] = $id_pro_first;
                    }
                }
            }

            $liste_entre = $this->entr->liste_entre();

            $liste_categorie = $this->cat->liste_categories_by_entre($id_entre);

            $var_js_cat = "var acc_cat = "."\"".site_url("back/gestion_process/routage")."\";";
            $var_url_js = "var url_js_traits ="."\"".site_url("back/traitement_admin")."\";";
            $var_url_direct = "var url_acc_traits ="."\"".site_url("back/accueil_admin/normal")."\";";
            $var_js_pont = "var pont = "."\"".site_url("front/pont")."\";";
            $var_js_pont_editer = "var pont_editer = "."\"".site_url("front/pont/editer")."\";";
            $var_js_supr_cat_trait = "url_suppr_cat_trait = "."\"".site_url("back/accueil_admin/supprimer_cat_traitement")."\";";
            $var_js_editer_cat = "var url_suppr_cat = "."\"".site_url("back/accueil_admin/supprimer_categories")."\";";
            $var_js_modif_cat = "var url_js_modif_cats = "."\"".site_url("back/accueil_admin/modif_categories")."\";";
            $var_js_modif_cat_trait = "var url_js_modif_cat_trait = "."\"".site_url("back/accueil_admin/modif_cat_traitement")."\";";
            $var_url_modif_cat = "var url_acc_cats = "."\"".site_url("back/accueil_admin/normal")."\";";
            $var_url_cheminement_cat = "var cheminement_cat = "."\"".site_url("back/gestion_process/cheminement_cat")."\";";
            $var_url_cheminement_op = "var cheminement_op = "."\"".site_url("back/gestion_process/cheminement_op")."\";";
            $var_url_cheminement_act = "var cheminement_act = "."\"".site_url("back/gestion_process/cheminement_act")."\";";
            $var_url_add_proc = "var url_proc_ajout = "."\"".site_url("back/gestion_process/ajouter_procs")."\";";
            $var_url_proc = "var url_proc = "."\"".site_url("back/gestion_process/normal")."\";";
            $var_url_suppr_proc = "var url_suppr_proc = "."\"".site_url("back/gestion_process/supprimer_procs")."\";";
            // END CODE

            // PARAMETRE VUE
            $data['titre'] = 'GESTION PROCESSUS';
            $data['css'] = array('admin/module.admin.page.tables.min','admin/module.global','admin/module.admin.page.modals.min');
            if(!empty($donnees)){
                $data['data_table'] = $donnees;
                $data['data_deb'] = $data_deb;
            }

            if(!empty($liste_entre)){
                $data['lst_entre'] = $liste_entre;
                $data['id_entre'] = $id_entre;
            }

            if(!empty($liste_categorie)){
                $data['lst_categorie'] = $liste_categorie;
            }

            $data['canal'] = $canal;
            $data['level'] = $level;

            $data['gestion_usr'] = $this->session->userdata('gestion_user');
            $data['gestion_proc'] = $this->session->userdata('gestion_process');

            $data['js'] = array('js/back.js', 'js/global.js', 'js/ajout_traits.js', 'js/debut.js', 'js/admin_processus_edit.js', 'js/modif_traits.js','js/cheminement.js');
            $data['js_info'] = array($var_js_cat, $var_js_pont_editer, $var_js_editer_cat, $var_js_modif_cat, $var_url_modif_cat, $var_js_supr_cat_trait, $var_js_modif_cat_trait, $var_url_cheminement_cat, $var_url_cheminement_op, $var_url_cheminement_act, $var_js_pont, $var_url_add_proc, $var_url_proc, $var_url_suppr_proc);
            // END PARAMETRE VUE

            // APPEL VUE
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('back/gestion_process_view.php', $data);
            $this->load->view('back/ajouter_processus_view.php', $data);
            
            if(!empty($donnees)){
                foreach ($donnees as $val_pro) {
                    $id_proc = (int) $val_pro->process_id;
                    $libelle_proc = $val_pro->libelle;
                    $table_type = $val_pro->type;

                    if($table_type =='traitement'){
                        $traits = $this->trait->gettraitementById_process($id_proc);

                        foreach ($traits as $val_trait) {
                            $id_cat = $val_trait->categorie_id;
                        }

                        $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }

                        $data['type_cat'] = 'trait';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                    }elseif($table_type =='operation'){

                        $ops = $this->op->getoperationByprocessId($id_proc);

                        foreach ($ops as $val_op) {
                            $id_trait = $val_op->traitement_id;
                         } 

                         $traits = $this->trait->getNomtraitementById((int) $id_trait);

                         foreach ($traits as $val_trait) {
                             $libelle_trait = $val_trait->info_traitement;
                             $id_cat = $val_trait->categorie_id;
                         }

                         $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }


                        $data['type_cat'] = 'op';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                        $data['libelle_trait'] = $libelle_trait;
                        $data['id_trait'] = $id_trait;


                    }elseif ($table_type =='action') {
                        
                        $acts = $this->act->getactionById($id_proc);

                        foreach ($acts as $val_act) {
                            $id_op = $val_act->operation_id;
                        }

                        $ops = $this->op->getNomoperationById((int) $id_op);

                        foreach ($ops as $val_op) {
                            $id_trait = $val_op->traitement_id;
                            $libelle_op = $val_op->info_operation;
                         } 

                         $traits = $this->trait->getNomtraitementById((int) $id_trait);

                         foreach ($traits as $val_trait) {
                             $libelle_trait = $val_trait->info_traitement;
                             $id_cat = $val_trait->categorie_id;
                         }

                         $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }



                        $data['type_cat'] = 'act';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                        $data['libelle_trait'] = $libelle_trait;
                        $data['id_trait'] = $id_trait;

                        $data['libelle_op'] = $libelle_op;
                        $data['id_op'] = $id_op;


                    }

                    $data['id_proc'] = $id_proc;
                    $data['libelle_proc'] = $libelle_proc;

                    $this->load->view('back/supprimer_process_view.php', $data);
                }
            }

            $this->load->view('includes/footer_admin.php');
            $this->load->view('includes/js.php');
            // END APPEL VUE
        }else{
            redirect('login');
        }

    }

    
    public function normal(){

        $level = $this->session->userdata('level');

        if($this->session->userdata('loggin') && $level == "admin"){
            
            $canal = $this->session->userdata('canal');

            $where = array($canal => 1);

            $id_entre = $this->session->userdata('entre');

            // CODE
            
            $donnees = $this->ref->liste_reference($where, $id_entre);
            
            if(!empty($donnees)){
                foreach ($donnees as $val_pro) {
                    $id_parent = (int) $val_pro->process_id;

                    $debs = $this->mars->liste_processus_first($id_parent, $canal);

                    foreach ($debs as $val_deb) {
                        $id_pro_first = (int) $val_deb->cey_marche_id;

                        $data_deb[$id_parent] = $id_pro_first;
                    }
                }
            }

            $liste_entre = $this->entr->liste_entre();



            $liste_categorie = $this->cat->liste_categories_by_entre($id_entre);

            $var_js_cat = "var acc_cat = "."\"".site_url("back/gestion_process/routage")."\";";
            $var_url_js = "var url_js_traits ="."\"".site_url("back/traitement_admin")."\";";
            $var_url_direct = "var url_acc_traits ="."\"".site_url("back/accueil_admin/normal")."\";";
            $var_js_pont = "var pont = "."\"".site_url("front/pont")."\";";
            $var_js_pont_editer = "var pont_editer = "."\"".site_url("front/pont/editer")."\";";
            $var_js_supr_cat_trait = "url_suppr_cat_trait = "."\"".site_url("back/accueil_admin/supprimer_cat_traitement")."\";";
            $var_js_editer_cat = "var url_suppr_cat = "."\"".site_url("back/accueil_admin/supprimer_categories")."\";";
            $var_js_modif_cat = "var url_js_modif_cats = "."\"".site_url("back/accueil_admin/modif_categories")."\";";
            $var_js_modif_cat_trait = "var url_js_modif_cat_trait = "."\"".site_url("back/accueil_admin/modif_cat_traitement")."\";";
            $var_url_modif_cat = "var url_acc_cats = "."\"".site_url("back/accueil_admin/normal")."\";";
            $var_url_cheminement_cat = "var cheminement_cat = "."\"".site_url("back/gestion_process/cheminement_cat")."\";";
            $var_url_cheminement_op = "var cheminement_op = "."\"".site_url("back/gestion_process/cheminement_op")."\";";
            $var_url_cheminement_act = "var cheminement_act = "."\"".site_url("back/gestion_process/cheminement_act")."\";";
            $var_url_add_proc = "var url_proc_ajout = "."\"".site_url("back/gestion_process/ajouter_procs")."\";";
            $var_url_proc = "var url_proc = "."\"".site_url("back/gestion_process/normal")."\";";
            $var_url_suppr_proc = "var url_suppr_proc = "."\"".site_url("back/gestion_process/supprimer_procs")."\";";
            // END CODE

            // PARAMETRE VUE
            $data['titre'] = 'GESTION PROCESSUS';
            $data['css'] = array('admin/module.admin.page.tables.min','admin/module.global','admin/module.admin.page.modals.min');
            if(!empty($donnees)){
                $data['data_table'] = $donnees;
                $data['data_deb'] = $data_deb;
            }
            
            if(!empty($liste_entre)){
                $data['lst_entre'] = $liste_entre;
                $data['id_entre'] = $id_entre;
            }

            if(!empty($liste_categorie)){
                $data['lst_categorie'] = $liste_categorie;
            }

            $data['canal'] = $canal;
            $data['level'] = $level;


            $data['gestion_usr'] = $this->session->userdata('gestion_user');
            $data['gestion_proc'] = $this->session->userdata('gestion_process');

            $data['js'] = array('js/global.js', 'js/ajout_traits.js', 'js/debut.js', 'js/admin_processus_edit.js', 'js/modif_traits.js','js/cheminement.js');
            $data['js_info'] = array($var_js_cat, $var_js_pont_editer, $var_js_editer_cat, $var_js_modif_cat, $var_url_modif_cat, $var_js_supr_cat_trait, $var_js_modif_cat_trait, $var_url_cheminement_cat, $var_url_cheminement_op, $var_url_cheminement_act, $var_js_pont, $var_url_add_proc, $var_url_proc, $var_url_suppr_proc);
            // END PARAMETRE VUE

            // APPEL VUE
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('back/gestion_process_view.php', $data);
            $this->load->view('back/ajouter_processus_view.php', $data);

            if(!empty($donnees)){


                foreach ($donnees as $val_pro) {
                    $id_proc = (int) $val_pro->process_id;
                    $libelle_proc = $val_pro->libelle;

                    $table_type = $val_pro->type;




                    if($table_type =='traitement'){
                        $traits = $this->trait->gettraitementById_process($id_proc);

                        if(!empty($traits)){
                            foreach ($traits as $val_trait) {
                                $id_cat = $val_trait->categorie_id;
                            }
                        }

                        $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }

                        $data['type_cat'] = 'trait';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                    }elseif($table_type =='operation'){

                        $ops = $this->op->getoperationByprocessId($id_proc);

                        if(!empty($ops)){
                            foreach ($ops as $val_op) {
                                $id_trait = $val_op->traitement_id;
                            } 
                        }

                         $traits = $this->trait->getNomtraitementById((int) $id_trait);

                         foreach ($traits as $val_trait) {
                             $libelle_trait = $val_trait->info_traitement;
                             $id_cat = $val_trait->categorie_id;
                         }

                         $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }


                        $data['type_cat'] = 'op';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                        $data['libelle_trait'] = $libelle_trait;
                        $data['id_trait'] = $id_trait;


                    }elseif ($table_type =='action') {
                        
                        $acts = $this->act->getactionById($id_proc);

                        if(!empty($acts)){
                            foreach ($acts as $val_act) {
                                $id_op = $val_act->operation_id;
                            }
                        }



                        $ops = $this->op->getNomoperationById((int) $id_op);

                        if(!empty($ops)){
                            foreach ($ops as $val_op) {
                                $id_trait = $val_op->traitement_id;
                                $libelle_op = $val_op->info_operation;
                            } 
                        }

                         $traits = $this->trait->getNomtraitementById((int) $id_trait);

                        if(!empty($traits)){ 
                            foreach ($traits as $val_trait) {
                                $libelle_trait = $val_trait->info_traitement;
                                $id_cat = $val_trait->categorie_id;
                            }
                        }

                         $cats = $this->cat->getNomcategorieById((int) $id_cat);

                        foreach ($cats as $val_cat) {
                            $libelle_cat = $val_cat->info_categorie;
                        }



                        $data['type_cat'] = 'act';
                        $data['libelle_cat'] = $libelle_cat;
                        $data['id_cat'] = $id_cat;

                        $data['libelle_trait'] = $libelle_trait;
                        $data['id_trait'] = $id_trait;

                        $data['libelle_op'] = $libelle_op;
                        $data['id_op'] = $id_op;


                    }

                    $data['id_proc'] = $id_proc;
                    $data['libelle_proc'] = $libelle_proc;

                    $this->load->view('back/supprimer_process_view.php', $data);
                }
            }

            $this->load->view('includes/footer_admin.php');
            $this->load->view('includes/js.php');
            // END APPEL VUE
        }else{
            redirect('login');
        }

    }


    public function routage()
    {
        $level = $this->session->userdata('level');        

        if($this->session->userdata('loggin') && $level =="admin"){

            if(($this->input->post('id_entre') || $this->input->post('canal')) && $this->input->post('ajax') =="1"){    

                $this->session->unset_userdata('entre');
                $this->session->unset_userdata('canal');

                $this->session->set_userdata('entre', $this->input->post('id_entre'));
                $this->session->set_userdata('canal', $this->input->post('canal'));

                echo site_url('back/gestion_process/normal');
            }else{

                echo site_url('back/gestion_process');
            }

        }else{
            redirect('login');
        }

    }


    public function cheminement_cat()
    {

        $level = $this->session->userdata('level');        

        if($this->session->userdata('loggin') && $level =="admin" && $this->input->post('ajax') == '1'){

            $id_cat = (int) $this->input->post('id_categorie');

            $liste_traits = $this->trait->liste_traitement_by_categorieid($id_cat);

            if(!empty($liste_traits)){

                foreach ($liste_traits as $val_trait) {
                  echo $val_trait->cey_traitement_id."||".ascii_to_entities($val_trait->info_traitement)."||".$val_trait->process_id."|||";
                }

            }


        }else{
            redirect('login');
        }

    }


    public function cheminement_op()
    {

        $level = $this->session->userdata('level');        

        if($this->session->userdata('loggin') && $level =="admin" && $this->input->post('ajax') == '1'){

            $id_trait = (int) $this->input->post('id_traitement');

            $liste_ops = $this->op->liste_operation_by_traitement($id_trait);

            if(!empty($liste_ops)){

                foreach ($liste_ops as $val_op) {
                  echo $val_op->cey_operation_id."||".ascii_to_entities($val_op->info_operation)."||".$val_op->process_id."|||";
                }

            }


        }else{
            redirect('login');
        }

    }   


    public function  cheminement_act()
    {
        $level = $this->session->userdata('level');        

        if($this->session->userdata('loggin') && $level =="admin" && $this->input->post('ajax') == '1'){

            $id_act = (int) $this->input->post('id_operation');

            $liste_acts = $this->act->liste_action_by_operation($id_act);

            if(!empty($liste_acts)){

                foreach ($liste_acts as $val_act) {
                  echo $val_act->cey_action_id."||".ascii_to_entities($val_act->info_action)."||".$val_act->process_id."|||";
                }

            }

        }else{
            redirect('login');
        }
    }


    public function ajouter_procs()
    {
        $level = $this->session->userdata('level');

        if($this->session->userdata('loggin') && $level =="admin"){

            
            if($this->input->post('ajax') == 'envoi-3-1-3'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_trait', 'Catégorie 1', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_op', 'Catégorie 2', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_act', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);

                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $nouveau_libelle_trait = $this->input->post('nouveau_libelle_trait');
                    $nouveau_libelle_op = $this->input->post('nouveau_libelle_op');
                    $nouveau_libelle_act = $this->input->post('nouveau_libelle_act');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $nouveau_libelle_trait,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }

                    $data_trait = array(
                            'info_traitement' => $nouveau_libelle_op,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => 0,
                            'ordre' => $dern_ord_trait

                        );

                    $id_trait = $this->trait->ajouter_trait($data_trait);

                    $ordre_op = $this->op->ordre_dern((int) $id_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }

                    $data_op = array(
                            'info_operation' => $nouveau_libelle_act,
                            'traitement_id' => (int) $id_trait,
                            'process_id' => 0,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $id_op = $this->op->ajouter_op($data_op);

                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'action',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);



                    $ordre_act = $this->act->ordre_dern((int) $id_proc);

                    if(!empty($ordre_act) && $ordre_act != false){

                        foreach ($ordre_act as $val_ord) {
                            $dern_ord_act = $val_ord->ordre +1;                            
                        }

                    }else{

                        $dern_ord_act = 1;  
                    }


                    $data_act = array(
                            'info_action' => $libelle_proc,
                            'operation_id' => (int) $id_op,
                            'process_id' => (int) $id_proc,
                            'entre_id' => (int) $entre,
                            'ordre' => $dern_ord_act
                        );
                    
                    // TRAITEMENT A PARTIR DE LA TABLE (cey_user)
                    $act = $this->act->ajouter_act($data_act);


                    if($act) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-3-1-2'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_trait', 'Catégorie 1', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_op', 'Catégorie 2', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);

                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $nouveau_libelle_trait = $this->input->post('nouveau_libelle_trait');
                    $nouveau_libelle_op = $this->input->post('nouveau_libelle_op');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $nouveau_libelle_trait,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }

                    $data_trait = array(
                            'info_traitement' => $nouveau_libelle_op,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => 0,
                            'ordre' => $dern_ord_trait

                        );

                    $id_trait = $this->trait->ajouter_trait($data_trait);

                    $ordre_op = $this->op->ordre_dern((int) $id_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }




                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'operation',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);





                    $data_op = array(
                            'info_operation' => $libelle_proc,
                            'traitement_id' => (int) $id_trait,
                            'process_id' => $id_proc,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $ops = $this->op->ajouter_op($data_op);


                    if($ops) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }


            }else if($this->input->post('ajax') == 'envoi-3-1-1'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_trait', 'Catégorie 1', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);


                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $nouveau_libelle_trait = $this->input->post('nouveau_libelle_trait');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $nouveau_libelle_trait,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }



                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'traitement',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);




                    $data_trait = array(
                            'info_traitement' => $libelle_proc,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => $id_proc,
                            'ordre' => $dern_ord_trait

                        );

                    $trait = $this->trait->ajouter_trait($data_trait);

                    
                    if($trait) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }


            }else if($this->input->post('ajax') == 'envoi-2-1-2'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                
                $this->form_validation->set_rules('nouveau_libelle_op', 'Catégorie 2', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_act', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');
                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_cat = $this->input->post('choix_cat');
                    $nouveau_libelle_op = $this->input->post('nouveau_libelle_op');
                    $nouveau_libelle_act = $this->input->post('nouveau_libelle_act');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $ordre_trait = $this->trait->ordre_dern((int) $choix_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }

                    $data_trait = array(
                            'info_traitement' => $nouveau_libelle_op,
                            'categorie_id' => (int) $choix_cat,
                            'entre_id' => $entre,
                            'process_id' => 0,
                            'ordre' => $dern_ord_trait

                        );

                    $id_trait = $this->trait->ajouter_trait($data_trait);

                    $ordre_op = $this->op->ordre_dern((int) $id_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }

                    $data_op = array(
                            'info_operation' => $nouveau_libelle_act,
                            'traitement_id' => (int) $id_trait,
                            'process_id' => 0,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $id_op = $this->op->ajouter_op($data_op);

                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'action',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);



                    $ordre_act = $this->act->ordre_dern((int) $id_proc);

                    if(!empty($ordre_act) && $ordre_act != false){

                        foreach ($ordre_act as $val_ord) {
                            $dern_ord_act = $val_ord->ordre +1;                            
                        }

                    }else{

                        $dern_ord_act = 1;  
                    }


                    $data_act = array(
                            'info_action' => $libelle_proc,
                            'operation_id' => (int) $id_op,
                            'process_id' => (int) $id_proc,
                            'entre_id' => (int) $entre,
                            'ordre' => $dern_ord_act
                        );
                    
                    // TRAITEMENT A PARTIR DE LA TABLE (cey_user)
                    $act = $this->act->ajouter_act($data_act);


                    if($act) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-2-1-1'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                
                $this->form_validation->set_rules('nouveau_libelle_op', 'Catégorie 2', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');
                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_cat = $this->input->post('choix_cat');
                    $nouveau_libelle_op = $this->input->post('nouveau_libelle_op');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $ordre_trait = $this->trait->ordre_dern((int) $choix_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }

                    $data_trait = array(
                            'info_traitement' => $nouveau_libelle_op,
                            'categorie_id' => (int) $choix_cat,
                            'entre_id' => $entre,
                            'process_id' => 0,
                            'ordre' => $dern_ord_trait

                        );

                    $id_trait = $this->trait->ajouter_trait($data_trait);

                    $ordre_op = $this->op->ordre_dern((int) $id_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }

                   
                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'operation',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);

                    $data_op = array(
                            'info_operation' => $libelle_proc,
                            'traitement_id' => (int) $id_trait,
                            'process_id' => $id_proc,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $op = $this->op->ajouter_op($data_op);

                    if($op) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-1-1-1'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('nouveau_libelle_act', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_trait = $this->input->post('choix_trait');
                    $nouveau_libelle_act = $this->input->post('nouveau_libelle_act');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $ordre_op = $this->op->ordre_dern((int) $choix_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }

                    $data_op = array(
                            'info_operation' => $nouveau_libelle_act,
                            'traitement_id' => (int) $choix_trait,
                            'process_id' => 0,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $id_op = $this->op->ajouter_op($data_op);

                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'action',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);



                    $ordre_act = $this->act->ordre_dern((int) $id_proc);

                    if(!empty($ordre_act) && $ordre_act != false){

                        foreach ($ordre_act as $val_ord) {
                            $dern_ord_act = $val_ord->ordre +1;                            
                        }

                    }else{

                        $dern_ord_act = 1;  
                    }


                    $data_act = array(
                            'info_action' => $libelle_proc,
                            'operation_id' => (int) $id_op,
                            'process_id' => (int) $id_proc,
                            'entre_id' => (int) $entre,
                            'ordre' => $dern_ord_act
                        );
                    
                    // TRAITEMENT A PARTIR DE LA TABLE (cey_user)
                    $act = $this->act->ajouter_act($data_act);


                    if($act) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    

                    

                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('nouveau_libelle_act' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-nouveau'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_trait', 'Catégorie 1', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_op', 'Catégorie 2', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_cat', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);

                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $libelle_trait = $this->input->post('libelle_trait');
                    $libelle_op = $this->input->post('libelle_op');
                    $libelle_cat = $this->input->post('libelle_cat');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $libelle_cat,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }

                    $data_trait = array(
                            'info_traitement' => $libelle_trait,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => 0,
                            'ordre' => $dern_ord_trait

                        );

                    $id_trait = $this->trait->ajouter_trait($data_trait);

                    $ordre_op = $this->op->ordre_dern((int) $id_trait);

                    if(!empty($ordre_op) && $ordre_op != false){

                        foreach ($ordre_op as $val_ord) {
                            $dern_ord_op = $val_ord->ordre +1;                            
                        }

                    }else{
                      $dern_ord_op = 1;  
                    }

                    $data_op = array(
                            'info_operation' => $libelle_op,
                            'traitement_id' => (int) $id_trait,
                            'process_id' => 0,
                            'entre_id' => $entre,
                            'ordre' => $dern_ord_op
                        );

                    $id_op = $this->op->ajouter_op($data_op);

                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'action',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);



                    $ordre_act = $this->act->ordre_dern((int) $id_proc);

                    if(!empty($ordre_act) && $ordre_act != false){

                        foreach ($ordre_act as $val_ord) {
                            $dern_ord_act = $val_ord->ordre +1;                            
                        }

                    }else{

                        $dern_ord_act = 1;  
                    }


                    $data_act = array(
                            'info_action' => $libelle_proc,
                            'operation_id' => (int) $id_op,
                            'process_id' => (int) $id_proc,
                            'entre_id' => (int) $entre,
                            'ordre' => $dern_ord_act
                        );
                    
                    // TRAITEMENT A PARTIR DE LA TABLE (cey_user)
                    $act = $this->act->ajouter_act($data_act);


                    if($act) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_cat' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-nouveau-2'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_trait', 'Catégorie 1', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_cat', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);

                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $libelle_trait = $this->input->post('libelle_trait');
                    $libelle_cat = $this->input->post('libelle_cat');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $libelle_cat,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }


                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'traitement',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);


                    $data_trait = array(
                            'info_traitement' => $libelle_trait,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => (int) $id_proc,
                            'ordre' => $dern_ord_trait

                        );

                    $trait = $this->trait->ajouter_trait($data_trait);

                    
                    if($trait) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_cat' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }
            
            }else if($this->input->post('ajax') == 'envoi-nouveau-1'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('libelle_cat', 'Catégorie 3', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {
                    
                    $entre = (int) $this->session->userdata('entre');

                    $ordre_dern = $this->cat->ordre_dern($entre);

                    if(!empty($ordre_dern) && $ordre_dern != false){
                        foreach ($ordre_dern as $val_ord) {
                            $ordre = $val_ord->ordre +1;                            
                        }
                    }else{
                        $ordre = 1;
                    }

                    

                    $libelle_proc = $this->input->post('libelle_proc');
                    $libelle_cat = $this->input->post('libelle_cat');



                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $data_cat = array(
                            'info_categorie' =>  $libelle_cat,
                            'entre_id' => $entre,
                            'ordre' => $ordre
                        );

                    $id_cat = $this->cat->ajouter_cat($data_cat);

                    $ordre_trait = $this->trait->ordre_dern((int) $id_cat);

                    if(!empty($ordre_trait) && $ordre_trait != false){

                        foreach ($ordre_trait as $val_ord) {
                            $dern_ord_trait = $val_ord->ordre +1;                            
                        }
                         
                    }else{

                        $dern_ord_trait = 1;
                    }


                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'traitement',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);


                    $data_trait = array(
                            'info_traitement' => $libelle_proc,
                            'categorie_id' => (int) $id_cat,
                            'entre_id' => $entre,
                            'process_id' => (int) $id_proc,
                            'ordre' => $dern_ord_trait

                        );

                    $trait = $this->trait->ajouter_trait($data_trait);

                    
                    if($trait) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }
                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_cat' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_trait' ,'<div class="alert alert-danger" align="center">' ,'</div>')."||".form_error('libelle_op' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }
            
            }else if($this->input->post('ajax') == 'envoi-cat'){

                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {

                    $entre = (int) $this->session->userdata('entre');

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_cat = $this->input->post('choix_cat');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');

                    $matricule = $this->session->userdata('mle');

                    $data_proc = array(
                        'libelle' => $libelle_proc,
                        'type' => 'traitement',
                        'entre_id' => $entre,
                        'tel' => (int) $canal_tel,
                        'mail' => (int) $canal_mail,
                        'courrier' => (int) $canal_courrier,
                        'matricule' => $matricule
                    );

                    $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                    $data_ref_proc = array('process_id' => (int) $id_proc);

                    $this->ref->editer_process($data_ref_proc, (int) $id_proc);

                    $ordres = $this->trait->ordre_dern((int) $choix_cat);

                    if($ordres){
                        foreach ($ordres as $val_ord) {
                            $ordre = (int) $val_ord->ordre+1;
                        }

                    }else{
                        $ordre =1;
                    }

                    $data_trait = array(
                        'ordre' => $ordre,
                        'categorie_id' => (int) $choix_cat,
                        'flag' => 1,
                        'info_traitement' => $libelle_proc,
                        'entre_id' => $entre,
                        'process_id' => (int) $id_proc

                    );

                    $trait = $this->trait->ajouter_trait($data_trait);


                    if($trait) {
                        
                        echo "OK";


                    }else{
                        
                        echo 'erreur';

                    }



                    if($canal_tel == '1'){

                        $data_tel = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'tel' 
                            );

                        $this->mars->ajouter_processus($data_tel);
                    }
                    
                    if($canal_mail == '1'){
                        

                        $data_mail = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'mail' 
                            );

                        $this->mars->ajouter_processus($data_mail);
                    }
                    
                    if($canal_courrier == '1'){
                        

                        $data_courrier = array(
                                'parent_id' => $id_proc,
                                'ordre' => 1,
                                'alias' => 'P1',
                                'entre_id' => (int) $entre,
                                'canal' => 'courrier' 
                            );

                        $this->mars->ajouter_processus($data_courrier);
                    }

                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-cat-trait'){


                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {

                    $entre = (int) $this->session->userdata('entre');

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_trait = $this->input->post('choix_trait');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');


                    $traits = $this->trait->liste_traitement_by_id((int) $choix_trait);

                    foreach ($traits as $val_trait) {
                        $test_process_id = $val_trait->process_id;                        
                    }


                    if($test_process_id != 0){

                        echo "erreur-process";

                    }else{

                        $matricule = $this->session->userdata('mle');

                        $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'operation',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                        $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                        $data_ref_proc = array('process_id' => (int) $id_proc);

                        $this->ref->editer_process($data_ref_proc, (int) $id_proc);

                        $ordres = $this->op->ordre_dern((int) $choix_trait);

                        if($ordres){
                            foreach ($ordres as $val_ord) {
                                $ordre = (int) $val_ord->ordre+1;
                            }

                        }else{
                            $ordre =1;
                        }

                        $data_op = array(
                            'ordre' => $ordre,
                            'traitement_id' => (int) $choix_trait,
                            'flag' => 1,
                            'info_operation' => $libelle_proc,
                            'entre_id' => $entre,
                            'process_id' => (int) $id_proc

                        );

                        $ops = $this->op->ajouter_op($data_op);


                        if($ops) {
                            
                            echo "OK";


                        }else{
                            
                            echo 'erreur';

                        }



                        if($canal_tel == '1'){

                            $data_tel = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'tel' 
                                );

                            $this->mars->ajouter_processus($data_tel);
                        }
                        
                        if($canal_mail == '1'){
                            

                            $data_mail = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'mail' 
                                );

                            $this->mars->ajouter_processus($data_mail);
                        }
                        
                        if($canal_courrier == '1'){
                            

                            $data_courrier = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'courrier' 
                                );

                            $this->mars->ajouter_processus($data_courrier);
                        }
                    }

                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }else if($this->input->post('ajax') == 'envoi-cat-trait-op'){


                // VALIDATION DES CHAMPS 
                $this->form_validation->set_rules('libelle_proc', 'Libelle processus', 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

                // PERSONNALISATION DES MESSAGES D'ERREUR
                $this->form_validation->set_message('min_length', 'longueur de champs invalide');
                $this->form_validation->set_message('htmlspecialchars', 'caractères invalide');
            
                // TRAITEMENT DU FORMULAIRE
                if($this->form_validation->run()) {

                    $entre = (int) $this->session->userdata('entre');

                    $libelle_proc = $this->input->post('libelle_proc');
                    $choix_op = $this->input->post('choix_op');

                    $canal_tel = $this->input->post('canal_tel');
                    $canal_mail = $this->input->post('canal_mail');
                    $canal_courrier = $this->input->post('canal_courrier');


                    $ops = $this->op->liste_operation_by_id((int) $choix_op);

                    foreach ($ops as $val_op) {
                        $test_process_id = $val_op->process_id;                        
                    }


                    if($test_process_id != 0){

                        echo "erreur-process";

                    }else{

                        $matricule = $this->session->userdata('mle');

                        $data_proc = array(
                            'libelle' => $libelle_proc,
                            'type' => 'action',
                            'entre_id' => $entre,
                            'tel' => (int) $canal_tel,
                            'mail' => (int) $canal_mail,
                            'courrier' => (int) $canal_courrier,
                            'matricule' => $matricule
                        );

                        $id_proc = $this->ref->ajouter_ref_proc($data_proc);

                        $data_ref_proc = array('process_id' => (int) $id_proc);

                        $this->ref->editer_process($data_ref_proc, (int) $id_proc);

                        $ordres = $this->act->ordre_dern((int) $choix_op);

                        //var_dump($ordres);

                        if($ordres){
                            foreach ($ordres as $val_ord) {
                                $ordre = (int) $val_ord->ordre + 1;
                            }

                        }else{
                            $ordre =1;
                        }

                        $data_act = array(
                            'ordre' => $ordre,
                            'operation_id' => (int) $choix_op,
                            'flag' => 1,
                            'info_action' => $libelle_proc,
                            'entre_id' => $entre,
                            'process_id' => (int) $id_proc

                        );

                        $acts = $this->act->ajouter_act($data_act);


                        if($acts) {
                            
                            echo "OK";


                        }else{
                            
                            echo 'erreur';

                        }



                        if($canal_tel == '1'){

                            $data_tel = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'tel' 
                                );

                            $this->mars->ajouter_processus($data_tel);
                        }
                        
                        if($canal_mail == '1'){
                            

                            $data_mail = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'mail' 
                                );

                            $this->mars->ajouter_processus($data_mail);
                        }
                        
                        if($canal_courrier == '1'){
                            

                            $data_courrier = array(
                                    'parent_id' => $id_proc,
                                    'ordre' => 1,
                                    'alias' => 'P1',
                                    'entre_id' => (int) $entre,
                                    'canal' => 'courrier' 
                                );

                            $this->mars->ajouter_processus($data_courrier);
                        }
                    }

                    
                    
                }else{
                    echo form_error('libelle_proc' ,'<div class="alert alert-danger" align="center">' ,'</div>');
                }

            }
                    
        }else{
            redirect('login');
        }
    }


    public function supprimer_procs(){

        $level = $this->session->userdata('level');

        if($this->session->userdata('loggin') && $level == "admin"){

            if( ! ini_get('date.timezone') )
            {
                date_default_timezone_set('Africa/Nairobi');
            }

            $id_pro = (int) $this->input->post('id_proc');

            $data_suppr = array(
                    'flag' => 0,
                );

            $date_suppr_ref = array(
                    'flag' => 0,
                    'delete_process' => date('Y-m-d H:i:s.u')
                );

            $this->ref->editer_reference_process($date_suppr_ref, $id_pro);


            if($this->input->post('ajax') == "action"){

                $this->act->editer_act($data_suppr, (int) $id_pro);

                if($this->input->post('id_cat') && $this->input->post('id_trait') && $this->input->post('id_op')){

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));
                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));
                    $this->op->editer_op($data_suppr, (int) $this->input->post('id_op'));

                }elseif ($this->input->post('id_cat') && $this->input->post('id_trait')) {

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));
                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));

                }elseif ($this->input->post('id_cat') && $this->input->post('id_op')) {

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));
                    $this->op->editer_op($data_suppr, (int) $this->input->post('id_op'));

                }elseif ($this->input->post('id_trait') && $this->input->post('id_op')) {

                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));
                    $this->op->editer_op($data_suppr, (int) $this->input->post('id_op'));

                }else if ($this->input->post('id_op')) {

                    $this->op->editer_op($data_suppr, (int) $this->input->post('id_op'));

                }else if ($this->input->post('id_cat')) {

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));

                }else if ($this->input->post('id_trait')) {

                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));

                }


            }

            if($this->input->post('ajax') == "operation"){

                $this->op->editer_op_byprocid($data_suppr, (int) $id_pro);

                if($this->input->post('id_cat') && $this->input->post('id_trait')){

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));
                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));

                }else if($this->input->post('id_cat')){

                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));

                }else if($this->input->post('id_trait')){

                    $this->trait->editer_trait($data_suppr, (int) $this->input->post('id_trait'));

                }

            }

            if($this->input->post('ajax') == "traitement"){

                $this->trait->editer_trait_ByprocessId($data_suppr, (int) $id_pro);

                if($this->input->post('id_cat')){
                    
                    $this->cat->editer_cat($data_suppr, (int) $this->input->post('id_cat'));
                
                }
            }


            echo site_url('back/gestion_process/normal');


        }else{
            redirect('login');
        }

    }

}