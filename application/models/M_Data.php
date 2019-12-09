<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Data extends CI_Model {

    public function showAllGuru($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				id_guru, 
				nama_guru, 
				tempat, tgl_lahir, 
                jabatan,
				tmt,
                bidang_studi, ts_guru
			FROM 
				guru, (SELECT @row := 0) r
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
                `nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR id_guru LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR tempat LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR bidang_studi LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR date_format(tgl_lahir, '%d %F %Y') LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR date_format(tmt, '%d %F %Y') LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR jabatan LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
            0 => 'id_guru',
            1 => 'nama_guru',
            2 => 'tempat',
            3 => 'bidang_studi',
            4 => 'jabatan',
            5 => 'tgl_lahir'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir."";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllKriteria($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_kriteria, nama_kriteria,
                bobot
			FROM 
				kriteria, (SELECT @row := 0) r
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
                `nama_kriteria` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR bobot LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nama_kriteria ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllSub($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_subkriteria, a.id_kriteria,
                nama_subkriteria, nama_kriteria
			FROM 
                subkriteria a
            LEFT JOIN
                kriteria b
            ON
                b.id_kriteria = a.id_kriteria, (SELECT @row := 0) r
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
                `nama_kriteria` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR nama_subkriteria LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_kriteria ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllPeriode($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
                (@row:=@row+1) AS nomor,
                id_periode, nama_periode
			FROM 
                periode, (SELECT @row := 0) r
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
                `nama_periode` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nomor ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }
    
    public function insertGuru($data){
        return $this->db->insert('guru', $data);
    }

    public function insertKriteria($count, $nama, $bobot){
        $data = array(
            'id_kriteria'   => $count,
            'nama_kriteria' => $nama,
            'bobot'         => $bobot
        );
        return $this->db->insert('kriteria', $data);
    }

    public function insertSubkriteria($kriteria, $nama){
        $data = array(
            'id_kriteria'       => $kriteria,
            'nama_subkriteria'  => $nama
        );
        return $this->db->insert('subkriteria', $data);
    }

    public function insertPeriode($nama){
        return $this->db->insert('periode', ['nama_periode' => $nama]);
    }

    public function editGuru($nip){
        return $this->db->get_where('guru', ['id_guru' => $nip]);
    }

    public function editKriteria($id){
        return $this->db->get_where('kriteria', ['id_kriteria' => $id]);
    }

    public function editSubkriteria($id){
        return $this->db->get_where('subkriteria', ['id_subkriteria' => $id]);
    }

    public function editPeriode($id){
        return $this->db->get_where('periode', ['id_periode' => $id]);
    }

    public function updateGuru($nip, $data){
        $this->db->where('id_guru', $nip);
        return $this->db->update('guru', $data);
    }

    public function updateKriteria($id, $nama, $bobot){
        $data = array(
            'nama_kriteria' => $nama,
            'bobot'         => $bobot
        );
        $this->db->where('id_kriteria', $id);
        return $this->db->update('kriteria', $data);
    }

    public function updateSubkriteria($id, $kriteria, $nama){
        $data = array(
            'id_kriteria'       => $kriteria,
            'nama_subkriteria'  => $nama
        );
        $this->db->where('id_subkriteria', $id);
        return $this->db->update('subkriteria', $data);
    }

    public function updatePeriode($id, $nama){
        $this->db->where('id_periode', $id);
        return $this->db->update('periode', ['nama_periode' => $nama]);
    }

    public function hapusGuru($nip){
        $this->db->where('id_guru', $nip);
        return $this->db->delete('guru');
    }

    public function ajax_nip($nip){
        return $this->db->get_where('guru', ['id_guru' => $nip]);
    }

    public function getKriteria(){
        return $this->db->get('kriteria');
    }

    public function getGuru(){
        return $this->db->get('guru');
    }
    
    public function getSubkriteria(){
        return $this->db->get('subkriteria');
    }

    public function getPeriode(){
        return $this->db->get('periode');
    }

}

/* End of file M_Data.php */
