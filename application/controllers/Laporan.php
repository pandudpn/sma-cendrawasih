<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_laporan', 'laporan');
        $this->load->model('m_login', 'login');
        $this->load->model('m_data', 'data');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }
    
    public function ranking(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Laporan Perankingan";
        $data['periode']= $this->data->getPeriode()->result();
        $this->load->view('laporan/ranking/index', $data);
    }

    public function detailranking($periode){
        $data['periode']    = $periode;
        $this->load->view('laporan/ranking/detail', $data);
    }

    public function kinerja(){
        $data['periode']    = $this->data->getPeriode()->result();
        $data['judul']      = "Laporan Kinerja Karyawan";
        $data['login']      = $this->login->getDataLogin();
        $this->load->view('laporan/kinerja/index', $data);
    }

    public function detailkinerja($periode){
        $data['periode']    = $periode;
        $data['kriteria']   = $this->data->getKriteria()->result();
        $data['hasil']      = $this->laporan->getKinerja($periode);
        $this->load->view('laporan/kinerja/detail', $data);
    }

    public function karyawanterbaik(){
        $data['login']      = $this->login->getDataLogin();
        $data['judul']      = "Hasil Karyawan Terbaik - Kementrian Lingkungan Hidup dan Kehutanan";
        $this->load->view('laporan/keputusan/index', $data);
    }

    public function showRanking($periode){
        $requestData	= $_REQUEST;
		$fetch			= $this->laporan->showAllRanking($periode, $requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            $nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".number_format($row['nilai_akhir'], 2, ',','.')."</center>";

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

    public function showKeputusan(){
        $requestData	= $_REQUEST;
		$fetch			= $this->laporan->showAllKeputusan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            $nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".$row['nama_periode']."</center>";

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

    public function showKinerja($periode){
        $requestData	= $_REQUEST;
		$fetch			= $this->laporan->showAllKinerja($periode, $requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nama_guru']."</center>";
            $nestedData[]	= "<center>".number_format($row['k1'], 2, ',','.')."</center>";
            $nestedData[]	= "<center>".number_format($row['k2'], 2, ',','.')."</center>";
            $nestedData[]	= "<center>".number_format($row['k3'], 2, ',','.')."</center>";
            $nestedData[]	= "<center>".number_format($row['k4'], 2, ',','.')."</center>";
            $nestedData[]	= "<center>".number_format($row['nilai_akhir'], 2, ',','.')."</center>";
            $nestedData[]	= "<center>".$row['status']."</center>";

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

    public function cetakRanking($periode){
        $guru   = $this->laporan->getEvaluasi($periode);
        if($guru->num_rows() > 0){
            $this->load->library('cfpdf');
            $judul  = "Laporan Ranking Guru Periode ".$guru->row()->nama_periode;

            $image  = base_url()."assets/foto/logo.png";
            $pdf    = new FPDF();
            $pdf->AddPage();
            $pdf->SetTitle($judul);
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
            $pdf->cell(110, 8, "YAYASAN PENDIDIKAN DAYA DUTIKA CENDRAWASIH", 0, 1, "C");
            $pdf->setFont('Arial', 'b', 11);
            $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "NPSN : 20603163    STATUS : TERAKREDITASI 'A'", 0, 1, "C");
            $pdf->setFont('Arial', '', 9);
            $pdf->cell(0, 8, "Komplek Deplu 74 Pondok Aren Tangerang Selatan Banten 15224'", 0, 1, "C");
            $pdf->cell(0, 8, "Te. (021)73885659 Email: smacendrawasih2@yahoo.co.id", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "", 0, 1, "C");
            $pdf->cell(0, 8, "LAPORAN RANKING GURU", 0, 1, "C");
            $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
            $pdf->Ln();
            $pdf->cell(10, 7, "No", 1, 0, "C");
            $pdf->cell(80, 7, "Nama Guru", 1, 0, "C");
            $pdf->cell(50, 7, "Nilai Akhir", 1, 0, "C");
            $pdf->cell(50, 7, "Keterangan", 1, 0, "C");
            $pdf->Ln();
            $no = 1;
            foreach($guru->result() AS $data){
                $pdf->cell(10, 7, $no++, 1, 0, "C");
                $pdf->cell(80, 7, $data->nama_guru, 1, 0, "L");
                $pdf->cell(50, 7, number_format($data->nilai_akhir, 0, ',','.'), 1, 0, "C");
                $pdf->cell(50, 7, $data->status, 1, 0, "L");
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->cell(0, 8, "Jakarta ".date('d F Y'), 0, 1, "R");
            $pdf->cell(0, 8, "Kepala Sekolah SMA Cendrawasih II", 0, 1, "R");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->cell(0, 8, "Nurdin Nadeak S.Pd", 0, 0, "R");


            $pdf->Output($judul, "I");
        }else{
            echo "Tidak ada penilaian pada periode tersebut";
        }
    }

    public function cetakKinerja($periode){
        $guru       = $this->laporan->getEvaluasi($periode);
        $kriteria   = $this->laporan->getKriteria();
        if($guru->num_rows() > 0){
            $this->load->library('cfpdf');
            $judul  = "Laporan Kinerja Guru Periode ".$guru->row()->nama_periode;

            $image  = base_url()."assets/foto/logo.png";
            $pdf    = new FPDF();
            $pdf->AddPage();
            $pdf->SetTitle($judul);
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
            $pdf->cell(110, 8, "YAYASAN PENDIDIKAN DAYA DUTIKA CENDRAWASIH", 0, 1, "C");
            $pdf->setFont('Arial', 'b', 11);
            $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "NPSN : 20603163    STATUS : TERAKREDITASI 'A'", 0, 1, "C");
            $pdf->setFont('Arial', '', 9);
            $pdf->cell(0, 8, "Komplek Deplu 74 Pondok Aren Tangerang Selatan Banten 15224'", 0, 1, "C");
            $pdf->cell(0, 8, "Te. (021)73885659 Email: smacendrawasih2@yahoo.co.id", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
            $pdf->setFont('Arial', '', 11);
            $pdf->cell(0, 8, "", 0, 1, "C");
            $pdf->cell(0, 8, "LAPORAN RANKING GURU", 0, 1, "C");
            $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
            $pdf->Ln();
            $pdf->cell(10, 7, "No", 1, 0, "C");
            $pdf->cell(55, 7, "Nama Guru", 1, 0, "C");
            foreach($kriteria->result() AS $kriterias){
                $pdf->cell(25, 7, $kriterias->nama_kriteria, 1, 0, "C");
            }
            $pdf->cell(25, 7, "Keterangan", 1, 0, "C");
            $pdf->Ln();
            $no = 1;
            foreach($guru->result() AS $data){
                $pdf->cell(10, 7, $no++, 1, 0, "C");
                $pdf->cell(55, 7, $data->nama_guru, 1, 0, "L");
                $pdf->cell(25, 7, number_format($data->k1, 0, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k2, 0, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k3, 0, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, number_format($data->k4,0, ',','.'), 1, 0, "C");
                $pdf->cell(25, 7, $data->status, 1, 0, "L");
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->cell(0, 8, "Jakarta ".date('d F Y'), 0, 1, "R");
            $pdf->cell(0, 8, "Kepala Sekolah SMA Cendrawasih II", 0, 1, "R");
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->cell(0, 8, "Nurdin Nadeak S.Pd", 0, 0, "R");


            $pdf->Output($judul, "I");
        }else{
            echo "Tidak ada penilaian pada periode tersebut";
        }
    }

    public function cetakKeputusan(){
        $guru = $this->laporan->getKeputusan();
        $this->load->library('cfpdf');
        $judul  = "Laporan Hasil Keputusan Guru Terbaik";

        $image  = base_url()."assets/foto/logo.png";
        $pdf    = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle($judul);
        $pdf->setFont('Arial', '', 11);
        $pdf->cell(40, 40, $pdf->Image($image, 10, 13, 30), 0, 0, "C");
        $pdf->cell(110, 8, "YAYASAN PENDIDIKAN DAYA DUTIKA CENDRAWASIH", 0, 1, "C");
        $pdf->setFont('Arial', 'b', 11);
        $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
        $pdf->setFont('Arial', '', 11);
        $pdf->cell(0, 8, "NPSN : 20603163    STATUS : TERAKREDITASI 'A'", 0, 1, "C");
        $pdf->setFont('Arial', '', 9);
        $pdf->cell(0, 8, "Komplek Deplu 74 Pondok Aren Tangerang Selatan Banten 15224'", 0, 1, "C");
        $pdf->cell(0, 8, "Te. (021)73885659 Email: smacendrawasih2@yahoo.co.id", 0, 1, "C");
        $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
        $pdf->cell(0, 1, "______________________________________________________________________________________________________________________", 0, 1, "C");
        $pdf->setFont('Arial', '', 11);
        $pdf->cell(0, 8, "", 0, 1, "C");
        $pdf->cell(0, 8, "LAPORAN HASIL KEPUTUSAN GURU TERBAIK", 0, 1, "C");
        $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
        $pdf->Ln();
        $pdf->cell(10, 7, "No", 1, 0, "C");
        $pdf->cell(105, 7, "Nama Guru", 1, 0, "C");
        $pdf->cell(75, 7, "Periode", 1, 0, "C");
        $pdf->Ln();
        $no = 1;
        foreach($guru->result() AS $data){
            $pdf->cell(10, 7, $no++, 1, 0, "C");
            $pdf->cell(105, 7, $data->nama_guru, 1, 0, "L");
            $pdf->cell(75, 7, $data->nama_periode, 1, 0, "C");
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->cell(0, 8, "Jakarta ".date('d F Y'), 0, 1, "R");
        $pdf->cell(0, 8, "Kepala Sekolah SMA Cendrawasih II", 0, 1, "R");
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->cell(0, 8, "Nurdin Nadeak S.Pd", 0, 0, "R");


        $pdf->Output($judul, "I");
    }

}

/* End of file Laporan.php */
