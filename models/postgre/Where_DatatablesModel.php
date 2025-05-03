<?php if ( ! defined('__PUDINTEA__')) exit('No direct script access allowed');
/**
*
* Author:  Pudin Saepudin
* https://t.me/pudin_ira
* pudin.alazhar@gmail.com
*
*/

class Where_DatatablesModel extends CI_Model
{
  function __construct(){
		parent::__construct();
	}
  
	private function _get_datatables_query($table, $column_order, $column_search, $order, $date_fields, $where)
	{
		$this->db->from($table);

		if (!empty($where)) {
			$this->db->where($where);
		}

		$search_value = $_POST['search']['value'] ?? null;

		if (!empty($search_value)) {
			$this->db->group_start();
			foreach ($column_search as $item) {
				if (in_array($item, $date_fields)) {
					$this->db->or_where("CAST(\"$item\" AS TEXT) ILIKE", "%$search_value%");
				} else {
					$this->db->or_like($item, $search_value, 'both', false);
				}
			}
			$this->db->group_end();
		}

		if (isset($_POST['order'])) {
			$col_idx = $_POST['order'][0]['column'];
			$dir = $_POST['order'][0]['dir'];
			if (!empty($column_order[$col_idx])) {
				$this->db->order_by($column_order[$col_idx], $dir);
			}
		} elseif (!empty($order)) {
			foreach ($order as $key => $val) {
				$this->db->order_by($key, $val);
			}
		}
	}

	public function get_datatables($table, $column_order, $column_search, $order, $date_fields = [], $where = [])
	{
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $date_fields, $where);
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		return $this->db->get()->result();
	}

	public function count_filtered($table, $column_order, $column_search, $order, $date_fields = [], $where = [] )
	{
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $date_fields, $where);
		return $this->db->get()->num_rows();
	}

	public function count_all($table, $where = [])
	{
		$this->db->from($table);
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				if (!is_string($key)) continue; // hindari key numerik
				if ($val !== '' && $val !== null) {
					$this->db->where($key, $val);
				}
			}
		}
		return $this->db->count_all_results();
	}
}

// Pudin Saepudin
