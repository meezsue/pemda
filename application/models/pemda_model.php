<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pemda_model extends CI_Model 
{

    function __construct(){
        parent::__construct();        
    }

	function validasi_login($username, $password)
	{
		$sql	= " SELECT mu.user_id, mu.nama, mu.unitkey, mu.group_menu_id, mgm.urut 
					FROM 
						m_user mu, m_group_menu mgm
					WHERE 
						mu.group_menu_id = mgm.group_menu_id AND
						mu.username = '$username' AND mu.password = '$password'";
		return $this->db->query($sql);
	}	
	
	function update_last_login($username)
	{
		$sql	= " UPDATE `m_user` SET last_login = NOW() WHERE username ='$username'";
		return $this->db->query($sql);
	}	
	
	function generate_menu($user_id)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "SELECT * FROM v_user_menu WHERE user_id = $user_id";
		
		return $this->db->query($sql);
	}
	
	function generate_profile($user_id)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= " SELECT 
							mu.nama, mu.username, mu.password,
							(CASE WHEN unitkey IS NULL OR unitkey ='' THEN mu.nama  
								ELSE (SELECT md.nama_unit FROM m_daftunit md WHERE md.`unitkey` = mu.`unitkey`) 
							END) AS nama_unit, 
							mu.foto
						FROM m_user mu
						WHERE 							
							mu.user_id = $user_id";
						
		return $this->db->query($sql);
	}
	
	function edit_profile($user_id, $password, $confirm_password)
	{
		$user_id	= $this->session->userdata('user_id');
		
		$sql	= "UPDATE m_user SET password = md5('$password'), update_user = $user_id, update_date = NOW() WHERE user_id = $user_id";
		
		return $this->db->query($sql);
	}
	
	function edit_photo($upload, $namaFile)
	{
		$user_id	= $this->session->userdata('user_id');
		$foto	= $upload.$namaFile;
		
		$sql	= "UPDATE m_user SET foto = '$namaFile', update_user = $user_id, update_date = NOW() WHERE user_id = $user_id";
		
		return $this->db->query($sql);
	}
	
	function generate_dinas($unit_key, $user_id)
	{
		$user_id	= $this->session->userdata('user_id');	
		$sql		= "select  md.kode_unit AS kode_unit, md.unitkey, md.nama_unit
						from m_daftunit md 
						where exists (select 1 from v_user_menu vm 
						where md.unitkey = vm.unitkey and vm.user_id = $user_id)";
						
		return $this->db->query($sql);
	}
	
	function cek_num_rows($bulan, $tahun)
	{
		$sql	= "SELECT no_nota_dinas FROM t_nota_dinas WHERE MONTH(create_date) = $bulan AND YEAR(create_date) = '$tahun'";
		return $this->db->query($sql);
	}
	
	function generate_file_code($file_code)
	{
		$sql	= "SELECT * FROM m_upload_file WHERE status = 0 AND upload_file_code = '$file_code'";
		return $this->db->query($sql);
	}
	
	function save_nota_dinas($txt_unit, $txt_jenis, $txt_tgl, $txt_no_nota, $txt_perihal)
	{
		$user_id	= $this->session->userdata('user_id');
		$mysqltime  = date('Y-m-d H:i:s', strtotime($txt_tgl)); 
		$sql		= "INSERT INTO t_nota_dinas(no_nota_dinas, unitkey, tgl_nota_dinas, jns_nota_dinas, status, perihal, status_dokumen_id, status_dokumen, create_user, create_date) VALUES
						('$txt_no_nota', '$txt_unit', '$mysqltime', '$txt_jenis', 'N', '$txt_perihal', 1, 'New', '$user_id', NOW())";
		
		return $this->db->query($sql);
	}
	
	function save_doc_nota_dinas($txt_no_nota, $upload, $namaFile)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "UPDATE t_nota_dinas SET nota_dinas_doc = '$namaFile', update_user = '$user_id', update_date = NOW() WHERE no_nota_dinas = '$txt_no_nota'";
		
		return $this->db->query($sql);
	}
	
	function save_document($txt_no_nota, $namaFile, $file_code, $file_name, $revisi)
	{
		$user_id	= $this->session->userdata('user_id');		
		$sql		= "INSERT INTO t_upload_dokumen_utama(no_nota_dinas, upload_file_code, upload_file_name, revisi, file, create_user, create_date) VALUES
						('$txt_no_nota', '$file_code', '$file_name', $revisi, '$namaFile', '$user_id', NOW())";
		
		return $this->db->query($sql);
	}
	
	function cek_scan_nota_dinas($namaFile)
	{
		$sql	= "SELECT no_nota_dinas FROM `t_nota_dinas` WHERE nota_dinas_doc = '$namaFile'";
		
		return $this->db->query($sql);
	}
	
	function save_edit_nota_dinas($txt_tgl, $txt_no_nota, $txt_perihal)
	{
		$user_id	= $this->session->userdata('user_id');
		$mysqltime  = date('Y-m-d H:i:s', strtotime($txt_tgl)); 
		$sql		= "UPDATE t_nota_dinas set perihal = '$txt_perihal',tgl_nota_dinas = '$mysqltime', update_user = '$user_id',update_date = NOW() where no_nota_dinas = '$txt_no_nota'";
	
		return $this->db->query($sql);
	}
	
	function save_edit_doc_nota_dinas($txt_no_nota, $upload, $namaFile)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "UPDATE t_nota_dinas SET nota_dinas_doc = '$namaFile', update_user = '$user_id', update_date = NOW() WHERE no_nota_dinas = '$txt_no_nota'";
		
		return $this->db->query($sql);
	}
	
	function save_edit_document($txt_no_nota, $namaFile, $file_code, $file_name, $revisi)
	{
		$user_id	= $this->session->userdata('user_id');	
		$sql		= "INSERT INTO t_upload_dokumen_utama(no_nota_dinas, upload_file_code, upload_file_name, revisi, file, create_user, create_date) VALUES
						('$txt_no_nota', '$file_code', '$file_name', $revisi, '$namaFile', '$user_id', NOW()) 
						ON DUPLICATE KEY UPDATE file = '$namaFile', update_user = '$user_id', update_date = NOW()";
		
		return $this->db->query($sql);
	}
	
	function generate_new($urut, $unit_key)
	{		
		if($urut == 1)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE  status_dokumen_id IN (1,7) and unitkey = '$unit_key'";
		}
		else if($urut == 2)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE  status_dokumen_id = 2";
		}
		else if($urut == 3)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE  status_dokumen_id IN (3, 8)";
		}		
		else
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE  status_dokumen_id = 6";
		}
			
		return $this->db->query($sql);
		//var_dump($sql);
	}
	
	function generate_progress($urut, $unit_key)
	{
		if($urut == 1)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (2,3,4,6,8) and unitkey = '$unit_key'";
		}
		else if($urut == 2)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (3,4,6,7,8)";
		}
		else if($urut == 3)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (4,6,7)";
		}
		
		return $this->db->query($sql);
	}	
	
	function generate_reject($urut, $unit_key)
	{	
		if($urut == 1)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (5) and unitkey = '$unit_key'";
		}
		else
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (5)";
		}
		
		return $this->db->query($sql);
	}	
	
	function generate_approve($urut, $unit_key)
	{
		if($urut == 1)
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (9) and unitkey = '$unit_key'";
		}
		else
		{
			$sql	= "SELECT COUNT(*) AS jumlah FROM t_nota_dinas WHERE status_dokumen_id IN (9)";
		}
		
		return $this->db->query($sql);
	}		
	
	function generate_dokumen_dashboard($id, $urut, $unit_key)
	{
		if($id == 1)
		{
			if($urut == 1)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (1,7) and a.unitkey = '$unit_key'";
			}
			else if($urut == 2)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (2)";
			}
			else if($urut == 3)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (3, 8)";
			}
			else
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (6)";
			}
			
		}
		else if($id == 2)
		{
			if($urut == 1)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (2,3,4,6,8) and a.unitkey = '$unit_key'";
			}
			else if($urut == 2)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (3,4,6,7,8)";
			}	
			else if($urut == 3)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in (4,6,7)";
			}
		}
		else
		{
			if($urut == 1)
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in ($id) and a.unitkey = '$unit_key'";
			}
			else
			{
				$sql		= "SELECT a.id, a.status_dokumen_id, a.no_nota_dinas, a.tgl_nota_dinas, substring(a.perihal, 1, 50) as perihal, b.status_dokumen FROM t_nota_dinas a, m_status_dokumen b WHERE a.status_dokumen_id = b.status_dokumen_id AND a.status_dokumen_id in ($id)";
			}			
		}

		return $this->db->query($sql);
		//var_dump($sql);

	}
	
	function generate_nota_dinas_by_id($id)
	{		
		$sql	= " SELECT 
						tnd.no_nota_dinas, DATE_FORMAT(tnd.tgl_nota_dinas, '%d-%m-%Y') AS tgl_nota_dinas, 
						tnd.jns_nota_dinas, tnd.perihal, tnd.status_dokumen_id, tnd.nota_dinas_doc,
						mdu.unitkey, mdu.kode_unit, mdu.nama_unit,
						REPLACE(tnd.no_nota_dinas, '/', '') as folder
					FROM 
						t_nota_dinas tnd, 
						m_daftunit mdu
						
					WHERE 
						tnd.unitkey = mdu.unitkey AND
						tnd.id = $id";
						
		return $this->db->query($sql);		
	}
	
	function generate_nota_dinas_document($no_nota_dinas)
	{
		$sql	= " SELECT 
						FILE as file, a.upload_file_code, REPLACE(a.no_nota_dinas, '/', '') as folder 
					FROM 
						t_upload_dokumen_utama a, m_upload_file b 
					WHERE 
						a.`upload_file_code` = b.`upload_file_code` and 
						no_nota_dinas = '$no_nota_dinas' AND
						LEFT(a.upload_file_code,4) <> 'LAMP'
					
					UNION ALL

					SELECT 
						FILE as file, a.upload_file_code, REPLACE(a.no_nota_dinas, '/', '') as folder 
					FROM 
						t_upload_dokumen_utama a, m_upload_file b 
					WHERE 
						a.`upload_file_code` = b.`upload_file_code` and 
						no_nota_dinas = '$no_nota_dinas' AND
						LEFT(a.upload_file_code,4) = 'LAMP'";
			
		return $this->db->query($sql);	
	}
	
	function delete_dokumen($no_nota_dinas, $file)
	{
		$sql	= "DELETE from t_upload_dokumen_utama WHERE no_nota_dinas = '$no_nota_dinas' AND file  ='$file'";
		
		return $this->db->query($sql);				
		//var_dump($sql);
	}

	function edit_doc_nota_dinas($id_nota, $namaFile)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= " UPDATE t_nota_dinas SET 
							nota_dinas_doc = '$namaFile', 
							update_user = $user_id,
							update_date = NOW()
						WHERE id = $id_nota";
						
		return $this->db->query($sql);	
	}
	
	function submit_nota_dinas($id)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= " UPDATE t_nota_dinas SET
							status = 'S',
							status_dokumen_id ='2', 
							status_dokumen = 'waiting approval kabag hukum',
							submit_user = $user_id, 
							submit_date	= NOW()
						WHERE id = $id";
						
		return $this->db->query($sql);
	}
	
	function submit_nota_dinas_save($txt_no_nota)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= " UPDATE t_nota_dinas SET
							status = 'S',
							status_dokumen_id ='2', 
							status_dokumen = 'waiting approval kabag hukum',
							submit_user = $user_id, 
							submit_date	= NOW()
						WHERE no_nota_dinas = '$txt_no_nota'";
		
		return $this->db->query($sql);
	}
	
	function generate_revisi_nota_dinas($txt_no_nota)
	{
		$sql	= "SELECT MAX(revisi) AS revisi FROM t_history_return WHERE no_nota_dinas = '$txt_no_nota'";
		return $this->db->query($sql);		
	}
	
	function cek_file_old($no_nota_dinas, $file_old)
	{
		$sql	= "SELECT * FROM t_upload_dokumen_utama WHERE no_nota_dinas = '$no_nota_dinas' AND file LIKE '%$file_old'";
		return $this->db->query($sql);			
	}
	
	function edit_file_old($no_nota_dinas, $file_old, $upload, $cek_file_old, $revisi, $file_code, $file_name)
	{
		$user_id	= $this->session->userdata('user_id');
		if($cek_file_old > 0)
		{
			$sql_update	= "UPDATE t_upload_dokumen_utama SET file = '$upload', revisi = $revisi, update_user = $user_id, update_date = NOW() WHERE no_nota_dinas = '$no_nota_dinas' AND file LIKE '%$file_old'";
			$this->db->query($sql_update);								
			//var_dump($sql_update);
			
			$sql_update_history	= "UPDATE t_history_return SET submit_skpd_user = $user_id, submit_skpd_date = NOW(), update_user = $user_id, update_date = NOW() WHERE no_nota_dinas = '$no_nota_dinas'";
			$this->db->query($sql_update_history);							
			//var_dump($sql_update_history);
		}
		else
		{
			$sql_insert	= "INSERT INTO t_upload_dokumen_utama(no_nota_dinas, upload_file_code, upload_file_name, revisi, file, create_user, create_date) VALUES
							('$no_nota_dinas', '$file_code', '$file_name', $revisi, '$upload', '$user_id', NOW())";
			$this->db->query($sql_insert);								
			//var_dump($sql_insert);
		}
		
		$sql	= "UPDATE t_nota_dinas SET status = 'S', status_dokumen_id = 8, status_dokumen = 'waiting re-approval kasubag', update_user = $user_id, update_date = NOW() WHERE no_nota_dinas = '$no_nota_dinas'";
		return $this->db->query($sql);			
	}
	
	function generate_disposisi_by_id($id_detail)
	{
		$sql	= " SELECT 
						a.no_surat_disposisi, a.no_nota_dinas, DATE_FORMAT(a.tgl_surat, '%d-%m-%Y') AS tgl_surat, DATE_FORMAT(a.tgl_terima, '%d-%m-%Y') AS tgl_terima, 
						a.no_agenda, a.sifat, a.perihal, a.send_to, a.status_note, a.catatan, a.kota_disposisi, DATE_FORMAT(a.tgl_ttd, '%d-%m-%Y') AS tgl_ttd
					FROM
						t_disposisi a
					WHERE
						EXISTS (SELECT 1 FROM t_nota_dinas b WHERE a.no_nota_dinas = b.no_nota_dinas AND b.id = $id_detail)";
			
		return $this->db->query($sql);
	}
	
	function save_nota_disposisi($txt_kode_unit, $txt_nama_unit, $txt_tgl_terima, $txt_nota_surat, $txt_nota_surat_ext, 
								 $txt_nota_dinas, $txt_nota_agenda, $txt_tgl_surat, $txt_tgl_ttd, $txt_sifat, $txt_perihal_disposisi, 
								 $txt_catatan, $txt_diteruskan, $txt_kota, $txt_harap)
	{
		$user_id		= $this->session->userdata('user_id');
		$txt_tgl_surat  = date('Y-m-d H:i:s', strtotime($txt_tgl_surat));
		$txt_tgl_terima = date('Y-m-d H:i:s', strtotime($txt_tgl_terima));		
		$txt_tgl_ttd 	= date('Y-m-d H:i:s', strtotime($txt_tgl_ttd));		
	
		if($txt_nota_surat_ext == '')
		{
			$sql	= " INSERT INTO t_disposisi 
								(no_surat_disposisi, no_nota_dinas, unitkey, nama_unit, tgl_surat, tgl_terima, no_agenda,  
								 sifat, perihal, send_to, status_note, catatan, kota_disposisi, tgl_ttd, create_user, create_date) 
							VALUES
								('$txt_nota_surat', '$txt_nota_dinas', '$txt_kode_unit', '$txt_nama_unit', '$txt_tgl_surat', '$txt_tgl_terima', '$txt_nota_agenda', 
								 $txt_sifat, '$txt_perihal_disposisi', '$txt_diteruskan', $txt_harap, '$txt_catatan', '$txt_kota', '$txt_tgl_ttd', '$user_id', NOW())";
		}
		else
		{
			$sql	= "UPDATE t_disposisi SET
						no_surat_disposisi = '$txt_nota_surat', no_nota_dinas = '$txt_nota_dinas', tgl_surat = '$txt_tgl_surat', tgl_terima = '$txt_tgl_terima',
						no_agenda = '$txt_nota_agenda', sifat = $txt_sifat, perihal = '$txt_perihal_disposisi', send_to = '$txt_diteruskan', 
						status_note = $txt_harap, catatan = '$txt_catatan', kota_disposisi = '$txt_kota', tgl_ttd = '$txt_tgl_ttd', 
						update_user = $user_id, update_date = NOW()
					   WHERE
						no_surat_disposisi = '$txt_nota_surat_ext'";
		}
								 
		return $this->db->query($sql);		
	}
	
	function submit_nota_disposisi($id_detail, $txt_nota_surat)
	{
		$user_id		= $this->session->userdata('user_id');
		$sql			= " UPDATE t_nota_dinas SET
								status_dokumen_id = 3, status_dokumen = 'waiting approval kasubag'
								
							WHERE
								id = $id_detail";
		$query			= $this->db->query($sql);
		if($query)
		{
			$sql_disposisi		= " UPDATE t_disposisi SET
										submit_user = $user_id, submit_date = NOW()
									WHERE
										no_surat_disposisi = '$txt_nota_surat'";
			
			return $this->db->query($sql_disposisi);
		}	
	}
	
	function generate_ceklist_dokumen($id)
	{
		$sql2				= "SELECT no_nota_dinas FROM t_nota_dinas WHERE id = $id";
		$query2				= $this->db->query($sql2)->row_array();
		$no_nota_dinas		= $query2['no_nota_dinas'];			
		
		$sql3				= "SELECT COUNT(1) AS jumlah FROM t_ceklis_dokumen a WHERE no_nota_dinas = '$no_nota_dinas'";
		$query3				= $this->db->query($sql3)->row_array();
		$jml_row			= $query3['jumlah'];	
		
		if($jml_row == 0){
			$sql	= " SELECT mu.no_urut, mu.upload_file_code, mu.upload_file_name,
								'$no_nota_dinas' AS no_nota_dinas, 0 AS is_ready,'-' AS keterangan 
						  FROM m_upload_file mu
						 WHERE mu.status = 1 
					     ORDER BY mu.no_urut ASC";
		}else{							
			$sql	= " SELECT 
							mu.no_urut, mu.upload_file_code, mu.upload_file_name,
							tcd.no_nota_dinas, tcd.is_ready, tcd.keterangan 
						FROM 
							m_upload_file mu
							LEFT JOIN t_ceklis_dokumen tcd ON mu.upload_file_code = tcd.upload_file_code
						WHERE mu.status = 1 
						  and tcd.no_nota_dinas = '$no_nota_dinas'
						ORDER BY mu.no_urut ASC";
		}
		return $this->db->query($sql);
		//var_dump($sql);
	}
	
	function save_ceklist_dokumen($id_modal, $dataOrg, $txt_nota_dinas, $aksi)
	{
		$user_id		= $this->session->userdata('user_id');
		foreach($dataOrg as $org){
			
			$keterangan		= $org['keterangan'];
			$upload			= $org['cheklist'];
			$file_name		= $org['file_name'];
			$file_code		= $org['file_code'];
			
			$sql2 = "DELETE FROM t_ceklis_dokumen WHERE no_nota_dinas = '$txt_nota_dinas' AND upload_file_code = '$file_code'" ;
			$this->db->query($sql2);
			
			$sql	= "INSERT INTO t_ceklis_dokumen 
						(no_nota_dinas, upload_file_code, upload_file_name, is_ready, keterangan, status, create_user, create_date, app_user, app_date) VALUES
						('$txt_nota_dinas', '$file_code', '$file_name', $upload, '$keterangan', '$aksi', $user_id, NOW(), $user_id, NOW())";
						
			$this->db->query($sql);
			
		}
		
		if($aksi == 'A')
		{
			$update_nota_dinas	= " UPDATE t_nota_dinas SET status = 'A', status_dokumen_id = 6, status_dokumen = 'waiting approval pelaksana'
									WHERE id = $id_modal";  	
		}
		else if($aksi == 'R')
		{
			$update_nota_dinas	= " UPDATE t_nota_dinas SET status = 'R', status_dokumen_id = 5, status_dokumen = 'rejected kasubag'
									WHERE id = $id_modal";  	
		}	
		else
		{
			$cek_no_revisi		= "SELECT DISTINCT revisi FROM t_upload_dokumen_utama WHERE no_nota_dinas = '$txt_nota_dinas'";
			$query_no_revisi	= $this->db->query($cek_no_revisi)->row_array();
			$no_revisi			= $query_no_revisi['revisi'];			
			
			$insert_history		= "INSERT INTO t_history_return (no_nota_dinas, revisi, return_user, return_date, create_user, create_date) VALUES	
									('$txt_nota_dinas', $no_revisi, $user_id, NOW(), $user_id, NOW())";
			$this->db->query($insert_history);
			
			$update_nota_dinas	= " UPDATE t_nota_dinas SET status = 'T', status_dokumen_id = 7, status_dokumen = 'waiting SKPD to complete document'
									WHERE id = $id_modal";  	
		}	
		    
		return $this->db->query($update_nota_dinas);
	}
	
	function generate_history_approval($id_detail)
	{
		$sql	= " SELECT 
						DATE_FORMAT(a.submit_date, '%d-%m-%Y') AS tgl_approval_kabag,
						(SELECT DISTINCT DATE_FORMAT(c.app_date, '%d-%m-%Y') FROM t_ceklis_dokumen c WHERE a.no_nota_dinas = c.no_nota_dinas) AS tgl_approval_kasubag,
						b.keterangan, b.draft_dokumen
					FROM 
						t_disposisi a
						LEFT JOIN t_draft_perbup b ON a.no_nota_dinas = b.no_nota_dinas
					WHERE
						EXISTS(SELECT 1 FROM t_nota_dinas b WHERE a.no_nota_dinas = b.no_nota_dinas AND b.id = $id_detail)";
						
		return $this->db->query($sql);		
	}
	
	function save_history_approval($id_modal)
	{
		
		$update_nota_dinas	= " UPDATE t_nota_dinas SET status = 'A', status_dokumen_id = 9, status_dokumen = 'Done'
								WHERE id = $id_modal";  	
								
		return $this->db->query($update_nota_dinas);
	}
	
	function save_draft($txt_no_nota, $txt_keterangan, $namaFile)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "INSERT INTO t_draft_perbup (no_nota_dinas, tgl_approve, draft_dokumen, keterangan, submit_user, submit_date, create_user, create_date) VALUES				
						('$txt_no_nota', NOW(), '$namaFile', '$txt_keterangan', $user_id, NOW(), $user_id, NOW())";
						
		return $this->db->query($sql);
	}
	
	function generate_user()
	{
		$sql		= "SELECT user_id, username, nama, DATE_FORMAT(create_date, '%d-%m-%Y') AS create_date FROM m_user";
		return $this->db->query($sql);
	}
	
	function generate_admin_profile($user_id)
	{		
		$sql		= " SELECT 
							mu.nama, mu.username, mu.password,
							(CASE WHEN unitkey IS NULL OR unitkey ='' THEN mu.nama  
								ELSE (SELECT md.nama_unit FROM m_daftunit md WHERE md.`unitkey` = mu.`unitkey`) 
							END) AS nama_unit, 
							mu.foto
						FROM m_user mu
						WHERE 							
							mu.user_id = $user_id";
						
		return $this->db->query($sql);
	}
	
	function save_admin_profile($nama, $username, $password)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "INSERT INTO m_user (username, nama, password, create_user, create_date) VALUES ('$username', '$nama', '$password', $user_id, NOW())";
		
		return $this->db->query($sql);
	}
	
	function update_admin_profile($username, $password)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "UPDATE m_user SET password = '$password', update_user = $user_id, update_date = NOW() WHERE username = '$username'";
		
		return $this->db->query($sql);
		//var_dump($sql);
	}
	
	function delete_admin_profile($user_id)
	{
		$sql	= "DELETE FROM m_user WHERE user_id = $user_id";
		return $this->db->query($sql);
		//var_dump($sql);
	}
	
	function generate_group_menu()
	{
		$sql		= "SELECT `group_menu_id`, `nama_group_menu`, urut,
							(SELECT username FROM m_user mu WHERE mu.user_id = m.create_user ) AS create_user,
							DATE_FORMAT(create_date, '%d-%m-%Y') AS create_date 
					  FROM m_group_menu m";
		
		return $this->db->query($sql);
	}
	
	function update_admin_group_menu($txt_group_menu, $txt_nama_group, $txt_urut)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "UPDATE m_group_menu SET nama_group_menu = '$txt_nama_group', urut = '$txt_urut', update_user = $user_id, update_date = NOW() WHERE group_menu_id = '$txt_group_menu'";
		
		return $this->db->query($sql);
		//var_dump($sql);
	}
	
	function save_admin_group_menu($txt_group_menu, $txt_nama_group, $txt_urut)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "INSERT INTO m_group_menu	 (group_menu_id, nama_group_menu, urut, create_user, create_date) VALUES ('$txt_group_menu', '$txt_nama_group', '$txt_urut', $user_id, NOW())";
		
		return $this->db->query($sql);
	}
	
	function generate_admin_group_menu($txt_id)
	{		
		$sql		= " SELECT `group_menu_id`, `nama_group_menu`, urut
						  FROM m_group_menu
						 WHERE group_menu_id = '$txt_id'";
			
		return $this->db->query($sql);
	}
	
	function delete_admin_group_menu($txt_id)
	{
		$sql	= "DELETE FROM m_group_menu WHERE group_menu_id = '$txt_id'";
		
		return $this->db->query($sql);
	}
	
	function cek_group_menu_rows($txt_group_menu)
	{
		$sql	= "SELECT group_menu_id FROM `m_group_menu` WHERE `group_menu_id` = '$txt_group_menu'";
		
		return $this->db->query($sql);
	}
	
	function generate_daftar_dinas()
	{
		$sql		= "SELECT `unitkey`, `kode_unit`, nama_unit,
								(SELECT username FROM m_user mu WHERE mu.user_id = m.create_user ) AS create_user,
								DATE_FORMAT(create_date, '%d-%m-%Y') AS create_date 
						FROM m_daftunit m";
		
		return $this->db->query($sql);
	}
	
	function generate_admin_daftar_dinas($txt_id)
	{		
		$sql		= " SELECT unitkey, kode_unit, nama_unit
						  FROM m_daftunit
						 WHERE unitkey = '$txt_id'";
			
		return $this->db->query($sql);
	}
	
	function delete_admin_daftar_dinas($txt_id)
	{
		$sql	= "DELETE FROM m_daftunit WHERE unitkey = '$txt_id'";
		
		return $this->db->query($sql);
	}
	
	function update_admin_daftar_dinas($txt_unitkey, $txt_kode_dinas, $txt_nama_dinas)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "UPDATE m_daftunit SET kode_unit = '$txt_kode_dinas', nama_unit = '$txt_nama_dinas', update_user = $user_id, update_date = NOW() WHERE unitkey = '$txt_unitkey'";
		
		return $this->db->query($sql);
	}
	
	function cek_daftar_dinas_rows($txt_unitkey)
	{
		$sql	= "SELECT unitkey FROM `m_daftunit` WHERE `unitkey` = '$txt_unitkey'";
		
		return $this->db->query($sql);
	}
	
	
	function save_admin_daftar_dinas($txt_unitkey, $txt_kode_dinas, $txt_nama_dinas)
	{
		$user_id	= $this->session->userdata('user_id');
		$sql		= "INSERT INTO m_daftunit (unitkey, kode_unit, nama_unit, create_user, create_date) VALUES ('$txt_unitkey', '$txt_kode_dinas', '$txt_nama_dinas', $user_id, NOW())";
		
		return $this->db->query($sql);
	}
	
}
