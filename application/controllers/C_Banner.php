<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Banner extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
		$this->load->model('LoginMod');
	}

	public function Read()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id 		= $this->input->post('id');
		if ($id == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('IsActive'=>1),'tbanner');
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodePromo'=>$id,'IsActive'=>1),'tbanner');
		}

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		ini_set('memory_limit', '1000M');
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');

		$data = array('success' => false ,'message'=>array(),'KodePromo' => '');

		$id = $this->input->post('id');
		$KodePromo = $this->input->post('KodePromo');
		$NamaPromo = $this->input->post('NamaPromo');
		$Deskripsi = $this->input->post('Deskripsi');
		$ImageLink = $this->input->post('ImageLink');
		$LinkToEntities = $this->input->post('LinkToEntities');
		$EntitiesType = $this->input->post('EntitiesType');
		$EntitiesAddress = $this->input->post('EntitiesAddress');
		$IsActive = $this->input->post('IsActive');
		$picture_base64 = $this->input->post('picture_base64');
		$formtype = $this->input->post('formtype');

		$picture_ext = '';
		$LinkToEntities = 0;
		// Upload Image
		try {
			unset($config); 
			$date = date("ymd");
	        $config['upload_path'] = './localData/Banner';
	        $config['max_size'] = '60000';
	        $config['allowed_types'] = 'png|jpg|jpeg|gif';
	        $config['overwrite'] = TRUE;
	        $config['remove_spaces'] = TRUE;
	        $config['file_ext_tolower'] = TRUE;
	        $config['file_name'] = strtolower(str_replace(' ', '', $KodePromo));

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);

	        if(!$this->upload->do_upload('Attachment')) {
	        	if ($formtype == 'edit' || $formtype == 'delete' || $formtype == 'Publish') {
	        		$x='';
	        	}
	        	else{
	        		$x = $this->upload->data();
		        	// var_dump($x);
		        	$data['success'] = false;
		            $data['message'] = $this->upload->display_errors();
		            goto jumpx;
	        	}
	        }else{
	            $dataDetails = $this->upload->data();
	            $picture_ext = $dataDetails['file_ext'];
	            if ($picture_ext == '.jpeg') {
	            	$picture_ext = '.jpg';
	            }
	        }	
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = $e->getMessage();
			goto jumpx;
		}

		if ($formtype == 'add' || $formtype == 'edit') {
			$pos  = strpos($picture_base64, ';');
			$type = explode(':', substr($picture_base64, 0, $pos))[1];
			$extension = explode('/', $type)[1];
		}
		if ($extension == 'jpeg') {
			$picture_ext = '.jpg';
		}

		$param = array(
			'KodePromo' => $KodePromo,
			'NamaPromo' => $NamaPromo,
			'Deskripsi' => $Deskripsi,
			'ImageLink' => base_url().'localData/Banner/'.strtolower(str_replace(' ', '', $KodePromo)).''.strtolower($picture_ext),
			'LinkToEntities' => $LinkToEntities,
			'EntitiesType' => $EntitiesType,
			'EntitiesAddress' => $EntitiesAddress,
			'IsActive' => 1,
			'CreatedOn' => date("Y-m-d h:i:sa"),
			'ImageBase64'	=> $picture_base64
		);

		if ($formtype == "add") {
			$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tbanner');
			if ($call_x) {
				$this->db->trans_commit();
				$data['success'] = true;
			}
			else{
				$undone = $this->db->error();
				$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
			}
		}
		elseif ($formtype == "edit") {
			$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodePromo'=> $KodePromo),'tbanner');
				if ($rs) {
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
		}
		elseif ($formtype == "delete") {
			try {
				$SQL = "UPDATE ".'tbanner'." SET IsActive = 0 WHERE KodePromo = '".$id."'";
				// var_dump($SQL);
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		jumpx:
		echo json_encode($data);
	}
}