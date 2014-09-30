<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_by($field='', $value='')
	{
		$this->db->where($field, $value);
		$result = $this->db->get($this->table)->row();
		return $result;
	}

	public function get_all($field='', $value='')
	{
		if(!empty($field) AND !empty($value)) {
			$this->db->where($field, $value);
		}	
		$result = $this->db->get($this->table)->result();
		return $result;
	}

	public function get_all_by($field='', $value='')
	{
		if(!empty($field) AND !empty($value)) {
			$this->db->where($field, $value);
		}	
		$result = $this->db->get($this->table)->result();
		return $result;
	}

	public function insert($data=array())
	{
		$this->db->insert($this->table, $data);
		return $this;
	}

	public function delete($conditions=array())
	{
		$this->db->delete($this->table, $conditions);
		return $this;
	}

	public function update($data=array(), $conditions=array())
	{
		$this->db->update($this->table, $data, $conditions);
		return $this;
	}

}