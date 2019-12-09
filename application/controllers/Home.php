<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_login', 'login');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }

    public function index()
    {
        $data['login'] = $this->login->getDataLogin();
        $data['judul'] = "Beranda";
        
        $this->load->view('templates/dashboard', $data);
    }

    public function logout(){
        $data = array('id','username','login','akses');
		$this->session->unset_userdata($data);
		redirect('login');
    }

}