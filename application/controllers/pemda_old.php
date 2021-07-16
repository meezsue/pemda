<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class pemda extends CI_Controller {		
		function __construct(){
			parent::__construct();					
			$this->load->model('pemda_model','',TRUE);		
			$this->load->library('session');
			$this->load->helper('url');	
			session_start();

			error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
		}
	
		function index()
		{
			$this->load->view('login_view');
		}
		
		function validasi_login()
		{
			$username	= $this->input->post('username', true);
			$password	= md5($this->input->post('password', true));
			
			$data		= $this->pemda_model->validasi_login($username, $password)->num_rows();
			if($data == 0)
			{
				echo 'false';
			}
			else
			{				
				$user					= $this->pemda_model->validasi_login($username, $password)->row_array();
				$session_data 			= array(
											'user_id' 		=> $user['user_id'],
											'nama' 			=> $user['nama'],
											'unit_key' 		=> $user['unitkey'],
											'group_menu_id'	=> $user['group_menu_id'],
											'urut'			=> $user['urut']
										  );
				$this->session->set_userdata($session_data);	
				echo '1';
			}
		}
		
		function update_last_login(){
			$username = $this->input->post('username', true);
			$data		= $this->pemda_model->update_last_login($username);
			
			echo 'true';
		}
		
		function main_page()			
		{			
			$this->load->view('main_page');	
		}
		
		function profile()
		{			
			$this->load->view('profile_view');	
		}
		
		function generate_profile()
		{
			$user_id	= $this->session->userdata('user_id');
			$data		= $this->pemda_model->generate_profile($user_id)->row_array();
			
			echo json_encode($data);
		}
		
		function edit_profile()
		{
			$user_id			= $this->session->userdata('user_id');
			$password			= $this->input->post('password', TRUE);
			$confirm_password	= $this->input->post('confirm_password', TRUE);
			
			if($password!=""){
				$data				= $this->pemda_model->edit_profile($user_id, $password, $confirm_password);
			}
			
			echo 'true';
		}
		
		function edit_photo()
		{			
			$namaFile	= $_FILES['file_name']['name'];
			$tempFile	= $_FILES['file_name']['tmp_name'];	
			$upload		= "/pemda/upload/";
			
			if($namaFile != ""){
				$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$namaFile;			
				
				move_uploaded_file($tempFile, $dirUpload);
				
				$data		= $this->pemda_model->edit_photo($upload, $namaFile);
			}	
			echo 'true';
		}
		
		function nota_dinas()
		{
			$data['id']	= $this->uri->segment(3);
			echo $this->uri->segment(3);
			$this->load->view('nota_dinas_view', $data);	
		}				
		
		function generate_dinas()
		{
			$unit_key	= $this->session->userdata('unit_key');
			$user_id	= $this->session->userdata('user_id');			
			$data		= $this->pemda_model->generate_dinas($unit_key, $user_id)->row_array();
			
			echo json_encode($data);
		}
		
		function cek_num_rows()
		{
			$bulan	= $this->input->post('bulan', TRUE);
			$tahun	= $this->input->post('tahun', TRUE);
			$data	= $this->pemda_model->cek_num_rows($bulan, $tahun)->num_rows();
			if($data == 0)
			{
				echo '0';
			}
			else
			{
				echo $data;
			}
		}
		
		function generate_file_code()
		{
			$file_code	= $this->input->post('file_code', TRUE);
			$data		= $this->pemda_model->generate_file_code($file_code)->row_array();
			
			echo json_encode($data);
		}
		
		function save_nota_dinas()
		{
			$txt_unit		= $this->input->post('txt_unit', TRUE);
			$txt_jenis		= $this->input->post('txt_jenis', TRUE);
			$txt_tgl		= $this->input->post('txt_tgl', TRUE);
			$txt_no_nota	= $this->input->post('txt_no_nota', TRUE);
			$txt_perihal	= $this->input->post('txt_perihal', TRUE);
			$path			= "./upload/".str_replace('/', '', $txt_no_nota);
			$data			= $this->pemda_model->save_nota_dinas($txt_unit, $txt_jenis, $txt_tgl, $txt_no_nota, $txt_perihal);

			if (!is_dir($path))
            {                            
                mkdir($path, 0777, TRUE);                
            }
			
			echo 'true';
		}
		
		function save_doc_nota_dinas()
		{			
			$namaFile		= $_FILES['file_name']['name'];
			$tempFile		= $_FILES['file_name']['tmp_name'];			
			$txt_no_nota	= $this->input->post('txt_nota_dinas_ext', TRUE);			
			$folder			= str_replace('/', '', $txt_no_nota);
			$upload			= "/pemda/upload/".$folder;
			$dirUpload  	= $_SERVER['DOCUMENT_ROOT'].$upload;			
			
			//move_uploaded_file($tempFile, $dirUpload);
			move_uploaded_file($tempFile, $dirUpload.$namaFile);
			
			$data			= $this->pemda_model->save_doc_nota_dinas($txt_no_nota, $upload, $namaFile);
			
			echo 'true';
		}		
		
		
		function save_document()
		{			
			if (isset($_FILES["myfile"])) {  
				$no_files = count($_FILES["myfile"]['name']);  
				
				for ($i = 0; $i < $no_files; $i++) {					
					$file_new  = $this->input->post('txt_dokumen', TRUE);
					$file_old  = $this->input->post('txt_dokumen_ext', TRUE);
										
					if($i == 0)
					{
						$file_code = substr($file_new[$i], 0, 6);	
						if($file_code == 'KEPBUP')
						{
							$file_name = 'Keputusan Bupati';
						}
						else
						{
							$file_name = 'Peraturan Bupati';
						}						
					}
					else
					{
						$x		   = $i;
						$file_code = 'LAMP'.$x; 
						$file_name = 'Lampiran '.$x; 	
					}
					
					$revisi			= substr($file_new[$i], -1, 1);					
					$txt_no_nota	= $this->input->post('txt_nota_dinas_ext1', TRUE);
					$data			= $this->pemda_model->save_document($txt_no_nota, $upload.$file_new[$i].'.'.$ext, $file_code, $file_name, $revisi);
					
					$folder			= str_replace('/', '', $txt_no_nota);
					$upload			= "/pemda/upload/".$folder;
					$ext			= pathinfo($_FILES["myfile"]["name"][$i], PATHINFO_EXTENSION);
					$dirUpload  	= $_SERVER['DOCUMENT_ROOT'].$upload;		
					
					//move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $dirUpload);		
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $dirUpload.$_FILES["myfile"]["name"][$i]);		
					rename($_SERVER['DOCUMENT_ROOT'].$upload.$_FILES["myfile"]["name"][$i], $_SERVER['DOCUMENT_ROOT'].$upload.$file_new[$i].'.'.$ext);					
					
					echo 'true';
				}
			}
		}
		
		
		function cek_scan_nota_dinas()
		{
			$namaFile	= $_FILES['file_name']['name'];
			$data	= $this->pemda_model->cek_scan_nota_dinas($namaFile)->num_rows();
			
			if($data == 0)
			{
				echo '0';
			}
			else
			{
				echo $data;
			}
		}
		
		function save_edit_nota_dinas()
		{
			$txt_tgl		= $this->input->post('txt_tgl', TRUE);
			$txt_no_nota	= $this->input->post('txt_no_nota', TRUE);
			$txt_perihal	= $this->input->post('txt_perihal', TRUE);
			$data			= $this->pemda_model->save_edit_nota_dinas($txt_tgl, $txt_no_nota, $txt_perihal);
			
			echo 'true';
		}
		
		function save_edit_doc_nota_dinas()
		{			
			
			$txt_no_nota	= $this->input->post('txt_scan_nota_dinas_old', TRUE);
			
			$namaFile	= $_FILES['file_name']['name'];
			
			$tempFile	= $_FILES['file_name']['tmp_name'];			
			$upload		= "/pemda/upload/";
			$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$namaFile;			
			
			move_uploaded_file($tempFile, $dirUpload);
			
			if($namaFile != ""){
				$data			= $this->pemda_model->save_edit_doc_nota_dinas($txt_no_nota, $upload, $namaFile);
			}
			
			echo 'true';
		}	

		function save_edit_document()
		{			
			if (isset($_FILES["myfile"])) {  
				$no_files = count($_FILES["myfile"]['name']);  
				
				for ($i = 0; $i < $no_files; $i++) {					
					$file_new  = $this->input->post('txt_dokumen', TRUE);
					$file_old  = $this->input->post('txt_dokumen_ext', TRUE);
					
					$upload		= "/pemda/upload/";
					$ext		= pathinfo($_FILES["myfile"]["name"][$i], PATHINFO_EXTENSION);
					$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$_FILES["myfile"]["name"][$i];		
					
					if(substr($file_new[$i], -4, 1)!= "."){
						move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $dirUpload);		
						rename($_SERVER['DOCUMENT_ROOT'].$upload.$_FILES["myfile"]["name"][$i], $_SERVER['DOCUMENT_ROOT'].$upload.$file_new[$i].'.'.$ext);
						
						if($i == 0)
						{
							$file_code = substr($file_new[$i], 0, 6);	
							if($file_code == 'KEPBUP')
							{
								$file_name = 'Keputusan Bupati';
							}
							else
							{
								$file_name = 'Peraturan Bupati';
							}						
						}
						else
						{
							$x		   = $i;
							$file_code = 'LAMP'.$x; 
							$file_name = 'Lampiran '.$x; 	
						}
						
						$revisi			= substr($file_new[$i], -1, 1);	
						
						$txt_no_nota	= $this->input->post('txt_nota_dinas_ext1', TRUE);
					
						$data			= $this->pemda_model->save_edit_document($txt_no_nota, $upload.$file_new[$i].'.'.$ext, $file_code, $file_name, $revisi);
					}
					
					echo 'true';
				}
			}
		}		
		
		function dasboard()
		{
			$this->load->view('dashboard_skpd_view');
		}
		
		function generate_new()
		{
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$data		= $this->pemda_model->generate_new($urut, $unit_key)->row_array();
			
			echo json_encode($data);		
		}
		
		function generate_progress()
		{
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$data		= $this->pemda_model->generate_progress($urut, $unit_key)->row_array();
			
			echo json_encode($data);		
		}		
		
		function generate_reject()
		{
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$data		= $this->pemda_model->generate_reject($urut, $unit_key)->row_array();
			
			echo json_encode($data);			
		}		
		
		function generate_approve()
		{
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$data		= $this->pemda_model->generate_approve($urut, $unit_key)->row_array();
			
			echo json_encode($data);		
		}				
		
		function generate_dokumen_dashboard()
		{
			$id			= $this->input->post('id', TRUE);
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$data		= $this->pemda_model->generate_dokumen_dashboard($id, $urut, $unit_key)->num_rows();
			
			if(($data == 1) || (($data == 0)))
			{				
				echo '1';
			}
			else
			{	
				echo '2';
			}
		}
		
		function generate_dokumen()
		{
			$id			= $this->input->post('id', TRUE);
			$urut		= $this->session->userdata('urut');
			$unit_key	= $this->session->userdata('unit_key');
			$jml		= $this->input->post('jml', TRUE);
			
			if($jml == '1')
			{
				$generate	= $this->pemda_model->generate_dokumen_dashboard($id, $urut, $unit_key)->row_array();
			}
			else
			{
				$generate	= $this->pemda_model->generate_dokumen_dashboard($id, $urut, $unit_key)->result_array();
			}
			
			echo json_encode($generate);
		}
		
		/*Proses Submit Dokumen */
		function generate_nota_dinas_by_id()
		{
			$id			= $this->input->post('id', TRUE);
			$data		= $this->pemda_model->generate_nota_dinas_by_id($id)->row_array();
			
			echo json_encode($data);
		}
		
		function generate_nota_dinas_document()
		{
			$no_nota_dinas	= $this->input->post('no_nota_dinas', TRUE);
			$data			= $this->pemda_model->generate_nota_dinas_document($no_nota_dinas)->result_array();
			
			echo json_encode($data);
		}

		function delete_dokumen()
		{
			$no_nota_dinas	= $this->input->post('no_nota_dinas', TRUE);
			$file		    = $this->input->post('file', TRUE);
			$dirFile		= $_SERVER['DOCUMENT_ROOT']."/pemda/upload/".$file;
			
			unlink($dirFile);
			$data			= $this->pemda_model->delete_dokumen($no_nota_dinas, "/pemda/upload/".$file);
			//echo json_encode($data);
			echo 'true';
		}
		
		function edit_doc_nota_dinas()
		{	
			$id_nota	= $this->uri->segment(3);
			$namaFile	= $_FILES['file_name']['name'];
			$tempFile	= $_FILES['file_name']['tmp_name'];	
			$oldScan	= $this->input->post('txt_scan_nota_dinas_old', TRUE);
			
			if($namaFile != $oldScan)
			{
				$upload		= "/pemda/upload/";
				$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$namaFile;
				move_uploaded_file($tempFile, $dirUpload);

				$dirFile	= $_SERVER['DOCUMENT_ROOT']."/pemda/upload/".$oldScan;
				unlink($dirFile);
				
				$edit_scan	= $this->pemda_model->edit_doc_nota_dinas($id_nota, $namaFile);
				echo 'true';
			}
		}

		function edit_document()
		{
			if (isset($_FILES["myfile"])) {  
				$no_files = count($_FILES["myfile"]['name']); 
				echo $no_files;
				exit();
			}
		}

		function submit_nota_dinas()
		{
			$id		= $this->input->post('id', TRUE);
			$data	= $this->pemda_model->submit_nota_dinas($id);
			
			echo json_encode($data);
		}
		
		function submit_nota_dinas_save()
		{
			$txt_no_nota	= $this->input->post('txt_no_nota', TRUE);			
			$data			= $this->pemda_model->submit_nota_dinas_save($txt_no_nota);
			
			echo json_encode($data);
		}
		
		function generate_revisi_nota_dinas()
		{
			$txt_no_nota	= $this->input->post('no_nota_dinas', TRUE);			
			$data			= $this->pemda_model->generate_revisi_nota_dinas($txt_no_nota)->row_array();
			
			echo json_encode($data);			
		}
		
		function cek_edit_document()
		{			
			if (isset($_FILES["myfile"])) {  
				$no_files 		= count($_FILES["myfile"]['name']);  
				$no_nota_dinas	= $this->input->post('txt_nota_dinas_ext', TRUE);				
				$upload			= "/pemda/upload/";					
				
				for ($i = 0; $i < $no_files; $i++) {					
					$file_new  			= $this->input->post('txt_dokumen_new', TRUE);
					$file_new_rename	= $this->input->post('txt_dokumen', TRUE);
					$file_old  			= $this->input->post('txt_dokumen_ext', TRUE);
					
					$ext		= pathinfo($_FILES["myfile"]["name"][$i], PATHINFO_EXTENSION);
					$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$_FILES["myfile"]["name"][$i];
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $dirUpload);		
					rename($_SERVER['DOCUMENT_ROOT'].$upload.$_FILES["myfile"]["name"][$i], $_SERVER['DOCUMENT_ROOT'].$upload.$file_new_rename[$i].'.'.$ext);
					
						
					$cek_file_old	= $this->pemda_model->cek_file_old($no_nota_dinas, $file_old[$i])->num_rows();		
					if($cek_file_old == 0)
					{									
						if($i == 0)
						{
							$file_code = substr($file_new_rename[$i], 0, 6);	
							if($file_code == 'KEPBUP')
							{
								$file_name = 'Keputusan Bupati';
							}
							else
							{
								$file_name = 'Peraturan Bupati';
							}						
						}
						else
						{
							$x		   = substr($file_new_rename[$i], 4,1);
							$file_code = 'LAMP'.$x; 
							$file_name = 'Lampiran '.$x; 									
						}	
						
						$revisi			= substr($file_new_rename[$i], -1, 1);							
					}
					else
					{
						$revisi	= $this->input->post('txt_revisi', TRUE);
					}
					
					$edit_file_old	= $this->pemda_model->edit_file_old($no_nota_dinas, $file_old[$i], $upload.$file_new_rename[$i].'.'.$ext, $cek_file_old, $revisi, $file_code, $file_name);
					echo json_encode($edit_file_old);
				}
			}
		}	

		/* Kabag Hukum  */
		function generate_disposisi_by_id()
		{
			$id_detail	= $this->input->post('id_detail', TRUE);
			$data		= $this->pemda_model->generate_disposisi_by_id($id_detail)->row_array();
			
			echo json_encode($data);
		}
		
		function save_nota_disposisi()
		{
			$txt_kode_unit				= $this->input->post('txt_kode_unit', TRUE);
			$txt_nama_unit				= $this->input->post('txt_nama_unit', TRUE);
			$txt_tgl_terima				= $this->input->post('txt_tgl_terima', TRUE);
			$txt_nota_surat				= $this->input->post('txt_nota_surat', TRUE);
			$txt_nota_surat_ext			= $this->input->post('txt_nota_surat_ext', TRUE);	
			$txt_nota_dinas				= $this->input->post('txt_nota_dinas_modal');
			$txt_nota_agenda			= $this->input->post('txt_nota_agenda', TRUE);
			$txt_tgl_surat				= $this->input->post('txt_tgl_surat', TRUE);
			$txt_tgl_ttd				= $this->input->post('txt_tgl_ttd', TRUE);
			$txt_sifat					= $this->input->post('txt_sifat', TRUE);
			$txt_perihal_disposisi		= $this->input->post('txt_perihal_disposisi', TRUE);
			$txt_catatan				= $this->input->post('txt_catatan', TRUE);
			$txt_diteruskan				= $this->input->post('txt_diteruskan', TRUE);
			$txt_kota					= $this->input->post('txt_kota', TRUE);			
			$txt_harap					= $this->input->post('txt_harap', TRUE);
			$data						= $this->pemda_model->save_nota_disposisi($txt_kode_unit, $txt_nama_unit, $txt_tgl_terima, $txt_nota_surat, $txt_nota_surat_ext,  
																				  $txt_nota_dinas, $txt_nota_agenda, $txt_tgl_surat, $txt_tgl_ttd, $txt_sifat, 
																				  $txt_perihal_disposisi,  $txt_catatan, $txt_diteruskan, $txt_kota, $txt_harap);
																				  
		    echo json_encode($data);
		}
		
		function submit_nota_disposisi()
		{
			$id_detail			= $this->input->post('id_detail', TRUE);
			$txt_nota_surat		= $this->input->post('txt_nota_surat', TRUE);
			$data				= $this->pemda_model->submit_nota_disposisi($id_detail, $txt_nota_surat);
			
			echo json_encode($data);
		}
		
		function print_disposisi()
		{
			$id_detail			= $this->uri->segment(3);
			$data['disposisi']	= $this->pemda_model->generate_disposisi_by_id($id_detail)->row_array();
			
			$this->load->view('print_disposisi_view', $data); 
		}
		
		/* Kasubag */
		function generate_ceklist_dokumen()
		{
			$id				= $this->input->post('id', TRUE);
			$data			= $this->pemda_model->generate_ceklist_dokumen($id)->result_array();
			echo json_encode($data);
		}
		
		function save_ceklist_dokumen()
		{
			$id_modal		= $this->input->post('id_modal', TRUE);
			$dataOrg		= $this->input->post('dataOrg', TRUE);
			$txt_nota_dinas	= $this->input->post('txt_nota_dinas', TRUE);
			$aksi			= $this->input->post('aksi', TRUE);
			$data			= $this->pemda_model->save_ceklist_dokumen($id_modal, $dataOrg, $txt_nota_dinas, $aksi);
			
			echo json_encode($data);
		}
		
		function generate_history_approval()
		{
			$id_detail			= $this->input->post('id_detail', TRUE);
			$data				= $this->pemda_model->generate_history_approval($id_detail)->row_array();
			
			echo json_encode($data);
		}
		
		function save_history_approval()
		{
			$id_modal		= $this->input->post('id_modal', TRUE);
			$data			= $this->pemda_model->save_history_approval($id_modal);
			
			echo json_encode($data);
		}
		
		function save_draft()
		{			
			$namaFile	= $_FILES['file_draft']['name'];
			$tempFile	= $_FILES['file_draft']['tmp_name'];			
			$upload		= "/pemda/upload/";
			$dirUpload  = $_SERVER['DOCUMENT_ROOT'].$upload.$namaFile;
			
			move_uploaded_file($tempFile, $dirUpload);
			
			$txt_no_nota	= $this->input->post('txt_nota_surat_kabag', TRUE);
			$txt_keterangan	= $this->input->post('txt_keterangan', TRUE);
			$data			= $this->pemda_model->save_draft($txt_no_nota, $txt_keterangan, $namaFile);
			
			echo 'true';
		}	

		/* Halaman Admin */
		function user()
		{
			$this->load->view('user_view');
		}
		
		function generate_user()
		{
			$data	= $this->pemda_model->generate_user()->result_array();
			echo json_encode($data);
		}
		
		function generate_admin_profile()
		{
			$user_id	= $this->input->post('user_id', TRUE);
			$data		= $this->pemda_model->generate_admin_profile($user_id)->row_array();
			
			echo json_encode($data);
		}

		function save_admin_profile()
		{
			$nama		= $this->input->post('nama', TRUE);
			$username	= $this->input->post('username', TRUE);
			$password	= md5($this->input->post('password', TRUE));
			$data		= $this->pemda_model->save_admin_profile($nama, $username, $password);
			
			echo json_encode($data);
		}
		
		function update_admin_profile()
		{
			$username	= $this->input->post('username', TRUE);
			$password	= md5($this->input->post('password', TRUE));
			$data		= $this->pemda_model->update_admin_profile($username, $password);
			
			echo json_encode($data);
		}
		
		function delete_admin_profile()
		{
			$user_id	= $this->input->post('user_id', TRUE);
			$data		= $this->pemda_model->delete_admin_profile($user_id);
			
			echo json_encode($data);
		}
		
		function group_menu()
		{
			$this->load->view('group_menu_view');
		}
		
		function generate_group_menu()
		{
			$data	= $this->pemda_model->generate_group_menu()->result_array();
			echo json_encode($data);
		}
		
		function update_admin_group_menu()
		{
			$txt_group_menu	= $this->input->post('txt_group_menu', TRUE);
			$txt_nama_group	= $this->input->post('txt_nama_group', TRUE);
			$txt_urut		= $this->input->post('txt_urut', TRUE);
			
			$data			= $this->pemda_model->update_admin_group_menu($txt_group_menu, $txt_nama_group, $txt_urut);
			
			echo json_encode($data);
		}
		
		function save_admin_group_menu()
		{
			$txt_group_menu	= $this->input->post('txt_group_menu', TRUE);
			$txt_nama_group	= $this->input->post('txt_nama_group', TRUE);
			$txt_urut		= $this->input->post('txt_urut', TRUE);
			$data			= $this->pemda_model->save_admin_group_menu($txt_group_menu, $txt_nama_group, $txt_urut);
			
			echo json_encode($data);
		}
		
		function generate_admin_group_menu()
		{
			$txt_id	= $this->input->post('txt_id', TRUE);
			$data		= $this->pemda_model->generate_admin_group_menu($txt_id)->row_array();
			
			echo json_encode($data);
		}

		function delete_admin_group_menu()
		{
			$txt_id	= $this->input->post('txt_id', TRUE);
			$data		= $this->pemda_model->delete_admin_group_menu($txt_id);
			
			echo json_encode($data);
		}
		
		function cek_group_menu_rows()
		{
			$txt_group_menu	= $this->input->post('txt_group_menu', TRUE);
			$data	= $this->pemda_model->cek_group_menu_rows($txt_group_menu)->num_rows();
			
			if($data == 0)
			{
				echo '0';
			}
			else
			{
				echo $data;
			}
		}
		
		function menu()
		{
			$this->load->view('menu_view');
		}
		
		function daftar_dinas()
		{
			$this->load->view('daftar_dinas_view');
		}
		
		function generate_daftar_dinas()
		{
			$data	= $this->pemda_model->generate_daftar_dinas()->result_array();
			echo json_encode($data);
		}
		
		function generate_admin_daftar_dinas()
		{
			$txt_id	= $this->input->post('txt_id', TRUE);
			$data		= $this->pemda_model->generate_admin_daftar_dinas($txt_id)->row_array();
			
			echo json_encode($data);
		}
		
		function delete_admin_daftar_dinas()
		{
			$txt_id	= $this->input->post('txt_id', TRUE);
			$data		= $this->pemda_model->delete_admin_daftar_dinas($txt_id);
			
			echo json_encode($data);
		}
		
		function update_admin_daftar_dinas()
		{
			$txt_unitkey	= $this->input->post('txt_unitkey', TRUE);
			$txt_kode_dinas	= $this->input->post('txt_kode_dinas', TRUE);
			$txt_nama_dinas		= $this->input->post('txt_nama_dinas', TRUE);
			
			$data			= $this->pemda_model->update_admin_daftar_dinas($txt_unitkey, $txt_kode_dinas, $txt_nama_dinas);
			
			echo json_encode($data);
		}
		
		function cek_daftar_dinas_rows()
		{
			$txt_unitkey	= $this->input->post('txt_unitkey', TRUE);
			$data	= $this->pemda_model->cek_daftar_dinas_rows($txt_unitkey)->num_rows();
			
			if($data == 0)
			{
				echo '0';
			}
			else
			{
				echo $data;
			}
		}
		
		function save_admin_daftar_dinas()
		{
			$txt_unitkey	= $this->input->post('txt_unitkey', TRUE);
			$txt_kode_dinas	= $this->input->post('txt_kode_dinas', TRUE);
			$txt_nama_dinas	= $this->input->post('txt_nama_dinas', TRUE);
			$data			= $this->pemda_model->save_admin_daftar_dinas($txt_unitkey, $txt_kode_dinas, $txt_nama_dinas);
			
			echo json_encode($data);
		}
		
		function logout()
		{
			$this->session->sess_destroy();
			$this->load->view('login_view');
		}
	}

?>