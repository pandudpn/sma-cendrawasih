<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {

    public function cek_login($username, $password){
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getDataLogin(){
        $id = $this->session->userdata('id');

        return $this->db->get_where('users', array('id_user' => $id))->row_array();
    }

}

/* End of file M_Login.php */
