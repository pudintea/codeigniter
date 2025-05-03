<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Data_json extends CI_Controller {

	protected $data;
	function __construct(){
		parent::__construct();
		$this->data = [];
	}
	
  public function ClassNama()		{ return 'data_json'; }
  public function Author()		 { return 'Pudin Saepudin'; }

  function data_json()
  	{
  		//if($this->input->method(TRUE)=='POST'): // Hanya lewat metode post saja yang di izinkan melihat dan mengambil data
  		
  			$csrf_name = $this->security->get_csrf_token_name();
  			$csrf_hash = $this->security->get_csrf_hash();
  				
  			$tabel = 't_pegawai';
  			$column_order = array('', '', 'emp_code','first_name','department');
  			$column_search = array('emp_code','first_name','department','area');
  			$order = array('first_name' => 'ASC');
  			//$where = array('admin_level' => 'Operator');
  				
  				$this->load->model('dt/DatatablesModel' ,'M_najzmi');
  				$list = $this->M_najzmi->get_datatables($tabel,$column_order,$column_search,$order);
  				$data = array();
  				$no = isset($_POST['start']) 	? $_POST['start'] 	: 1;
  				
  				foreach ($list as $pDn) {
  					$no++;
  					$row = array();
  					$row[] = '<a href="'.base_url($this->ClassNama()).'/presensi/'.base64_encode($pDn->emp_code).'" class="btn btn-primary btn-circle btn-sm" title="Presensi"><i class="fas fa-search"></i></a>';
  					$row[] = $no;
  					$row[] = $pDn->emp_code;
  					$row[] = $pDn->first_name;
  					$row[] = $pDn->department;
  					
  					$data[] = $row;
  				}
  				
  				
  				$output = array(
  								"draw" => isset($_POST['draw']) 	? $_POST['draw'] 	: 'null',
  								"recordsTotal" => $this->M_najzmi->count_all($tabel,$column_order,$column_search,$order),
  								"recordsFiltered" => $this->M_najzmi->count_filtered($tabel,$column_order,$column_search,$order),
  								"data" => $data,
  						);
  				$output[$csrf_name] = $csrf_hash;
  				//output to json format
  				header('Content-type: application/json');
  				echo json_encode($output);
  			// End Json
  		//endif;
  	}
}
