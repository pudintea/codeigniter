<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Data_postgree extends CI_Controller {

	protected $data;
	function __construct(){
		parent::__construct();
		$this->data = [];
		$this->pudin_dev->pdn_is_login();
		$this->pudin_dev->pdn_is_admin();
		$this->load->model('Api_models','Pdn_api');
	}
	
  public function ClassNama()		{ return 'data_postgree'; }
  public function Author()		{ return 'Pudin Saepudin'; }

  function data_json()
	{
		if($this->input->method(TRUE)=='POST'): // Hanya lewat metode post saja yang di izinkan melihat dan mengambil data
		
			$csrf_name = $this->security->get_csrf_token_name();
			$csrf_hash = $this->security->get_csrf_hash();
			$emp_code = base64_decode($this->input->post('emp_code'));
				
			$tabel = 'v_presensi';
			$column_order = array('', 'tanggal','tanggal','jam_kedatangan','jam_kepulangan','jumlah_jam','lokasi');
			$column_search = array('tanggal','jam_kedatangan','jam_kepulangan','jumlah_jam','lokasi');
			$date_fields = ['tanggal']; // tentukan fields yang isinya tanggal
			$order = array('tanggal' => 'DESC');
			$where = array('emp_code' => $emp_code);
				
				$this->load->model('postgree/Where_DatatablesModel' ,'M_najzmi');
				$list = $this->M_najzmi->get_datatables($tabel,$column_order,$column_search,$order,$date_fields,$where);
				$data = array();
				$no = isset($_POST['start']) 	? $_POST['start'] 	: 1;
				
				foreach ($list as $pDn) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = nama_hari($pDn->tanggal);
					$row[] = pdn_tanggal($pDn->tanggal);
					$row[] = $pDn->jam_kedatangan;
					$row[] = $pDn->jam_kepulangan;
					$row[] = $pDn->jumlah_jam;
					$row[] = $pDn->lokasi;
					
					$data[] = $row;
				}
				
				$output = array(
								"draw" => isset($_POST['draw']) 	? $_POST['draw'] 	: 'null',
								"recordsTotal" => $this->M_najzmi->count_all($tabel,$column_order,$column_search,$order,$where),
								"recordsFiltered" => $this->M_najzmi->count_filtered($tabel,$column_order,$column_search,$order,$date_fields,$where),
								"data" => $data,
						);
				$output[$csrf_name] = $csrf_hash;
				//output to json format
				header('Content-type: application/json');
				echo json_encode($output);
			// End Json
		endif;
	}

}
