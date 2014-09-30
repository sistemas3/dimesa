<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Private_Controller extends CI_Controller {
	
	public $admin = false;

	public function __construct()
	{
		parent::__construct();
		
		// Para que no se ejecute el Hook de URLs relativas
		$this->config->set_item('is_admin', true);
		
		$this->admin = false;
		if( $this->session->userdata('admin') ) {
			$this->admin = $this->session->userdata('admin');
		}
		
		$this->template->set_layout('private');
		$this->template->set_partial('flashmessages', 'partials/flashmessages');

		$this->form_validation->set_message('required', 'El campo <strong>%s</strong> es obligatorio.');
		$this->form_validation->set_message('valid_email', 'El campo <strong>%s</strong> no contiene una direcci&oacute;n de correo valida.');
		$this->form_validation->set_message('matches', 'El campo <strong>%s</strong> no coincide con <strong>%s</strong>');
		$this->form_validation->set_message('is_unique', 'El correo que ha ingresado ya se encuentra registrado.');
	}
	
	public function is_logged()
	{
		if(!$this->admin) {
			$redirect = uri_string() . $_SERVER['QUERY_STRING'];
			$redirect = base64_encode($redirect);
			//echo '/admin/usuarios/login?redirect=' . $redirect;exit;
			redirect('/admin/usuarios/login?redirect=' . $redirect);
		} else {
			return true;
		}
	}
}

class Public_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			
		$this->template->set_layout('public');
		$this->template->set_partial('flashmessages', 'partials/flashmessages');
		$this->template->set_partial('header', 'partials/header');
		$this->template->set_partial('footer', 'partials/footer');

		$this->form_validation->set_message('required', 'El campo <strong>%s</strong> es obligatorio.');
		$this->form_validation->set_message('valid_email', 'El campo <strong>%s</strong> no contiene una direcci&oacute;n de correo valida.');
		$this->form_validation->set_message('matches', 'El campo <strong>%s</strong> no coincide con <strong>%s</strong>');
		$this->form_validation->set_message('is_unique', 'El correo que ha ingresado ya se encuentra registrado.');
	}
}
