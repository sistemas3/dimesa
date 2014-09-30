<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Musuarios extends MY_Model {

	public $table;
	public $id;
	
	public function __construct()
	{

		$this->table = 'usuarios';
		$this->id = 'id';

		parent::__construct();
	}

	public function login($data=array())
	{
		$email = $data['email'];
		$password = $data['password'];

		$this->db->where('email', $email);
		$this->db->where('password', $password);

		$admin = $this->db->get($this->table)->row();

		if($admin) {
			return $admin;
		} else {
			return false;
		}

	}

}