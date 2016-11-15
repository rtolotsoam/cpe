<?php


class Ajouter_processus extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();
        $this->load->model('cey_processus','procs');
        $this->load->helper('ckeditor');

    }

    

    public function index()
    {

        $this->ajouter_processus();

    }

    // INSERTION DES PROCESSUS
    public function ajouter_processus()
    {
        $level = $this->session->userdata('level');
        if($this->session->userdata('loggin') && $level == "admin"){

            //** CODE **
            $donnes = array(
                    'text_tel_html' => ''
            );

            $id_process = $this->procs->ajouter_processus($donnes);

            if($id_process){
                $data['id_process'] = $id_process;    
            }else{
                echo "erreur";
            }

            $js_ck = "assets/components/modules/admin/forms/editors/ckeditor"; 

            $data['ckeditor'] = array(
        
            //ID of the textarea that will be replaced
            'id'    =>  'ckeditor',
            'path'  =>  $js_ck,
        
            //Optionnal values
            'config' => array(
                'toolbar'   =>  "Full",     //Using the Full toolbar
                'width'     =>  "100%",    //Setting a custom width
                'height'    =>  '100%',    //Setting a custom height
                    
                )
            );


            $data['ckeditor2'] = array(
        
            //ID of the textarea that will be replaced
            'id'    =>  'ckeditor2',
            'path'  =>  $js_ck,
        
            //Optionnal values
            'config' => array(
                'toolbar'   =>  "Full",     //Using the Full toolbar
                'width'     =>  "100%",    //Setting a custom width
                'height'    =>  '100%',    //Setting a custom height
                    
                )
            );



            $data['ckeditor3'] = array(
        
            //ID of the textarea that will be replaced
            'id'    =>  'ckeditor3',
            'path'  =>  $js_ck,
        
            //Optionnal values
            'config' => array(
                'toolbar'   =>  "Full",     //Using the Full toolbar
                'width'     =>  "100%",    //Setting a custom width
                'height'    =>  '100%',    //Setting a custom height
                    
                )
            );


            $var_url_ajout_process = "var url_ajout_process = "."\"".site_url("back/ajouter_processus/editer_processus")."\";";
            $var_url_acc_proccess = "var url_acc_proccess ="."\"".site_url("back/gestion_process")."\";";

            //** END CODE **
			
            //** PARAMETRE VUE **
            $data['titre'] = 'AJOUTER PROCESSUS';
            $data['css'] = array('admin/module.global','admin/module.admin.page.modals.min');
            $data['level'] = $level;
            
            $data['gestion_usr'] = $this->session->userdata('gestion_user');
            $data['gestion_proc'] = $this->session->userdata('gestion_process');

            $data['js_info'] = array($var_url_ajout_process, $var_url_acc_proccess);
            $data['js'] = array('js/global.js');
            //** END PARAMETRE VUE **

            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('back/ajouter_processus_view.php', $data);
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
        if($this->session->userdata('loggin') && $level == "admin" && $this->input->post("ajax") == "1"){

            $data_tel = $this->input->post("data_tel");
            $data_mail = $this->input->post("data_mail");
            $data_courrier = $this->input->post("data_courrier");

            $data_send = array(
                "text_tel_html" => $data_tel
                ,"text_mail_html" => $data_mail
                ,"text_courrier_html" => $data_mail
            );

            $proc_id = $this->input->post("procid");
            if($this->procs->editer_processus($data_send, $proc_id)){
                echo "success";
            }else{
                echo "erreur";
            }

        }else{
            redirect('login');
        }
    }

}