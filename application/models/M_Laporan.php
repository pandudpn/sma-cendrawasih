<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Laporan extends CI_Model {

    public function getKinerja($periode){
        return $this->db->get_where('nilai', ['id_periode' => $periode]);
    }

    public function showAllRanking($periode, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
                (@row:=@row+1) AS nomor,
                nama_guru, a.id_guru, nilai_akhir, id_periode
			FROM 
                hasil a
            LEFT JOIN
                guru b
            ON
                b.id_guru = a.id_guru, (SELECT @row := 0) r
            WHERE
                id_periode = $periode
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
                `nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR nilai_akhir LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
            0 => 'nilai_akhir',
            1 => 'nama_guru',
            2 => 'nomor'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nilai_akhir";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllKeputusan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
                (@row:=@row+1) AS nomor,
                nama_guru, a.id_guru, nilai_akhir, nama_periode, a.id_periode
			FROM 
                hasil a
            LEFT JOIN
                guru b
            ON
                b.id_guru = a.id_guru
            LEFT JOIN
                periode c
            ON
                c.id_periode = a.id_periode, (SELECT @row := 0) r
            WHERE
                status = 'Terpilih' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
                `nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR nama_periode LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_periode DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllKinerja($periode, $like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "SELECT
                t1.nama_guru, sum(t1.k1) k1, sum(t1.k2) k2, sum(t1.k3) k3, sum(t1.k4) k4,
                t1.nilai_akhir, t1.id_guru, t1.status
                FROM
                (
                    SELECT nama_guru, b.status, a.id_guru, a.id_periode, nilai_akhir, nilai k1, null k2, null k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND e.id_kriteria = 'KR1'
                    UNION ALL
                    SELECT nama_guru, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, nilai k2, null k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND e.id_kriteria = 'KR2'
                    UNION ALL
                    SELECT nama_guru, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, null k2, nilai k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND e.id_kriteria = 'KR3'
                    UNION ALL
                    SELECT nama_guru, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, null k2, null k3, nilai k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND e.id_kriteria = 'KR4'
                ) t1
                WHERE t1.id_periode = '$periode'
            ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
                `t1.nama_guru` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR t1.nilai_akhir LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
        
        $sql .= " GROUP BY t1.id_guru, t1.id_periode ";
        $sql .= " ORDER BY t1.status ASC, t1.nilai_akhir DESC ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function getRanking($periode){
        $this->db->join('guru b', 'b.id_guru = a.id_guru');
        $this->db->join('periode c', 'c.id_periode = a.id_periode');
        $this->db->order_by('status', 'DESC');
        $this->db->order_by('nilai_akhir', 'DESC');
        return $this->db->get_where('hasil a', ['a.id_periode' => $periode]);
    }

    public function getEvaluasi($periode){
        $sql = "SELECT
                t1.nama_guru, sum(t1.k1) k1, sum(t1.k2) k2, sum(t1.k3) k3, sum(t1.k4) k4,
                t1.nilai_akhir, t1.id_guru, t1.status, t1.nama_periode, t1.n1, t1.n2, t1.n3, t1.n4
                FROM
                (
                    SELECT nama_guru, nama_kriteria n1, null n2, null n3, null n4, nama_periode, b.status, a.id_guru, a.id_periode, nilai_akhir, nilai k1, null k2, null k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e, periode f
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND f.id_periode = a.id_periode AND e.id_kriteria = 'KR1'
                    UNION ALL
                    SELECT nama_guru, null n1, nama_kriteria n2, null n3, null n4, nama_periode, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, nilai k2, null k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e, periode f
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND f.id_periode = a.id_periode AND e.id_kriteria = 'KR2'
                    UNION ALL
                    SELECT nama_guru, null n1, null n2, nama_kriteria n3, null n4, nama_periode, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, null k2, nilai k3, null k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e, periode f
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND f.id_periode = a.id_periode AND e.id_kriteria = 'KR3'
                    UNION ALL
                    SELECT nama_guru, null n1, null n2, null n3, nama_kriteria n4, nama_periode, b.status, a.id_guru, a.id_periode, nilai_akhir, null k1, null k2, null k3, nilai k4
                    FROM nilai a, hasil b, guru c, kriteria d, subkriteria e, periode f
                    WHERE a.id_guru = c.id_guru AND b.id_guru = c.id_guru AND a.id_subkriteria = e.id_subkriteria AND e.id_kriteria = d.id_kriteria AND f.id_periode = a.id_periode AND e.id_kriteria = 'KR4'
                ) t1
                WHERE t1.id_periode = '$periode'
                GROUP BY t1.id_guru, t1.id_periode
                ORDER BY t1.status ASC, t1.nilai_akhir DESC
                ";

        return $this->db->query($sql);
    }

    public function getKriteria(){
        return $this->db->get('kriteria');
    }

    public function getKeputusan(){
        $this->db->join('guru b', 'b.id_guru = a.id_guru');
        $this->db->join('periode c', 'c.id_periode = a.id_periode');
        return $this->db->get_where('hasil a', ['status' => 'Terpilih']);
    }
    

}

/* End of file M_Laporan.php */
