<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends Private_Controller {

	public function index()
	{
		self::is_logged();
		redirect('admin/notas');
	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Correo Electr&oacute;nico', 'required');
		$this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'required');

		if(!empty($_POST)) {

			if($this->form_validation->run()) {
				$admin = $this->musuarios->login($_POST);
				if($admin) {
					$this->session->set_userdata('admin', $admin);
					redirect_to();
				} else {
					set_flashmessage('error', 'Datos incorrectos, intentelo de nuevo.');
				}
			} else {
				set_flashmessage('error', validation_errors());
			}
		}

		$this->template->build('admin/usuarios/login');
	}

	public function logout()
	{
		$this->session->unset_userdata('admin');
		redirect_to();
	}
	
	public function manage()
	{
		self::is_logged();
		
		if(!is_admin()) {
			redirect('admin');
		}
		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('direnet');
			$crud->set_language('spanish');
			$crud->set_table('usuarios');
			$crud->set_subject('Usuarios');
			$crud->unset_export();
			$crud->unset_print();
			
			$crud->required_fields(array(
			'nombre',
			'email',
			'password',
			'tipo'
			));
			
			$crud->columns(array(
			'nombre',
			'email',
			'tipo',
			'seccion_id'
			));
			
			$seccion_admin = seccion_admin();
			if($seccion_admin) {
				$crud->where('usuarios.seccion_id', $seccion_admin);
			}
			
			
			
			$crud->set_relation('seccion_id', 'secciones', 'nombre');
			$crud->display_as('seccion_id', 'Sección');
			
			
			//$crud->callback_column('seccion_id',array($this,'seccion_cb'));
			
			
			$crud->callback_before_insert(array($this,'encriptar_password'));
			$crud->callback_before_update(array($this,'encriptar_password'));
			$crud->callback_add_field('password',array($this,'limpiar_password'));
			
			if( strrpos(uri_string(), "edit") ) {
				$crud->callback_edit_field('password',array($this,'limpiar_password'));
			}
			
			if( strrpos(uri_string(), "read") ) {
				$crud->unset_fields('password');
			}
			
			
			$output = $crud->render();
			
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

		$this->template->build('admin/usuarios/manage', $output);
	}

	public function seccion_cb($value, $row)
	{
		if($row->seccion_id==null or $row->seccion_id==0) {
			return 'Todas las secciones';
		} else {
			return get_field_name('secciones', 'nombre', $row->seccion_id);
		}
	}
	

	public function encriptar_password($post_array) {
		
		if($post_array['tipo']=='editor' and empty($post_array['seccion_id'])) {
			
			if($post_array['tipo']=='editor' and empty($post_array['seccion_id'])) {
				$crud->required_fields(array(
				'nombre',
				'email',
				'password',
				'tipo',
				'seccion_id'
				));
				return false;
			}
		}

	    $post_array['password'] = sha1(md5($post_array['password']));
	    return $post_array;
	}  

	public function limpiar_password($value = '', $primary_key = null)
	{
	    return '<input type="text" value="" name="password">';
	}
}