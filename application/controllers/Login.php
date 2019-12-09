<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        $this->load->model('m_login', 'login');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['judul'] = 'Login';
			$this->load->view('login',$data);
		}else{
			$username = $this->input->post('username');
			$password = sha1(sha1($this->input->post('password')));

			$user = $this->login->cek_login($username, $password);
			if($user){
				$user_data = array(
					'id'		=> $user['id_user'],
					'username'	=> $this->input->post('username'),
					'akses'		=> $user['hak_akses'],
					'nama'		=> $user['nama'],
					'login'		=> true
				);
				$this->session->set_userdata($user_data);
				redirect(base_url());
			}else{
				$this->session->set_flashdata('salah', 'Username atau Password anda Salah!');
				redirect('login');
			}
		}
    }

}

/* End of file Login.php */
