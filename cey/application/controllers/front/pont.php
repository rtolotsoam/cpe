<?php


class Pont extends CI_Controller
{


    
    public function __construct()
    {
        //  Obligatoire
        parent::__construct();

        $this->load->model('cey_historique','hist');
        $this->load->model('cey_reference_process','ref');

    }

    
    public function index()
    {
        $this->pont();
    }


    public function pont()
    {  
      
        if($this->session->userdata('loggin') && $this->input->post('ajax') ==  '1'){
            
            $itab = $this->input->post('id_tab');
            $id_traitement = $this->input->post('id_traitement');

            $now1 = time();
            $ip = $this->session->userdata('ip');
            $mle = $this->session->userdata('mle');

            $session_identifiant = md5( $ip."_".$now1."_".$mle);
            $this->session->set_userdata('connection_id', $session_identifiant);  

            $this->session->set_userdata('traitement_id', $id_traitement);  

            $rq = $this->hist->ajouter_historique($itab, $session_identifiant, 1, $mle);  

            if($rq != false){
                echo site_url('front/traitement');
            }



        }else{
            redirect('login');
        }

    }

    public function terminer()
    {
        $url = site_url('front/traitement');
        if($this->session->userdata('loggin') /*&& $this->session->userdata('traitement_id')*/ && $this->agent->referrer() == $url){
            
            $rq = $this->hist->ajouter_historique(0, $this->session->userdata('connection_id'), 2, $this->session->userdata('mle'));
            
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


    public function editer()
    {  
        $url = site_url('back/processus');
            
        $id_traitement = $this->input->post('id_traitement');

        $now1 = time();
        $ip = $this->session->userdata('ip');
        $mle = $this->session->userdata('mle');

 
        

        $session_identifiant = md5( $ip."_".$now1."_".$mle);
        $this->session->set_userdata('connection_id', $session_identifiant);  

        $this->session->set_userdata('traitement_id', $id_traitement);  

            if( ! ini_get('date.timezone') )
            {
                date_default_timezone_set('Africa/Nairobi');
            }

            $date = array(
                'update_process' => date('Y-m-d H:i:s.u'),
                'matricule' => $mle
            );

           $this->ref->editer_reference_process($date, $id_traitement);
           
        echo $url;
    }


}