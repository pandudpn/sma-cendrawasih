<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Analisa extends CI_Model {

    public function insertNilai($guru, $subkriteria, $nilai, $periode){
        $data = array(
            'id_guru'           => $guru,
            'id_subkriteria'=> $subkriteria,
            'nilai'         => $nilai,
            'id_periode'    => $periode
        );
        return $this->db->insert('nilai', $data);
    }

    public function insertHasil($guru, $nilai_akhir, $periode){
        $data = array(
            'id_guru'           => $guru,
            'nilai_akhir'   => $nilai_akhir,
            'id_periode'    => $periode
        );
        return $this->db->insert('hasil', $data);
    }

    public function cek_validasi_guru($guru, $subkriteria, $periode){
        $where = array(
            'id_guru'           => $guru,
            'id_subkriteria'=> $subkriteria,
            'id_periode'    => $periode
        );
        return $this->db->get_where('nilai', $where);
    }

    public function getHasil($periode){
        $this->db->join('guru b', 'b.id_guru = a.id_guru', 'left');
        $this->db->order_by('nilai_akhir', 'desc');
        return $this->db->get_where('hasil a', ['id_periode' => $periode]);
    }

    public function updateHasil($guru, $periode){
        $data = array(
            'id_guru'           => $guru,
            'id_periode'    => $periode
        );
        $this->db->where($data);
        return $this->db->update('hasil', ['status' => 'Terpilih']);
    }

    public function cek_hasil($periode){
        $sql = "SELECT
                a.*, b.*
                FROM hasil a LEFT JOIN
                guru b ON b.id_guru = a.id_guru
                WHERE status = 'Terpilih'
                AND id_periode = $periode ";
        return $this->db->query($sql);
    }

    public function getPeriode(){
        return $this->db->get('periode');
    }

    public function getGuruTerpilih($periode){
        $this->db->join('guru b', 'b.id_guru = a.id_guru');
        $this->db->join('periode c', 'c.id_periode = a.id_periode');
        return $this->db->get_where('hasil a', ['a.id_periode' => $periode, 'status' => 'Terpilih']);
    }

}

/* End of file M_Analisa.php */
