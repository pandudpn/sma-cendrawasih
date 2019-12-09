<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_data', 'data');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Data Pegawai - Kementrian Lingkungan Hidup dan Kehutanan";
        $this->load->view('pegawai/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllPegawai($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['id_guru']."</center>";
            $nestedData[]	= "<center>".$row['nama_pegawai']."</center>";
            $nestedData[]	= "<center>".$row['no_telp']."</center>";
            $nestedData[]	= "<center>".$row['jabatan']."</center>";
            $nestedData[]	= "<center>".$row['golongan']."</center>";
            $nestedData[]   = "<center><a href='".site_url('pegawai/edit/'.$row['id_guru'])."' id='EditPegawai'><i class='fa fa-pencil'></i> Edit</a> | <a href='".site_url('pegawai/hapus/'.$row['id_guru'])."' id='HapusPegawai'><i class='fa fa-trash-o'></i> Hapus</a></center>";

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
    }

    public function tambah(){
        if($this->input->post()){
            $nip        = $this->input->post('nip');
            $npwp       = $this->input->post('npwp');
            $nama       = $this->input->post('nama');
            $email      = $this->input->post('email');
            $telp       = $this->input->post('telp');
            $tanggal    = $this->input->post('tanggal');
            $jabatan    = $this->input->post('jabatan');
            $golongan   = $this->input->post('golongan');

            $ins        = $this->data->insertPegawai($nip, $npwp, $nama, $email, $telp, $tanggal, $jabatan, $golongan);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><b><i class='fa fa-check-circle-o'></i> Berhasil</b></font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi Kesalahan pada JSON, Silahkan periksa Kembali!</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('pegawai/tambah');
        }
    }

    public function edit($nip){
        if(!empty($nip)){
            if($this->input->post()){
                $nama       = $this->input->post('nama');
                $telp       = $this->input->post('telp');
                $jabatan    = $this->input->post('jabatan');
                $golongan   = $this->input->post('golongan');
                $email      = $this->input->post('email');

                $update     = $this->data->updatePegawai($nip, $nama, $telp, $jabatan, $golongan, $email);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='3'><i class='fa fa-check-circle-o'></i> Berhasil</font>";
                }else{
                    $status['pesan']    = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan Pada JSON, Silahkan periksa kembali</font>";
                }
                echo json_encode($status);
            }else{
                $data['nip']        = $nip;
                $data['pegawai']    = $this->data->editPegawai($nip)->row();
                $this->load->view('pegawai/edit', $data);
            }
        }
    }

    public function hapus($nip){
        if($this->input->is_ajax_request()){
            $hapus  = $this->data->hapusPegawai($nip);

            if($hapus){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='3'><i class='fa fa-check-circle-o'></i> Berhasil</font>";
            }
            echo json_encode($status);
        }
    }

    public function ajax_cek_nip(){
        $nip    = $this->input->post('nip');
        $cek    = $this->data->ajax_nip($nip);

        if($cek->num_rows() > 0){
            $status['status']   = 0;
            $status['pesan']    = "<font style='color:red;' size='2'>Nomer Induk Pegawai sudah ada</font>";
        }else{
            $status['status']   = 1;
        }
        echo json_encode($status);
    }

    public function ajax_cek_npwp(){
        $npwp    = $this->input->post('npwp');
        $cek    = $this->data->ajax_npwp($npwp);

        if($cek->num_rows() > 0){
            $status['status']   = 0;
            $status['pesan']    = "<font style='color:red;' size='2'>NPWP sudah ada</font>";
        }else{
            $status['status']   = 1;
        }
        echo json_encode($status);
    }

}

/* End of file Pegawai.php */
