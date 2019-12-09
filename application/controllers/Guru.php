<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {
    
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
        $data['judul']  = "Data Guru";
        $this->load->view('guru/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->data->showAllGuru($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

        $data	= array();
        $no = 1;
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$no++."</center>";
            $nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".$row['tempat'].", ".date('d F Y', strtotime($row['tgl_lahir']))."</center>";
            $nestedData[]	= "<center>".$row['jabatan']."</center>";
            $nestedData[]	= "<center>".date('d/m/Y', strtotime($row['tmt']))."</center>";
            $nestedData[]   = "<center><a href='".site_url('guru/edit/'.$row['id_guru'])."' id='Edit'><i class='fa fa-pencil'></i> Edit</a> | <a href='".site_url('guru/hapus/'.$row['id_guru'])."' class='text-danger' id='Hapus'><i class='fa fa-trash-o'></i> Hapus</a></center>";

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
            $data   = [
                'nama_guru'     => $this->input->post('nama'),
                'tempat'        => $this->input->post('tempat'),
                'tgl_lahir'     => $this->input->post('tgl_lahir'),
                'jabatan'       => $this->input->post('jabatan'),
                'tmt'           => $this->input->post('tmt'),
                'bidang_studi'  => $this->input->post('bidang'),
                'alamat_guru' => $this->input->post('alamat_gue')
            ];

            $ins        = $this->data->insertGuru($data);
            if($ins){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='2'><b><i class='fa fa-check-circle-o'></i> Berhasil</b></font>";
            }else{
                $status['status']   = "error";
                $status['pesan']    = "<font style='color:red;' size='3'>Terjadi Kesalahan pada JSON, Silahkan periksa Kembali!</font>";
            }
            echo json_encode($status);
        }else{
            $this->load->view('guru/tambah');
        }
    }

    public function edit($nip){
        if(!empty($nip)){
            if($this->input->post()){
                $data   = [
                    'nama_guru'     => $this->input->post('nama'),
                    'tempat'        => $this->input->post('tempat'),
                    'tgl_lahir'     => $this->input->post('tgl_lahir'),
                    'jabatan'       => $this->input->post('jabatan'),
                    'tmt'           => $this->input->post('tmt'),
                    'bidang_studi'  => $this->input->post('bidang')
                ];

                $update     = $this->data->updateGuru($nip, $data);
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
                $data['guru']       = $this->data->editGuru($nip)->row();
                $this->load->view('guru/edit', $data);
            }
        }
    }

    public function hapus($nip){
        if($this->input->is_ajax_request()){
            $hapus  = $this->data->hapusGuru($nip);

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

}

/* End of file Pegawai.php */
