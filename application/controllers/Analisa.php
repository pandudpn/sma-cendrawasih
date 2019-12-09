<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_data', 'data');
        $this->load->model('m_analisa', 'analisa');
        if(!$this->session->userdata('login')){
            redirect('login');
        }
    }

    public function hitung(){
        if($this->input->post()){
            $i  = 0;
            $nilai_akhir = 0;
            foreach($this->input->post('guru') AS $key => $val){
                $bobot          = $this->input->post('bobot')[$key];

                $guru           = $val;
                $subkriteria    = $this->input->post('subkriteria')[$key];
                $nilai          = pow($this->input->post('nilai')[$key], $bobot);
                $periode        = $this->input->post('periode')[$key];
                $nilai_akhir    += $nilai;

                $cek_validasi   = $this->analisa->cek_validasi_guru($guru, $subkriteria, $periode);

                if($cek_validasi->num_rows() > 0){
                    $status['status']   = 'error';
                    $status['pesan']    = '<font style="color:red;" size="3">Guru tersebut sudah pernah di nilai pada Periode '.$periode.'</font>';
                }else{
                    $ins        = $this->analisa->insertNilai($guru, $subkriteria, $nilai, $periode);

                    if($ins){
                        $i++;
                    }
                }
            }

            if($i > 0){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='3'>Berhasil melakukan penilaian pada Karyawan <b>".$guru."</b> periode <b>".$periode."</b></font>";

                $insert     = $this->analisa->insertHasil($guru, $nilai_akhir, $periode);
            }
            echo json_encode($status);

        }else{
            $data['login']          = $this->login->getDataLogin();
            $data['judul']          = "Analisa Perhitungan";
            $data['kriteria']       = $this->data->getKriteria()->result();
            $data['subkriteria']    = $this->data->getSubkriteria()->result();
            $data['guru']           = $this->data->getGuru()->result();
            $data['periode']        = $this->analisa->getPeriode()->result();
            $this->load->view('analisa/hitung', $data);
        }
    }

    public function pilih(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Keputusan Guru Terbaik";
        $data['periode']= $this->analisa->getPeriode()->result();
        $this->load->view('analisa/pilih', $data);
    }

    public function hasilkeputusan($periode){
        if($this->input->post()){
            $guru    = $this->input->post('guru');

            $update     = $this->analisa->updateHasil($guru, $periode);
            if($update){
                $status['status']   = "success";
                $status['pesan']    = "<font style='color:green;' size='3'>Berhasil</font>";
            }
            echo json_encode($status);
        }else{
            $data['hasil']  = $this->analisa->getHasil($periode);
            $data['cek']    = $this->analisa->cek_hasil($periode);
            $data['tahun']  = $periode;
            $this->load->view('analisa/detailkeputusan', $data);
        }
    }

    public function guruterbaik(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Hasil Keputusan Guru Terbaik";
        $data['periode']= $this->analisa->getPeriode()->result();
        $this->load->view('analisa/guruterbaik', $data);
    }

    public function detailGuruterbaik($periode){
        $data['guru']   = $this->analisa->getGuruTerpilih($periode);
        $data['periode']= $periode;
        $this->load->view('analisa/detailguruterbaik', $data);
    }

    public function cetakguruterbaik($periode){
        $guru   = $this->analisa->getGuruTerpilih($periode);
        if($guru->num_rows() > 0){
            $this->load->library('cfpdf');
            $judul  = "Guru Terbaik - ".$guru->row()->nama_periode;

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
            $pdf->cell(0, 8, "HASIL KEPUTUSAN GURU", 0, 1, "C");
            $pdf->cell(0, 8, "SMA CENDRAWASIH II", 0, 1, "C");
            $pdf->Ln();
            $pdf->cell(0, 8, "Pada periode ".$guru->row()->nama_periode." menyatakan bahwa: ", 0, 1, "L");
            $pdf->cell(60, 7, "Nama : ", 0, 0, "R");
            $pdf->cell(10, 7, "", 0, 0, "L");
            $pdf->cell(80, 7, $guru->row()->nama_guru, 0, 0, "L");
            $pdf->Ln();
            $pdf->cell(60, 7, "Jabatan : ", 0, 0, "R");
            $pdf->cell(10, 7, "", 0, 0, "L");
            $pdf->cell(80, 7, $guru->row()->jabatan, 0, 0, "L");
            $pdf->Ln();
            $pdf->cell(60, 7, "Bidang Studi : ", 0, 0, "R");
            $pdf->cell(10, 7, "", 0, 0, "L");
            $pdf->cell(80, 7, $guru->row()->bidang_studi, 0, 0, "L");
            $pdf->Ln();
            $pdf->cell(60, 7, "Nilai Akhir : ", 0, 0, "R");
            $pdf->cell(10, 7, "", 0, 0, "L");
            $pdf->cell(80, 7, $guru->row()->nilai_akhir, 0, 0, "L");
            $pdf->Ln();
            $pdf->cell(0, 8, "Dinyatakan sebagai guru terbaik SMA Cendrawasih II.", 0, 1, "L");
            $pdf->Ln();
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

}

/* End of file Analisa.php */
