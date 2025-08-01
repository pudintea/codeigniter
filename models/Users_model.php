<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}

    /**
     * NAMA TABLE
     *
     * @var TEXT
     **/
    private $_namaTb = 'users';

    /**
     * ID TABLE
     *
     * @var TEXT
     **/
    private $_idTable = 'id_users';

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
    **/

    function save($save_data='')
    {
        if($save_data){
            $this->_result = $this->db->insert($this->_namaTb, $save_data);
            if ($this->_result) {
                return $this->_result;
            }
        }else{
            return false;
        }
    }
	
    /**
     * TAMPILKAN SATU DATA
    **/
	
	function find($_id ='')
	{
		if (empty($_id)) {
            return false;
        }

		$this->db->where($this->_idTable, $_id);
		$this->_result = $this->db->get($_namaTb)->row();
		
		if ($this->_result) {
            return $this->_result;
        }
	}

    /**
     * TAMPILKAN SATU EMAIL
    **/
	
	function findEmail($_email ='')
	{
		if (empty($_email)) {
            return false;
        }

		$this->db->where('users_email', $_email);
		$this->_result = $this->db->get($_namaTb)->num_rows();
		
		if ($this->_result) {
            return $this->_result;
        }
	}

    /**
     * TAMPILKAN SEMUA DATA
    **/
	
	function findAll()
	{
		$this->_result = $this->db->get($_namaTb)->row();
		if ($this->_result) {
            return $this->_result;
        }
	}
	
	/**
     * UPDATE
    **/

    function update($_id ='', $update_data='')
    {
        if (empty($_id) || empty($update_data)) {
            return false;
        }

        $this->db->where($this->_idTable, $_id);
        $this->_result = $this->db->update($this->_namaTb, $update_data);

        if ($this->_result) {
            return $this->_result;
        }
    }

    /**
     * DELETE
    **/
	
	function delete($_id='')
    {
        if (empty($_id)) {
            return false;
        }

        $this->db->where($this->_idTable, $_id);
        $this->_result = $this->db->delete($this->_namaTb);

        if ($this->_result) {
            return $this->_result;
        }
    }
	
}

// Pudin Saepudin , Application/models/Users_model.php 

