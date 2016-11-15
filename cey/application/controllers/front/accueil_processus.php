<?php


class Accueil_processus extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_processus','procs');
        $this->load->model('cey_script','scps');
        $this->load->model('cey_hod','hod');

    }

    

    public function index($id)
    {
        $this->accueil_processus($id);

    }

    public function accueil_processus($id)
    {
        if($this->session->userdata('loggin')){

            $id_process = (int) $id;


            //** CODE **
            $processus = $this->procs->liste_processus($id_process);
            $level = $this->session->userdata('level'); 

            if(!empty($processus)){
                foreach ($processus as $val_pro) {
                
                    $intro = $val_pro->script_id_intro;

                    $conclusion = $val_pro->script_id_conclusion;

                    $tel = $val_pro->text_tel_html;

                    $mail = $val_pro->text_mail_html;

                    $courrier = $val_pro->text_courrier_html;

                    $hod_1 = $this->hod->liste_hod_by_id((int) $val_pro->hod_1);
                    $hod_2 = $this->hod->liste_hod_by_id((int) $val_pro->hod_2);
                    $hod_3 = $this->hod->liste_hod_by_id((int) $val_pro->hod_3);

                } 


                $script_intro = $this->scps->liste_script_by_id((int)$intro);
                $script_conclusion = $this->scps->liste_script_by_id((int)$conclusion);
            }


            //** END CODE **            

            //** PARAMETRE VUE **
            $data['titre'] = 'ACCUEIL PROCESSUS';
            $data['css'] = array('admin/module.admin.page.form_wizards.min','admin/module.admin.page.modals.min','admin/module.global','admin/module.admin.page.pricing_tables.min');
            
            if(!empty($processus)){
                $data['processus'] = $processus;
                $data['tel'] = $tel;
                $data['mail'] = $mail;
                $data['courrier'] = $courrier;
            }

            $data['level'] = $level;
            $data['prenom'] = $this->session->userdata('prenom');
            $data['js'] = array('js/back.js');
            //** END PARAMETRE VUE **
        
            //** APPEL VUE **
            $this->load->view('includes/header.php', $data);
            $this->load->view('includes/menu_vertical.php', $data);
            $this->load->view('front/processus_view.php', $data);
            if(!empty($script_intro)){
                $data['lst_scps'] = $script_intro;
                $this->load->view('front/popup_script_view.php', $data);
            }

            if(!empty($script_conclusion)){
                $data['lst_scps'] = $script_conclusion;
                $this->load->view('front/popup_script_view.php', $data);
            }

            if(!empty($hod_1)){
                $data['lst_hod'] = $hod_1;
                $this->load->view('front/popup_hod_view.php', $data);
            }

            if(!empty($hod_2)){
                $data['lst_hod'] = $hod_2;
                $this->load->view('front/popup_hod_view.php', $data);
            }

            if(!empty($hod_3)){
                $data['lst_hod'] = $hod_3;
                $this->load->view('front/popup_hod_view.php', $data);
            }


            $this->load->view('includes/footer.php');
            $this->load->view('includes/js.php');
            //** END APPEL VUE **

            
        }else{
            redirect('login');
        }

    }

}