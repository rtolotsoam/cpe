<?php


class Processus extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_reference_process','ref');
        
        $this->load->model('cey_marche','procs');
        $this->load->model('cey_arret','acts');

    }

    

    public function index()
    {

        $this->processus();

    }

    // INSERTION DES PROCESSUS
    public function processus()
    {
        $level = $this->session->userdata('level');

        if($this->session->userdata('loggin') && $level == "admin"){

            //** CODE **
            $js_ck = "assets/components/modules/admin/forms/editors/ckeditor"; 

            $canal = $this->session->userdata('canal');

            $pcs = $this->procs->liste_processus($this->session->userdata('traitement_id'), $canal);


            $references = $this->ref->liste_reference_by_id($this->session->userdata('traitement_id'));

            if(!empty($references)){
                foreach ($references as $val_trait) {
                    $temp = $val_trait->libelle;
                }
            }

            $data_pcs['reference'] = $temp;
            $data_pcs["lst_proc"] = $pcs;

            //** END CODE **
			
            //** PARAMETRE VUE **
            $data['titre'] = 'PROCESSUS';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.global','admin/module.admin.page.modals.min');
            $data['js'] = array('js/admin_processus.js','js/admin_processus_edit.js','js/back.js');
            $data['level'] = $level;
            $data['gestion_usr'] = $this->session->userdata('gestion_user');
            $data['gestion_proc'] = $this->session->userdata('gestion_process');
            //** END PARAMETRE VUE **
        


            $fin_proc = $this->procs->liste_processus_dern($this->session->userdata('traitement_id'), $canal);

            foreach ($fin_proc as $val_fin) {
                $dern = $val_fin->cey_marche_id;
                $dern_ordre = $val_fin->ordre;
            }

            $data_send_pcs['dern'] = $dern;
            $data['dern'] = $dern;
            $data_send_pcs['dern_ordre'] = $dern_ordre;

            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical_traitement.php', $data);

            $this->load->view('includes/menu_horizental_processus.php', $data_pcs);
            //$this->load->view('back/processus_view.php', $data);


            // GESTION MODIFICATION PROCESSUS


            $list = array();
            foreach($pcs as $row)  {
                $list[$row->cey_marche_id] = $row->alias;
            }
            
            $list[0] = "FIN DE TRAITEMENT";
            $data_procs["list_pcs"]  = $list;
            $this->load->view('back/processus_popup_bouton_ajout_view.php', $data_procs);
        

            $this->load->view('back/processus_head_wizard_view.php');
            $this->load->view('back/processus_menu_wizard_view.php', $data_pcs);
                    
            foreach ($pcs as $proc_row) {

                $proc_row_id = $proc_row->cey_marche_id;           
                $data_act_res = $this->acts->liste_action($proc_row_id);
                $data_send_pcs["lst_proc"] = $proc_row;
                $data_send_pcs["lst_acts"] = $data_act_res;

                $data_send_pcs['area_html_'.$proc_row_id] = array(
        
                //ID of the textarea that will be replaced
                'id'    =>  'area_html_'.$proc_row_id,
                'path'  =>  $js_ck,
            
                //Optionnal values
                'config' => array(
                    'toolbar'   =>  "Full",     //Using the Full toolbar
                    'width'     =>  "100%",    //Setting a custom width
                    'height'    =>  "100%",    //Setting a custom height
                    'filebrowserBrowseUrl' => "/cey/assets/components/modules/admin/forms/editors/ckeditor/ckfinder/ckfinder.html"
                    
                    )
                );




                $this->load->view('back/processus_content_wizard_view.php', $data_send_pcs);

                $procs = $this->procs->get_processus_by_id($proc_row_id);
                $data_procs_visu['lst_pcs'] = $procs;
                $this->load->view('back/processus_popup_visualiser_view.php', $data_procs_visu);


                if(!empty($data_act_res)){
                    foreach ($data_act_res as $val_act) {
                        $id_act = $val_act->cey_arret_id;
                        $libelle_act = $val_act->libelle;
                        $id_process_act = $val_act->marche_redirect_id;

                        $data_procs['id_act'] = $id_act;
                        $data_procs['libelle_act'] = $libelle_act;
                        $data_procs['id_process_act'] = $id_process_act;

                        $this->load->view('back/processus_popup_modif_bouton_view.php', $data_procs);
                        $this->load->view('back/processus_popup_suppr_bouton_view.php', $data_procs);

                    }

                }

            }

            
            foreach ($pcs as $val_proc) {
                $id_proc = $val_proc->cey_marche_id;
                $libelle_proc = $val_proc->libelle;
                $alias_proc = $val_proc->alias;

                $data_suppr_proc['id_proc'] = $id_proc;
                $data_suppr_proc['libelle_proc'] = $libelle_proc;
                $data_suppr_proc['alias_proc'] = $alias_proc;

                $this->load->view('back/processus_popup_suppr_proccess_view.php', $data_suppr_proc);
            }

            $this->load->view('back/processus_foot_wizard_view.php');




            // END GESTION MODIFICATION PROCESSUS


            $this->load->view('includes/footer_admin.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }

    }


    // EDITER PROCESSUS POUR AJOUTER DES PROCESS OU ACTION
    public function editer_processus() {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){

            $libe = $this->input->post("txt_libelle");
            $htm = $this->input->post("area_html");
            $type_aff = $this->input->post("type_aff");

            $data_send = array(
                "text_html" => $htm
                ,"libelle" => $libe
                ,"type" => $type_aff
            );

            $proc_id = $this->input->post("procid");
            $this->procs->editer_processus($data_send,$proc_id);

        }else{
            redirect('login');
        }
    }

    // PERMET D'AJOUTER DES BOUTON DANS LE PROCESSUS
    public function ajbtn()
    {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){


            
            $lib_in = $this->input->post("txt_libelle");
            $procid_in = $this->input->post("procid");
            $proc_red_id_in = $this->input->post("procred");
            $entre = $this->session->userdata('entre');
            $canal = $this->session->userdata('canal');
            $parent_id = $this->session->userdata('traitement_id');
            
            $data_new = array(
                "libelle" => $lib_in
                , "marche_id" => $procid_in
                , "marche_redirect_id" => $proc_red_id_in
                , "entre_id" => $entre
                , "parent_id" => $parent_id
                , "canal" => $canal
            );
            
            $ret = $this->acts->ajouter_action($data_new);
            echo site_url('back/processus');

        }else{
            redirect('login');
        }
    }


    // AJOUTER PROCESSUS POUR L'EDITER
    public function ajouter_processus() {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){

            $id_camp = $this->input->post("id_camp");
            $ordre = $this->input->post("ordre");
            $canal = $this->session->userdata('canal');
            $entre = $this->session->userdata('entre');

            $ordre_alias = (int)$ordre+1;

            $alias = "P".$ordre_alias;

            $data_ajout = array(
                "canal" => $canal
                ,"parent_id" => $id_camp
                ,"ordre" => $ordre+1
                ,"alias" => $alias
                ,"entre_id" => (int) $entre
                ,"type" => 'normal'
            );

            $id_process = $this->procs->ajouter_processus($data_ajout);
            echo site_url('back/processus');

        }else{
            redirect('login');
        }
    }


    // PERMET DE MODIFIER BOUTON
    public function modif_bouton()
    {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){
            
            $lib_in = $this->input->post('txt_libelle');
            $procid_in = $this->input->post('procid');
            $proc_red_id_in = $this->input->post('procred');
            
            
            $data = array(
                'libelle' => $lib_in
                , 'marche_redirect_id' => $proc_red_id_in
            );
            
            $ret = $this->acts->editer_action($procid_in, $data);
            echo site_url('back/processus');

        }else{
            redirect('login');
        }
    }


    // PERMET DE SUPPRIMER BOUTON
    public function supprimer_bouton()
    {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){
            
            $procid_in = $this->input->post('procid');
            
            
            
            $data = array(
                'flag' => 0    
            );
            
            $ret = $this->acts->editer_action($procid_in, $data);
            echo site_url('back/processus');

        }else{
            redirect('login');
        }
    }


    // PERMET DE SUPPRIMER PROCESS
    public function supprimer_process()
    {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){
            
            $procid_in = $this->input->post('procid');
            
            
            
            $data = array(
                'flag' => 0    
            );
            
            $ret = $this->procs->editer_processus($data, $procid_in);
            echo site_url('back/processus');

        }else{
            redirect('login');
        }
    }


    


}