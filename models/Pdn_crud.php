<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Pdn_crud extends CI_Model
{
	function __construct(){
		parent::__construct();
	}

	/**
     * return _retval
     *
     * @var Boolean
     **/
    private $_retval = NULL;

    /**
     * return _result
     *
     * @var Boolean
     **/
    private $_result = FALSE;

    /**
     * return _retarr
     *
     * @var Array
     **/
    private $_retarr = array();
	
    /**
     * SAVE
     * $this->Pdn_crud->save($nama_tb, $save_data)
    **/

    function save($nama_tb='', $save_data='')
    {
        $this->_result = $this->db->insert($nama_tb, $save_data);

        if ($this->_result) {
            return $this->_result;
        }
    }

    /**
     * RESULT
     * $this->Pdn_crud->result($nama_tb)
    **/

    function result($nama_tb='')
    {
        if($nama_tb){
            $this->_result = $this->db->get($nama_tb)->result();

            if ($this->_result) {
                return $this->_result;
            }
        }
    }

    /**
     * RESULT WHERE
     * $this->Pdn_crud->result_where($nama_tb, $nama_where, $where)
    **/

    function result_where($nama_tb='', $nama_where='', $where='')
    {
        if(!empty($nama_tb) || !empty($nama_where) || !empty($where)){
            $this->db->where($nama_where, $where);
            $this->_result = $this->db->get($nama_tb)->result();

            if ($this->_result) {
                return $this->_result;
            }
        }
    }

    /**
     * RESULT WHERE ORDERBY
     * $this->Pdn_crud->result_where_orderby($nama_tb, $nama_where, $where, $nama_orderby, $orderby)
    **/

    function result_where_orderby($nama_tb='', $nama_where='', $where='', $nama_orderby='', $orderby='ASC')
    {
        if(!empty($nama_tb) || !empty($nama_where) || !empty($where)){
            $this->db->where($nama_where, $where);
            $this->db->order_by($nama_orderby, $orderby);
            $this->_result = $this->db->get($nama_tb)->result();

            if ($this->_result) {
                return $this->_result;
            }
        }
    }

    /**
     * RESULT ORDERBY
     * $this->Pdn_crud->result_orderby($nama_tb, $nama_orderby, $orderby)
     * ASC, DESC AND RANDOM. Default ASC
    **/

    function result_orderby($nama_tb='', $nama_orderby='', $orderby='ASC')
    {
        if(!empty($nama_tb) || !empty($nama_orderby)){
            $this->db->order_by($nama_orderby, $orderby);
            $this->_result = $this->db->get($nama_tb)->result();

            if ($this->_result) {
                return $this->_result;
            }
        }
    }

    /**
     * ROW
     * $this->Pdn_crud->row($_id, $nama_id, $nama_tb)
    **/

    function row($_id ='', $nama_id ='', $nama_tb='')
	{
		if (empty($_id) || empty($nama_id) || empty($nama_tb)) {
            return false;
        }

		$this->db->where($nama_id, $_id);
		$this->_result = $this->db->get($nama_tb)->row();
		
		if ($this->_result) {
            return $this->_result;
        }
	}

    /**
     * GET LAST (Menampilkan Data Terakhir) ID Paling Besar
     * $this->Pdn_crud->get_last($dbName, $idName)
    **/

    public function get_last($dbName='', $idName='')
    {
        if (empty($dbName) || empty($idName)) {
            return false;
        }else{
            return $this->db
            ->order_by($idName, 'DESC')
            ->limit(1)
            ->get($dbName)
            ->row(); // Mengambil 1 baris data
        }
    }
	
    /**
     * EDIT
     * $this->Pdn_crud->edit($_id, $nama_id, $nama_tb)
    **/
	
	function edit($_id ='', $nama_id ='', $nama_tb='')
	{
		if (empty($_id) || empty($nama_id) || empty($nama_tb)) {
            return false;
        }

		$this->db->where($nama_id, $_id);
		$this->_result = $this->db->get($nama_tb)->row();
		
		if ($this->_result) {
            return $this->_result;
        }
	}
	
	/**
     * UPDATE
     * $this->Pdn_crud->update($_id, $nama_id, $nama_tb, $update_data)
    **/

    function update($_id ='', $nama_id ='', $nama_tb='', $update_data='')
    {
        if (empty($_id) || empty($nama_id) || empty($nama_tb) || empty($update_data)) {
            return false;
        }

        $this->db->where($nama_id, $_id);
        $this->_result = $this->db->update($nama_tb, $update_data);

        if ($this->_result) {
            return $this->_result;
        }
    }


    /**
     * DELETE
     * $this->Pdn_crud->delete($_id, $nama_id,$nama_tb)
    **/
	
	function delete($_id='', $nama_id='',$nama_tb='')
    {
        if (empty($_id) || empty($nama_id) || empty($nama_tb)) {
            return false;
        }

        $this->db->where($nama_id, $_id);
        $this->_result = $this->db->delete($nama_tb);

        if ($this->_result) {
            return $this->_result;
        }
    }
	
}

// Pudin Saepudin , Application/models/Pdn_crud.php 
