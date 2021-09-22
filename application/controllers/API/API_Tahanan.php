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
			$SQL .=" AND a.KodeTahanan = '$KodeTahanan'";
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
		$Attachment = $this->input->post('Attachment');

		$image = $this->input->post('baseimage');
		$imagename = $this->input->post('imagename');
		$fulllink = '';

		if ($imagename != '') {
			 $temp = base64_decode($image);
			$link = 'localData/images/'.$imagename;


			try {
				file_put_contents($link, $temp);	
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}

			$fulllink = base_url().$link;
		}
		
		if ($fulllink == '') {
			$fulllink = $Attachment;
		}
		else{
			$fulllink = $fulllink;
		}
		
		$param = array(
			'KodeTahanan' => $KodeTahanan,
			'NamaTahanan' => $NamaTahanan,
			'AsalTahanan' => $AsalTahanan,
			'TglMasuk' => $TglMasuk,
			'LamaTahanan' => $LamaTahanan,
			'KodeLokasi' => $KodeLokasi,
			'StatusTahanan' => $StatusTahanan,
			'NamaLokasi'	=> $NamaLokasi,
			'Attachment'	=> $fulllink 
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
		$Tanggal = $this->input->post('Tanggal');

		// $SQL = "
		// 	SELECT 
		// 		a.KodeTahanan, a.NamaTahanan,
		// 		c.KodeLokasi, b.NamaLokasi,
		// 		COALESCE(a.Attachment,'') Attachment,
		// 		SUM(CASE WHEN c.Transaksi = 1 THEN 1 ELSE 0 END) CheckIn,
		// 		SUM(CASE WHEN c.Transaksi = 2 THEN 1 ELSE 0 END) CheckOut
		// 	FROM ttahanan a
		// 	LEFT JOIN loglokasi c on a.KodeTahanan = c.KodeTahanan
		// 	LEFT JOIN tlokasi b on c.KodeLokasi = b.KodeLokasi
		// 	AND CAST(c.TanggalTransaksi AS DATE) = CAST('$Tanggal' AS DATE ) 
		// ";

		$SQL = "
			SELECT 
				a.KodeTahanan, a.NamaTahanan,
				COALESCE(b.KodeLokasi, a.KodeLokasi) KodeLokasi,
				COALESCE(a.Attachment,'') Attachment,
				SUM(CASE WHEN b.Transaksi = 1 THEN 1 ELSE 0 END) CheckIn,
				SUM(CASE WHEN b.Transaksi = 2 THEN 1 ELSE 0 END) CheckOut
			FROM ttahanan a 
			LEFT JOIN loglokasi b on a.KodeTahanan = b.KodeTahanan 
		";

		if ($KodeLokasi != '') {
			$SQL .= " WHERE COALESCE(b.KodeLokasi, a.KodeLokasi) = '$KodeLokasi' ";
		}
		$SQL .= " GROUP BY a.KodeTahanan, c.KodeLokasi";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}
	public function ScanQR()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());
		$id = 0;
		$Transaksi = $this->input->post('Transaksi');
		$KodeLokasi = $this->input->post('KodeLokasi');
		$KodeTahanan = $this->input->post('KodeTahanan');
		$TanggalTransaksi = date("Y-m-d h:i:sa");

		$param = array(
			'id' => $id,
			'Transaksi' => $Transaksi,
			'KodeLokasi' => $KodeLokasi,
			'KodeTahanan' => $KodeTahanan,
			'TanggalTransaksi' => $TanggalTransaksi,
		);

		$rs = $this->ModelsExecuteMaster->ExecInsert($param,'loglokasi');

		if ($rs) {
			$data['success'] = true;
		}

		echo json_encode($data);
	}
	public function readLog()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$Tanggal = $this->input->post('Tanggal');
		$KodeTahanan = $this->input->post('KodeTahanan');

		$SQL = "SELECT a.*, b.NamaLokasi FROM loglokasi a 
				LEFT JOIN tlokasi b on a.KodeLokasi= b.KodeLokasi
				where CAST(a.TanggalTransaksi AS DATE) = '$Tanggal'
				AND a.KodeTahanan = '$KodeTahanan' ORDER BY a.KodeLokasi, a.TanggalTransaksi
				";

		$rs = $this->db->query($SQL);
		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}
}