<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transaksi extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
		$this->load->model('LoginMod');
	}
	public function GetPembayaranList()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$TglAwal = $this->input->post('Tglawal');
		$TglAkhir = $this->input->post('TglAkhir');
		$Metode = $this->input->post('Metode');
		$NoTransaksi = $this->input->post('NoTransaksi');

		$SQL = "";

		if ($Metode == 'MANUAL') {
			$SQL = "CALL getPaymentDetails('".$TglAwal."','".$TglAkhir."','".$Metode."','".$NoTransaksi."')";
		}
		else{
			$SQL = "CALL getPaymentDetails_Auto('".$TglAwal."','".$TglAkhir."')";
		}
		// var_dump($SQL);
		try {
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = false;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = $e->getMessage();
		}
		echo json_encode($data);

	}
	public function konfirmasiPembelian()
	{
		$data = array('success' => false ,'message'=>array(),'imageurl'=>array());
		$NoTransaksi = $this->input->post('NoTransaksi');

		$rs = $this->ModelsExecuteMaster->ExecUpdate(array('Mid_TransactionStatus'=>'settlement'),array('NoTransaksi'=> $NoTransaksi),'topuppayment');
		if ($rs) {
			$data['success'] = true;
		}
		else{
			$data['message'] = 'Gagal Update Password';
		}
		echo json_encode($data);
	}

	public function getSaldoPerAccount()
	{
		$data = array('success' => false ,'message'=>array());
		$UserID = $this->input->post('UserID');

		$SQL = "";

		$SQL = "CALL getSaldoUser('".$UserID."')";
		try {
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = false;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = $e->getMessage();
		}
		echo json_encode($data);
	}
	public function addAdjustment()
	{
		$data = array('success' => false ,'message'=>array());
		$NoTransaksi = "";
		$Kolom = 'NoTransaksi';
		$Table = 'adjustmenthistory';
		$Prefix = strval(date('Y',strtotime(date("Y-m-d"))).''.date('m',strtotime(date("Y-m-d"))));

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),5)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 5,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$NoTransaksi = $nomor;
		}

		
		$TglTransaksi = date("Y-m-d");
		$TglPencatatan = date("Y-m-d h:i:sa");
		$KodeUser = $this->input->post('KodeUser');
		$TypeAdjustment = $this->input->post('TypeAdjustment');
		$TotalAdjustment = $this->input->post('TotalAdjustment');
		$CreatedBy =  $this->session->userdata('username');
		$Createdon = date("Y-m-d h:i:sa");
		$Keterangan = $this->input->post('Keterangan');

		$param = array(
			'NoTransaksi' => $NoTransaksi,
			'TglTransaksi' => $TglTransaksi,
			'TglPencatatan' => $TglPencatatan,
			'KodeUser' => $KodeUser,
			'TypeAdjustment' => $TypeAdjustment,
			'TotalAdjustment' => str_replace(',', '', $TotalAdjustment),
			'CreatedBy' => $CreatedBy,
			'Createdon' => $Createdon,
			'Keterangan' => $Keterangan
		);
		try {
			$rs = $this->ModelsExecuteMaster->ExecInsert($param,'adjustmenthistory');
			if($rs){
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
		echo json_encode($data);
	}
	public function ReadTransaksi()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$tglAwal = $this->input->post('Tglawal');
		$tglAkhir= $this->input->post('TglAkhir');

		$SQL = "CALL getTransaksi('".$tglAwal."','".$tglAkhir."')";

		try {
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}
		echo json_encode($data);
	}
	public function removeAccess()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NoTransaksi = $this->input->post('NoTransaksi');

		try {
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('StatusTransaksi'=>'99'),array('NoTransaksi'=>$NoTransaksi),'transaksi');
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}

		echo json_encode($data);
	}
}
