<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {
    
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
        $data['kriteria'] = $this->data->getKriteria();
        $data['judul']  = "Data Kriteria - Kementrian Lingkungan Hidup dan Kehutanan";
        $this->load->view('kriteria/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllKriteria($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            $nestedData[]	= "<center>".$row['nama_kriteria']."</center>";
            $nestedData[]	= "<center>".$row['bobot']."</center>";
            $nestedData[]   = "<center><a href='".site_url('kriteria/edit/'.$row['id_kriteria'])."' id='EditKriteria'><i class='fa fa-pencil'></i> Edit</a>";

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
            $kr         = $this->data->getKriteria()->result();
            $count      = "KR".(count($kr) + 1);
            $nama       = $this->input->post('nama');
            $bobot      = $this->input->post('bobot');

            $ins        = $this->data->insertKriteria($count, $nama, $bobot);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><b><i class='fa fa-check-circle-o'></i> Berhasil</b></font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi Kesalahan pada JSON, Silahkan periksa Kembali!</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('kriteria/tambah');
        }
    }

    public function edit($id){
        if(!empty($id)){
            if($this->input->post()){
                $nama       = $this->input->post('nama');
                $bobot      = $this->input->post('bobot');

                $update     = $this->data->updateKriteria($id, $nama, $bobot);
                if($update){
                    $status['status']   = "success";
                    $status['pesan']    = "<font style='color:green;' size='3'><i class='fa fa-check-circle-o'></i> Berhasil</font>";
                }else{
                    $status['pesan']    = "error";
                    $status['pesan']    = "<font style='color:red;' size='3'>Terjadi kesalahan Pada JSON, Silahkan periksa kembali</font>";
                }
                echo json_encode($status);
            }else{
                $data['id']        = $id;
                $data['kriteria']  = $this->data->editKriteria($id)->row();
                $this->load->view('kriteria/edit', $data);
            }
        }
    }

}

/* End of file Pegawai.php */
