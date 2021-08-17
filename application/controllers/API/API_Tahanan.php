<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
class API_Tahanan extends CI_Controller {
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

		$KodeTahanan = $this->input->post('KodeTahanan');
		$Kriteria = $this->input->post('Kriteria');

		$SQL = "SELECT * FROM ttahanan a
				where CONCAT(a.KodeTahanan,' ', a.NamaTahanan) LIKE '%$Kriteria%' 
				";

		if ($KodeTahanan != '') {
			$SQL .=" AND a.NamaTahanan = '$NamaTahanan'";
		}

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}

	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$KodeTahanan = $this->input->post('KodeTahanan');
		$NamaTahanan = $this->input->post('NamaTahanan');
		$AsalTahanan = $this->input->post('AsalTahanan');
		$TglMasuk = $this->input->post('TglMasuk');
		$LamaTahanan = $this->input->post('LamaTahanan');
		$KodeLokasi = $this->input->post('KodeLokasi');
		$StatusTahanan = $this->input->post('StatusTahanan');
		$NamaLokasi = $this->input->post('NamaLokasi');
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeTahanan' => $KodeTahanan,
			'NamaTahanan' => $NamaTahanan,
			'AsalTahanan' => $AsalTahanan,
			'TglMasuk' => $TglMasuk,
			'LamaTahanan' => $LamaTahanan,
			'KodeLokasi' => $KodeLokasi,
			'StatusTahanan' => $StatusTahanan,
			'NamaLokasi'	=> $NamaLokasi
		);


		if ($formtype == 'add') {
			$rs = $this->ModelsExecuteMaster->ExecInsert($param,'ttahanan');
			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$data['message'] = 'Gagal Input Lokasi';
			}
		}
		elseif ($formtype == 'edit') {
			$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeTahanan'=>$KodeTahanan),'ttahanan');
			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$data['message'] = 'Gagal Input Lokasi';
			}
		}
		elseif ($formtype == 'delete') {
			$SQL = "DELETE FROM ttahanan where KodeTahanan = '$KodeTahanan' ";

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

	public function ReadPerLocation()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$KodeLokasi = $this->input->post('KodeLokasi');

		$SQL = "
			SELECT 
				a.KodeTahanan, a.NamaTahanan,
				a.KodeLokasi, b.NamaLokasi,
				SUM(CASE WHEN c.Transaksi = 1 THEN 1 ELSE 0 END) CheckIn,
				SUM(CASE WHEN c.Transaksi = 2 THEN 1 ELSE 0 END) CheckOut
			FROM ttahanan a
			LEFT JOIN tlokasi b on a.KodeLokasi = b.KodeLokasi
			LEFT JOIN loglokasi c on a.KodeTahanan = c.KodeTahanan
			WHERE b.KodeLokasi LIKE '%$KodeLokasi%'
			GROUP BY a.KodeTahanan, a.KodeLokasi
		";

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}
}