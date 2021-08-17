<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
class API_Lokasi extends CI_Controller {
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
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$KodeLokasi = $this->input->post('KodeLokasi');
		$Kriteria = $this->input->post('Kriteria');

		$SQL = "SELECT a.*,COALESCE(b.Jml,0) Jml FROM tlokasi a
				LEFT JOIN (
					SELECT x.KodeLokasi, COUNT(*) Jml FROM ttahanan x
					GROUP BY x.KodeLokasi
				) b on a.KodeLokasi = b.KodeLokasi 
				where CONCAT(a.KodeLokasi,' ', a.NamaLokasi) LIKE '%$Kriteria%' 
				";

		if ($KodeLokasi != '') {
			$SQL .=" AND a.KodeLokasi = '$KodeLokasi'";
		}

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}

	public function getLookup()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$Kriteria = $this->input->post('Kriteria');

		$SQL = "SELECT a.KodeLokasi ID, a.NamaLokasi Title FROM tlokasi a
				where CONCAT(a.KodeLokasi,' ', a.NamaLokasi) LIKE '%$Kriteria%' AND AreaUmum = 0
				";

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
		}
		echo json_encode($rs->result());
	}

	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$KodeLokasi = $this->input->post('KodeLokasi');
		$NamaLokasi = $this->input->post('NamaLokasi');
		$AreaUmum = $this->input->post('AreaUmum');
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeLokasi' => $KodeLokasi,
			'NamaLokasi' => $NamaLokasi,
			'AreaUmum' => $AreaUmum,
		);


		if ($formtype == 'add') {
			$rs = $this->ModelsExecuteMaster->ExecInsert($param,'tlokasi');
			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$data['message'] = 'Gagal Input Lokasi';
			}
		}
		elseif ($formtype == 'edit') {
			$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeLokasi'=>$KodeLokasi),'tlokasi');
			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$data['message'] = 'Gagal Input Lokasi';
			}
		}
		elseif ($formtype == 'delete') {
			$SQL = "DELETE FROM tlokasi where KodeLokasi = '$KodeLokasi' ";

			$rs = $this->db->query($SQL);

			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$data['message'] = 'Gagal Delete Lokasi';
			}
		}
		else{
			$data['success'] = false;
			$data['message'] = 'Invalid Form Type';
		}

		echo json_encode($data);
	}
}