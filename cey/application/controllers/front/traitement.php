<?php


class Traitement extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_historique','hist');
        $this->load->model('cey_marche','procs');
        $this->load->model('cey_arret','acts');
        $this->load->model('cey_reference_process','ref');
        $this->load->model('cey_categorie','cat');
        $this->load->model('cey_traitement','trait');
        $this->load->model('cey_operation','op');
        $this->load->model('cey_action','act');
        $this->load->model('cey_entre','entr');
    }

    

    public function index()
    {

        $this->traitement();

    }


    public function traitement()
    {
        
        if($this->session->userdata('loggin')){

            //var_dump($this->agent->referrer());
            
            //** CODE **
            $level = $this->session->userdata('level');
            $id_traitement = $this->session->userdata('traitement_id');
            $canal = $this->session->userdata('canal');
            $bind_processus = $this->procs->liste_processus($id_traitement, $canal);

            $act = array();

            $var_js = "var tp= [];";
           // $var_fct_js = "";
            $deb = True;

            if(!empty($bind_processus)){
                foreach ($bind_processus as $proc) {
                    
                    if ($deb) {
                        $deb = False;
                        $var_js .= "var first_proc = $proc->cey_marche_id;";
                        $deb_proc = $proc->cey_marche_id;
                    }

                    $temp = $this->acts->liste_action($proc->cey_marche_id);
                    $ascii = ascii_to_entities($proc->libelle);
                    $var_js .= "tp[$proc->cey_marche_id] = \"$ascii\";";
                    //$var_fct_js .= "fct_".$proc->cey_process_id."();";
                    $act[$proc->cey_marche_id] = $temp;

                    
                }
            
            }



            $var_js_control = "var s_url_acc = "."\"".site_url("front/historique")."\";";


            $ref_procs = $this->ref->liste_reference_by_id($id_traitement);

            if(!empty($ref_procs)){
                foreach ($ref_procs as $val_proc) {
                    $libelle_procs = $val_proc->libelle;
                    $type_proc = $val_proc->type;
                }

                if($type_proc == "action"){

                        $actions = $this->act->getactionById($id_traitement);

                        foreach ($actions as $val_act) {
                            $id_op = $val_act->operation_id;
                        }

                        $data['id_action'] = $id_op;

                        $operations = $this->op->getoperationById($id_op);

                        if(!empty($operations)){
                            foreach ($operations as $val_op) {
                                $nom_operation = $val_op->info_operation;
                                $id_ops = $val_op->traitement_id;
                            }
                        }

                        $traitements = $this->trait->getNomtraitementById($id_ops);

                        if(!empty($traitements)){
                            foreach ($traitements as $val_trait) {
                                $nom_traitement = $val_trait->info_traitement;
                                $id_cats = $val_trait->categorie_id;
                            }
                        }


                        $categories = $this->cat->getNomcategorieById($id_cats);

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

                        //$test = "op = ".$nom_operation." trait =".$nom_traitement." cat =".$nom_categorie." entre=".$nom_entre;
                        //var_dump($test);

                }
                if($type_proc == "operation"){

                        $operations = $this->op->getoperationByprocessId($id_traitement);

                        if(!empty($operations)){
                            foreach ($operations as $val_op) {
                                $id_ops = $val_op->traitement_id;
                            }
                        }



                        $data['id_operation'] = $id_ops;
                        
                        $traitements = $this->trait->getNomtraitementById($id_ops);

                        if(!empty($traitements)){
                            foreach ($traitements as $val_trait) {
                                $nom_traitement = $val_trait->info_traitement;
                                $id_cats = $val_trait->categorie_id;
                            }
                        }

                        $categories = $this->cat->getNomcategorieById($id_cats);

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
                }
                if($type_proc == "traitement"){

                        $traitements = $this->trait->gettraitementById_process($id_traitement);

                        if(!empty($traitements)){
                            foreach ($traitements as $val_trait) {
                                $id_cats = $val_trait->categorie_id;
                            }
                        }


                        $data['id_traitement'] = $id_cats;

                        $categories = $this->cat->getNomcategorieById($id_cats);

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

                }

            }

           //var_dump($consigne);

            //** PARAMETRE VUE **
            $data['titre'] = 'TRAITEMENT';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global');
            $data['js'] = array('js/global.js','js/back.js', 'js/back.js');
            $data['level'] = $level;

            if(!empty($ref_procs)){
                if($type_proc == "action"){
                    $data['nom_entre'] = $nom_entre;
                    $data['nom_categorie'] = $nom_categorie;
                    $data['nom_traitement'] = $nom_traitement;
                    $data['nom_operation'] = $nom_operation;
                    $data['type_proc'] = $type_proc;
                }
                if($type_proc == "operation"){
                    $data['nom_entre'] = $nom_entre;
                    $data['nom_categorie'] = $nom_categorie;
                    $data['nom_traitement'] = $nom_traitement;
                    $data['type_proc'] = $type_proc;
                }
                if($type_proc == "traitement"){
                    $data['nom_entre'] = $nom_entre;
                    $data['nom_categorie'] = $nom_categorie;
                    $data['type_proc'] = $type_proc;
                }
            }

            $data['libelle_procs'] = $libelle_procs;

            if(!empty($bind_processus)){
                $data['lst_proc'] = $bind_processus;
                $data['lst_act'] = $act;
               
                $data['deb_proc'] = $deb_proc;
                $data['js_info'] = array($var_js, $var_js_control);

                //$data['script_login'] = $this->convertHtag($bind_processus);

            }
            

            //** END PARAMETRE VUE **
            
            //** APPEL VUE **
            $this->load->view('includes/header_traitement.php', $data);
            $this->load->view('includes/menu_vertical_traitement.php', $data);
            $this->load->view('includes/menu_horizental.php', $data);


            if(!empty($bind_processus)){
                foreach ($bind_processus as $proc) {
                    
                    if($proc->type =="popup" && $proc->active_popup_all == 1){

                        $data['libelle_pop'] = $proc->libelle;
                        
                        $data['id_proc_pop'] = $proc->cey_marche_id;
                        
                    }

                    
                }
            
            }


            $this->load->view('front/traitement_view.php', $data);


            if(!empty($bind_processus)){
                foreach ($bind_processus as $proc) {
                    
                    if($proc->type =="popup"){

                        $acts = $this->acts->liste_action($proc->cey_marche_id);

                        $data_pop['text_html'] = $proc->text_html;

                        $data_pop['libelle'] = $proc->libelle;
                        
                        $data_pop['id_proc'] = $proc->cey_marche_id;

                        $data_pop['active_all'] = $proc->active_popup_all;

                        if(!empty($acts)){

                            $data_pop['acts'] = $acts;

                        }



                        $this->load->view('front/popup_process_view.php', $data_pop);

                    }

                }
            
            }


            $this->load->view('front/popup_stop_view.php', $data);
            $this->load->view('includes/footer.php');
            
            
                        
            $this->load->view('includes/js.php');

            //** END APPEL VUE **
        }else{
            redirect('login');
        }

    }

    public function deviation()
    {
        if($this->session->userdata('loggin')  && $this->session->userdata('traitement_id') && $this->session->userdata('connection_id')){
            
            $rq = $this->hist->ajouter_historique(0, $this->session->userdata('connection_id'), -2, $this->session->userdata('mle'));
            
            if($rq != false){
                $this->session->unset_userdata('connection_id');
                $this->session->unset_userdata('traitement_id');
            }

            $level = $this->session->userdata('level');

            if($level == "admin"){
                redirect('back/gestion_process/normal');
            }else{
                redirect('front/accueil');
            }

        }else{
            redirect('login');
        }
    }


    public function convertHtag($chaine){

        if(!empty($chaine)){
            foreach ($chaine as $val_ch) {
                if($val_ch->libelle == "Script d'introduction"){
                    $str = $val_ch->text_html;
                }
            }


            $remplace   = array();
            $remplace[0]= $this->session->userdata('prenom');
            /*$remplace[1]='<input type="text" name="process"/>';*/
            $regex=array();
            $regex[0] = '/(%login)/i';
            /*$regex[1] = '/(%input)/i';*/
            if(!empty($str)){
                $res = preg_replace($regex, $remplace, $str);

                return $res;
            }
        }

 

    }

} 