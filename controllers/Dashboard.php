<?php
defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	protected $data;
	function __construct()
	{
		parent::__construct();
		$this->data = [];
		date_default_timezone_set('Asia/Jakarta');
		$this->pudin_dev->pdn_is_login();
		$this->pudin_dev->pdn_is_admin();
	}

	public function author()	{return 'Pudin Saepudin';}
	public function MainModel()	{return 'Dashboard_Models';}
	public function contact()	{return 'pudin.alazhar@gmail.com';}
	public function ClassNama()	{return 'dashboard';}

	public function index()
	{
		$this->load->model($this->MainModel(), 'Dashboard');
		$pegawai 	= $this->Dashboard->count_data('id_pegawai','t_pegawai');
		$presensi 	= $this->Dashboard->count_data('id','t_presensi');

		$this->data['jml_pegawai'] 		= $pegawai;
		$this->data['jml_presensi'] 	= $presensi;
		$this->data['pdn_title'] 		= 'Dashboard';
		$this->data[$this->ClassNama()] = 'active';
		$this->template->pdn_load('template/sbadmin',$this->ClassNama().'/dashboard',$this->ClassNama().'/kode',$this->data);
	}

	function grafik_bulanan(){
		$this->load->model($this->MainModel(), 'Dashboard');
		$data_grafik = $this->Dashboard->grafik_bulanan(); // RESULT
		$respon = array();
		if (is_array($data_grafik) || is_object($data_grafik)) {
			foreach ($data_grafik as $row){
				$respon[] = array(
					'bulan' => $row->bulan,
					'jumlah' => $row->jumlah_hari_hadir
				);
			}
		}
		//output to json format
		header('Content-type: application/json');
		echo json_encode($respon);
	}
}
